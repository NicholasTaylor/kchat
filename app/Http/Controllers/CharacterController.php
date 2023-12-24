<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use App\Models\Character;
use App\Rules\WithinMax;
use App\Rules\Creator;

class CharacterController extends Controller
{
    public function index()
    {
        $characters = Character::all();
        return view('characters.index', [
            'characters' => $characters
        ]);
    }

    public function create()
    {
        return view('characters.create');
    }

    public function store(Request $request)
    {
        $character = Character::create($this->validateCharacter($request)->all());
        return view('characters.index');
    }

    public function show($id)
    {
        $character = Character::where('id', $id)->firstOrFail();
        return view('characters.show', [
            'character' -> $character
        ]);
    }

    public function edit(Request $request)
    {
        $character = Character::where('id', $request->id)->get()->firstOrFail();
        return view('characters.edit',[
           'character' -> $character 
        ]);
    }
    
    public function update(Request $request)
    {
        $character = Character::where('id',$id)->get()->firstOrFail();
        $character->update($this->validateCharacter($request)->all());
        return view('characters.edit',[
           'character' -> $character 
        ]);
    }

    public function destroy(Request $request){
        $character = Character::where('id',$id)->get()->firstOrFail();
        $character->delete();
        return view('characters.show', [
            'character' -> $character
        ]);
    }

    protected function validateCharacter($request){
        $validateArr = [
            'name' => ['required', 'string', 'max:1024'],
            'race' => ['string', 'max:64'],
            'class' => ['string', 'max:64'],
            'biography' => ['string', 'max:325000'],
            'origin' => ['string', 'max:64'],
            'email' => ['string', 'max:256'],
            'font_color' => ['string', 'max:64'],
            'img' => ['string', 'max:1024']
        ];
        if($request()->isMethod('put')):
            $validateArr['id'] = ['required', 'exists:characters', 'integer', new Creator];
            $validateArr['user_id'] = ['required', 'exists:users', 'integer'];
        else:
            $validateArr['user_id'] = ['required', 'exists:users', 'integer', new WithinMax];
        endif;
        $request->validate($validateArr);
        $request['user_id'] = auth()->user()->id;

        return $request;
    }

}