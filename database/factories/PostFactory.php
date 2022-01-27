<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Post;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Post::class, function (Faker $faker) {
   
$title =  $faker->realText(30);
    return [
        'title' => $title,
        'slug' => Str::slug($title, '-'),
        'content' => $faker->realText(600),
        'active' => $faker->boolean
        
    ];
});
