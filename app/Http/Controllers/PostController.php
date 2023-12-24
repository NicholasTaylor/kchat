<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Character;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function store(Request $request)
    {
        $validated = $this->validatePost($request)->all();
        $completed = $this->completeRecord($validated);
        $post = Post::create($this->validatePost($request)->all());
        return view('posts.index');
    }

    public function edit($id)
    {
        $post = Post::where('id',$id)->get();
        return view('posts.edit',[
           'post' -> $post->firstOrFail() 
        ]);
    }

    public function destroy(Request $request)
    {
        $post = Post::where($request->id,$id);
        $post->delete();
    }

    public function update(Request $request)
    {
        $id = $request->id;
        $post = Post::where('id',$id)->get()->firstOrFail();
        $post->update($this->validatePost($request)->all());
        return view('posts.edit',[
           'post' -> $post 
        ]);
    }

    protected function completeRecord($request){
        $character = Character::where('id',$request->character_id)->get()->firstOrFail();
        $new_req = clone $request;
        $new_req['character_name'] = $character->name;
        $new_req['ip_address'] = $request->ip();
        $new_req['is_hidden'] = false;
        return $new_req;
    }

    protected function validatePost($request){
        $validateArr = [
            'user_id' => ['required', 'exists:users', 'integer'],
            'room_id' => ['required', 'exists:rooms', 'integer'],
            'message' => ['string', 'max:325000']
        ];
        if($request()->isMethod('post')):
            $validateArr['character_id'] = ['required', 'exists:characters', 'integer', new Creator];
        elseif($request()->isMethod('put')):
            $validateArr['character_id'] = ['required', 'exists:characters', 'integer'];
            $validateArr['character_name'] = ['string', 'max:1024'];
            $validateArr['is_hidden'] = ['required', 'boolean'];
            $validateArr['ip_address'] = ['ip'];
        endif;
        $request->validate($validateArr);
        $request['user_id'] = auth()->user()->id;
        return $request;
    }
}
