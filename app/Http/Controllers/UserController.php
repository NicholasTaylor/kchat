<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Models\Preference;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return view('users.index', [
            'users' => $users
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $validated = validateUser($request);
        $validated['status'] = 'active';
        User::create($this->$validated->all());
        return view('users.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return view('users.show', [
            'user' => $user
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('users.edit', [
            'user' => $user,
            'userRole' => $user->roles->pluck('name')->toArray(),
            'roles' => Role::latest()->get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $validated = validateUser($request);
        $user->update($validated);
        $user->syncRoles($request->get('role'));
        return view('users.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return view('users.index');
    }

    protected function validateUser($request)
    {
        $validateArr = [
            'username' => ['required', 'string', 'max:128', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:256', 'unique:users'],
            'password' => ['required', 'string', 'max:255', 'unique:users']
        ];
        if($request->isMethod('post')):
            $validateArr['is_legacy'] = ['required', 'boolean'];
            $validateArr['top_to_bottom'] = ['required', 'boolean'];
            $validateArr['language'] = ['required', 'string', 'max:2'];
            $validateArr['country'] = ['required', 'string', 'max:2'];
            $validateArr['timezone'] = ['required', 'string', 'max:128'];
            $validateArr['clock_type'] = ['required', 'integer', 'between:0,255'];
            $validateArr['email_optin'] = ['required', 'boolean'];
            $validateArr['menu_color'] = ['required', 'string', 'max:64'];
        endif;
        $request->validate($validateArr);
        return $request;
    }
}
