<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreComment;
use App\Http\Resources\CommentResourse;
use App\Post;
use Illuminate\Http\Request;

class PostCommentController extends Controller
{
    public function __construct(){
        $this->middleware('auth')->only(['store']);
    }

    
        
    

    public function store(StoreComment $request, Post $post){
        $post->comments()->create([
            'content' => $request->content,
            'user_id' => $request->user()->id,
        ]);
        return redirect()->back();
    }
}
