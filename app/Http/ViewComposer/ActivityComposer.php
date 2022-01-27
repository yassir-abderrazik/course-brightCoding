<?php

namespace App\Http\ViewComposer;

use App\Post;
use App\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class ActivityComposer{
    public function compose(View $view){

        $mostCommented = Cache::remember('mostCommented', now()->addSecond(10), function () {
            return Post::mostCommented()->take(5)->get();
        });
        $activeUser = Cache::remember('activeUser', now()->addSecond(10), function () {
            return User::activeUser()->take(5)->get();
        });
        $activeUserLastMonth = Cache::remember('activeUserLastMonth', now()->addSecond(10), function () {
            return User::activeUserLastMonth()->take(5)->get();
        });
        $view->with([
            'mostCommented' => $mostCommented,
            'activeUser' => $activeUser,
            'activeUserLastMonth' => $activeUserLastMonth,
        ]);
    }
}