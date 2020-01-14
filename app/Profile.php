<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    //
    protected $guarded = [];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function profileImage()
    {
        $imagePath = ($this->image) ? $this->image : 'profile/qSh7rg1zTdR050PmMY5HH8yFak6EJCR1csdyOqMI.gif';
        return '/storage/'.$imagePath;
    }

    public function followers()
    {
        return $this->belongsToMany(User::class);
    }
}
