<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Character;

class CharacterController extends Controller
{
    public function index()
    {
        $characters = Room::all();
        return view('characters.index', [
            'characters' => $characters
        ]);
    }

    public function create()
    {
        return view('characters.create');
    }

    public function show($id)
    {
        $character = Character::where('id', $id)->firstOrFail();
        return view('characters.show', [
            'character' -> $character
        ]);
    }

    public function edit($id)
    {
        $character = Character::where('id', $id)->get();
        return view('characters.edit',[
           'character' -> $character->firstOrFail() 
        ]);
    }
    
    public function update(Request $request, $id)
    {
        $character = Character::where('id',$id)->get()->firstOrFail();
        return view('characters.edit',[
           'character' -> $character->firstOrFail() 
        ]);
    }

    protected function validateCharacterUpdate($request){
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
        $request->validate($validateArr);
        return $request;
    }

}