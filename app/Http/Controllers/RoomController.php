<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Post;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::all();
        return view('rooms.index', [
            'rooms' => $rooms
        ]);
    }

    public function create()
    {
        return view('rooms.create');
    }

    public function store(Request $request)
    {
        $room = Room::create($this->validateRoom($request)->all());
        return view('rooms.index');
    }

    public function show(Room $slug)
    {
        $room = Room::where('slug', $slug)->firstOrFail();
        $room_id = $room->id;
        $posts = Post::where('room_id', $room_id)->where('is_hidden', 0)->latest()->paginate(70);
        return view('rooms.show', [
            'room' -> $room
        ]);
    }

    public function edit($id)
    {
        $room = Room::where('id',$id)->get();
        return view('rooms.edit',[
           'room' -> $room->firstOrFail() 
        ]);
    }

    public function update(Request $request, $id)
    {
        $room = Room::where('id',$id)->get()->firstOrFail();
        $room->update($this->validateRoom($request)->all());
        return view('rooms.edit',[
           'room' -> $room 
        ]);
    }

    protected function validateRoom($request){
        $validateArr = [
            'name' => ['required', 'string', 'max:256'],
            'slug' => ['required', 'string', 'max:512']
        ];
        $request->validate($validateArr);
        $request['user_id'] = auth()->user()->id;
        return $request;
    }
}
