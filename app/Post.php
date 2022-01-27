<?php

namespace App;

use App\Scopes\AdminShowDeleteScope;
use App\Scopes\LastestScope;
use FFI\CData;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

class Post extends Model
{
    use SoftDeletes;
    protected $fillable = ['user_id', 'title', 'content', 'slug', 'active'];
   
    public function comments(){
        return $this->hasMany('App\Comment')->lastest();
    }
    public function tags(){
        return $this->belongsToMany('App\Tag')->withTimestamps();
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function image(){
        return $this->morphOne('App\Image', 'imageable');
    }
    public function scopeMostCommented(Builder $query){
        return $query->withCount('comments')->orderBy('comments_count', 'desc');
    }
    

    public static function boot(){

        static::addGlobalScope(new AdminShowDeleteScope);
        parent::boot();

        static::addGlobalScope(new LastestScope);

        static::deleting(function(Post $post){
            $post->comments()->delete();
        });
        
        static::restoring(function(Post $post){
            $post->comments()->restore();
        });
        static::updating(function(Post $post){
            Cache::forget("post-show-{$post->id}");
        });

        static::deleting(function(Post $post){
            $post->comments()->forceDelete();
        });
    }
    
}
