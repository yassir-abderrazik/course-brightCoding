<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function posts(){
        return $this->hasMany(Comment::class);
    }
    public function image(){
        return $this->morphOne('App\Image', 'imageable');
    }
    public function comments(){
        return $this->hasMany(Post::class);
    }

    public function scopeActiveUser(Builder $query){
        return $query->withCount('posts')->orderBy('posts_count', 'desc');
    }
    public function scopeActiveUserLastMonth(Builder $query){
        return $query->withCount(['posts' => function(Builder $query){
                $query->whereBetween(static::CREATED_AT, [now()->subMonths(1), now()]);
        }])->having('posts_count', '>', '7')->orderBy('posts_count', 'desc');
    }
}
