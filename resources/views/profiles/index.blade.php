@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-3 p-5">
            <img src="https://instagram.ftsr1-1.fna.fbcdn.net/v/t51.2885-19/s150x150/73213734_2702355019796272_1753394723277504512_n.jpg?_nc_ht=instagram.ftsr1-1.fna.fbcdn.net&_nc_ohc=VZnh0V4MVGUAX_DYtY9&oh=2f0b542217181301560aeba9573927bc&oe=5E9EAD38" class="rounded-circle">
        </div>
        <div class="col-9 pt-5">
            <div class="d-flex justify-content-between align-items-baseline">
                <h1>{{ $user->username }}</h1>
                <a href="/p/create">Add New Post</a>
            </div>
            <div class="d-flex">
                <div class="pr-5"><strong>{{ $user->posts->count() }}</strong> posts</div>
                <div class="pr-5"><strong>1k</strong> followers</div>
                <div class="pr-5"><strong>500</strong> following</div>
            </div>
            <div class="pt-4 font-weight-bold">
               {{ $user->profile->title}}
            </div>
            <div>
                {{ $user->profile->description}}
            </div>
            <div>
                <a href="#">
                    {{ $user->profile->url}}
                </a>
            </div>
        </div>
    </div>

    <div class="row pt-5">
        @foreach($user->posts as $post)
            <div class="col-4 pb-4">
                <img src="/storage/{{$post->image}}" class="w-100">
            </div>
        @endforeach
       

    </div>

</div>
@endsection
