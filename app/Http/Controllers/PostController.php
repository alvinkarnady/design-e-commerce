<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use PharIo\Manifest\Author;

View::composer('*', function ($view) {
    if (auth()->check()) {
        $cartItemCount = Cart::where('id_user', auth()->id())->count();
        $orderCount =  Order::where('is_paid', false)->count();
        $view->with([
            'cartItemCount' => $cartItemCount,
            'orderCount' => $orderCount,
        ]);
    }
});

class PostController extends Controller
{
    public function index()
    {

        $title = '';
        if (request('category')) {
            $category = Category::firstWhere('slug_categories', request('category'));
            $title = ' in ' . $category->name_categories;
        }

        if (request('author')) {
            $author = User::firstWhere('username_users', request('author'));
            $title = ' by ' . $author->name_users;
        }

        $user = Auth::user();

        return view('posts', [
            "title" => "Desain" . $title,
            "active" => 'posts',
            'user' => $user,
            "posts" => Post::latest()->filter(request(['search', 'category', 'author']))->paginate(9)->withQueryString()
        ]);
    }

    public function category()
    {
        return view('categories', [
            'title' => 'Kategori Desain',
            'active' => 'categories',
            'categories' => Category::all()
        ]);
    }


    public function show(Post $post)
    {
        // Dapatkan semua komentar terkait dengan postingan
        $comments = $post->comments()->get();


        if (!empty($comments)) {
            return view('post', [
                "title" => "Single Post",
                "active" => 'posts',
                "post" => $post,
                "comments" => $comments
            ]);
        } else {
            // Jika tidak ada komentar, berikan respons atau lakukan tindakan lain
            return view('post', [
                "title" => "Single Post",
                "active" => 'posts',
                "post" => $post,
                "comments" => []
            ]);
        }
    }


    // public function show(Post $post){
    //     return view('post',[
    //         "title" => "Single Post",
    //         "active" => 'posts',
    //         "post" => $post
    //     ]);
    // }
}
