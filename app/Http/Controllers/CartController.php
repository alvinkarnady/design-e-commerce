<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

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

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get all cart items for the authenticated user
        $cartItems = Cart::where('id_user', Auth::id())->get();
        // dd($cartItems->post()->title_posts);

        // Alternatively, if you want to get cart items for a specific user (e.g., admin):
        // $cartItems = Cart::all(); // or Cart::where('id_user', $userId)->get();

        // Pass the cart items to the view
        return view('cart', [
            'title' => 'Carts',
            'active' => 'cart',
        ], compact('cartItems'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!Auth::check()) {
            //mengirim session url
            $request->session()->put('previousUrl', url()->previous());
            return redirect('/login')->with('warning', 'Please login first!');
        }

        // dd($request->input());
        // Validate the request data
        // $request->validate([
        //     'id_post' => 'required|exists:data_posts,id',
        //     'id_category' => 'required|exists:data_categories,id',
        //     'id_user' => 'required|exists:data_users,id',
        // ]);

        // Store the data in the carts table
        Cart::create([
            'id_user' => auth()->id(), // Assuming the user is authenticated
            'id_post' => $request->id_post,
            'id_category' => $request->id_category,
            // 'price' => $request->price,
        ]);

        // Redirect back with a success message
        return back()->with('success', 'Design added to cart!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cart $cart)
    {
        Cart::destroy($cart->id);

        return back()->with('success', 'Cart has been deleted!');
    }
}
