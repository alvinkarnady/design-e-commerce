<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;

View::composer('*', function ($view) {
    if (auth()->check()) {
        $cartItemCount = Cart::where('id_user', auth()->id())->count();
        $view->with('cartItemCount', $cartItemCount);
    }
});

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        if ($user->is_admin) {
            $orders = Order::latest()->get();
        } else {
            $orders = Order::where('id_user', $user->id)->latest()->get();
        }
        return view('orders.index', [
            'title' => 'Order',
            'active' => 'order',
        ], compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {


        // Cek apakah ada order yang belum dibayar oleh pengguna saat ini
        $order = Order::where('id_user', Auth::id())
            ->where('is_paid', false)
            ->first();

        if ($order) {
            $cartItems = Transaction::where('id_order', $order->id)->get();
        }

        // Jika tidak ada order yang belum dibayar, buat order baru
        if (!$order) {
            // Ambil item keranjang untuk pengguna yang sedang login
            $cartItems = Cart::where('id_user', Auth::id())->get();

            if ($cartItems->isEmpty()) {
                return Redirect::back();
            }

            $order = Order::create([
                'id_user' => Auth::id(),
            ]);
        }

        return view('orders.create', [
            'title' => 'Order',
            'active' => 'order',
        ], compact('cartItems', 'order'));
    }

    public function submit_payment(Request $request, Order $order)
    {
        $validatedData = $request->validate([
            'payment_receipt' => 'required|image|file|max:500000',
        ]);

        $id_order = $request->input('order_id');

        // Calculate total price of the cart
        $cartItems = Cart::where('id_user', Auth::id())->get();
        // $totalPrice = $cartItems->sum(fn($item) => $item->post->price);

        // Create order items from cart items
        foreach ($cartItems as $item) {
            Transaction::create([
                'id_order' => $id_order,
                'id_post' => $item->id_post,
                'id_category' => $item->id_category,
                'id_user' => $item->id_user,
            ]);
        }

        if ($request->file('payment_receipt')) {
            $validatedData['payment_receipt'] = $request->file('payment_receipt')->store('payment-images');
        }

        // $path = time() . '_' . $order->id . '.' . $file->getClientOriginalExtension();

        Order::where('id', $id_order)
            ->update($validatedData);

        // $order->update([
        //     'payment_receipt' => $validatedData['payment_receipt']
        // ])->where('id', $id_order);

        // Clear the user's cart
        Cart::where('id_user', Auth::id())->delete();


        return Redirect::route('order.index')->with('success', 'Checkout Success!');
    }

    public function confirm_payment(Order $order)
    {
        $order->update([
            'is_paid' => true
        ]);

        return Redirect::back();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {


        $cartItems = Transaction::where('id_order', $order->id)->get();


        // dd($transaction[0]->post->price, $transaction[1]->post->price);


        $user = Auth::user();
        $is_admin = $user->is_admin;

        if ($is_admin || $order->id_user == $user->id) {
            return view('orders.create', [
                'title' => 'Order',
                'active' => 'order',
            ], compact('cartItems', 'order'));
        }
        return Redirect::route('index_order');
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
    public function destroy(string $id)
    {
        //
    }
}
