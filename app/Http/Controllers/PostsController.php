<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\Facades\Image as Image;

use App\Post;


class PostsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    //
    public function create()
    {
        return view('posts/create');
    }

    public function index()
    {
        //get all the users id
        $users = auth()->user()->following()->pluck('profiles.user_id');

        //$posts = Posts::whereIn('user_id', $users)->orderBy('created_at','DESC')->get();
        $posts = Post::whereIn('user_id', $users)->with('user')->latest()->paginate(5);

        //dd($posts);

        return view('posts.index', compact('posts'));
    }

    public function store()
    {
        $data = request()->validate([
            'caption'=>'required',
            'image'=>['required', 'image']

        ]);


        $imagePath = request('image')->store('uploads','public');
        //$image = Image::make(public_path("storage/{$imagePath}"))->fit(1200, 1200);
        //$image->save();
        $image = Image::make(storage_path()."/app/public/{$imagePath}")->fit(1000, 1000);
        $image->save(public_path("storage/{$imagePath}"));
	

        auth()->user()->posts()->create([
            'caption' => $data['caption'],
            'image' => $imagePath
            ]);
        return redirect('/profile/'.auth()->user()->id);
    }

    public function show(\App\Post $post)
    {
        return view('posts.show', compact('post')
         );
    }
}
