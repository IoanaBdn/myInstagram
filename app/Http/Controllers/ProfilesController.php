<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use Intervention\Image\Facades\Image as Image;
use Illuminate\Support\Facades\Cache;


class ProfilesController extends Controller
{
    //
    public function index(User $user)
    {
        $follows = (auth()->user()) ? auth()->user()->following->contains($user->id) : false;

        $postCount = Cache::remember(
            'cache.posts.'.$user->id, 
            now()->addSeconds(30), 
            function() use ($user)
            {
                return $user->posts->count();
            }
        );

        $followersCount = $user->profile->followers->count();
        $followingCount = $user->following->count();

        return view('profiles.index',compact( 'user',  'follows', 'postCount', 'followersCount', 'followingCount') );
         
    }

    //public function edit(\App\User $user)
    public function edit(User $user)
    {
        $this->authorize('update', $user->profile);
        return view('profiles.edit', compact('user'));
    }

    public function update(User $user)
    {
        $this->authorize('update', $user->profile);

        $data = request()->validate([
            'title'=>'required',
            'description'=>'required',
            'url'=>'url',
            'image'=>''
        ]);


        if(request('image'))
        {

            $imagePath = request('image')->store('profile','public');
            //$image = Image::make(public_path("storage/{$imagePath}"))->fit(1000, 1000);
            //$image->save();

            $image = Image::make(storage_path()."/app/public/{$imagePath}")->fit(1000, 1000);
            $image->save(public_path("storage/{$imagePath}"));
	

            $imageArray = ['image' => $imagePath];

        }

        auth()->user()->profile->update(array_merge($data, 
        $imageArray ?? []
        ));
        return redirect("/profile/{$user->id}");

        //dd($data);
    }

}
