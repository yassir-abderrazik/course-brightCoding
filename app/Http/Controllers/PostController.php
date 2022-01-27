<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePost;
use App\Image;
use App\Post;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\support\Str;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show', 'archive', 'allPosts']);
    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('posts.index', [
            'posts' =>  Post::withCount('comments')->with(['user', 'tags', 'image'])->Paginate(6),
            'tab' => 'list',
        ]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function archive()
    {
        return view('posts.index', [
            'posts' =>   Post::onlyTrashed()->withCount('comments')->get(),
            'tab' => 'archive',
        ]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function allPosts()
    {
        return view('posts.index', [
            'posts' =>  Post::withTrashed()->withCount('comments')->get(),
            'tab' => 'all',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePost $request)
    {

        $validateData = $request->validated();
        $validateData['slug'] = Str::slug($validateData['title'], '-');
        $validateData['active'] = false;
        $validateData['user_id'] = $request->user()->id;
        $post = Post::create($validateData);
        if($request->hasFile('picture')){
            $path = $request->file('picture')->store('posts');
            $image = new Image(['path' => $path]);
            $post->image()->save($image);
        }
        $request->session()->flash('status', 'post was creates !!');
        return redirect()->route('posts.index');

    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $postShow = Cache::remember("post-show-{id}", 60, function () use ($id) {
            return Post::with(['comments', 'tags', 'comments.user'])->findOrFail($id);
        });

        return view('posts.show', [
            'post' =>  $postShow,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post =Post::findOrFail($id);
        $this->authorize("update", $post);

        // if(Gate::denies('postUpdate', $post)){
        //     abort(403, "you can't edit this post");
        // }
        return view('posts.edit', [
            'post' => $post
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StorePost $request, $id)
    {
        $post =Post::findOrFail($id);
        $this->authorize("update", $post);
        if($request->hasFile('picture')){
            $path = $request->file('picture')->store('posts');
            if($post->image){
                Storage::delete($post->image->path);
                $post->image->path = $path;
                $post->image->save();
            }
            else {
                $image = new Image(['path' => $path]);
            $post->image()->save($image);
            }
        }
        // if(Gate::denies('postUpdate', $post)){
        //     abort(403, "you can't edit this post");
        // }
        $post->title = $request->input('title');
        $post->content = $request->input('content');
        $post->slug  =  Str::slug($post->title, '-' );
        $post->save();
        return redirect()->route('posts.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $post = Post::findOrFail($id);
        $this->authorize("delete", $post);
        Post::destroy($id);
        $request->session()->flash('status', 'post was deleted !!');
        return redirect()->route('posts.index');
    }




    public function restorePost($id)
    {

        $post = Post::onlyTrashed()->where('id', $id)->first();
        $this->authorize("restore", $post);
        $post->restore();
        return redirect()->back();
    }

    public function forceDelete($id){

        $post = Post::onlyTrashed()->where('id', $id)->first();
        $this->authorize("forceDelete", $post);

        $post->forceDelete();
        return redirect()->back();
    }


}
