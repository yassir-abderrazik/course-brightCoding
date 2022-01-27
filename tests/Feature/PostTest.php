<?php

namespace Tests\Feature;

use App\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\support\Str;


class PostTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testSavePost()
    {
        $post = new Post();
        
        $post->title = "new title";
        $post->slug = Str::slug($post->title, '-');
        $post->content = "new content";
        $post->active = false;
        $post->save();
        $this->assertDatabaseMissing('posts', [
            'title' => 'new title',
        ]); 
    }
}
