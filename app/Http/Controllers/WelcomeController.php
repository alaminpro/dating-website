<?php

namespace App\Http\Controllers;

use App\Page;

class WelcomeController extends Controller
{

    /**
     * Dynamic page render
     * @return Page
     */
    public function dynamicPage($slug)
    {
        $data = Page::where('type', 0)->where('slug', $slug)->first();
        $pages = Page::where('type', 0)->get();
        return view('custome', compact('data', 'pages'));
    }

    /**
     * coding for blog post
     * #param page post type
     * @return Page
     */
    public function BlogPost()
    {
        $posts = Page::where('type', 1)->orderBy('created_at', 'DESC')->paginate(6);
        return view('posts.posts', compact('posts'));
    }

    /**
     * get post by slug
     * @return Post by type
     */
    public function SingleBlogPost($slug)
    {
        $post = Page::where('type', 1)->where('slug', $slug)->first();
        $posts = Page::where('type', 1)->inRandomOrder()->limit(5)->get();
        return view('posts.single-post', compact('posts', 'post'));
    }
}
