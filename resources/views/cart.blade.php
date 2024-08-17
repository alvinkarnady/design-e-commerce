@extends('layouts.main')

@section('container')
    <div class="container">
        <h1>Your Cart</h1>

        @if ($cartItems->isEmpty())
            <p>Your cart is empty.</p>
        @else
            @if (session()->has('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            <table class="table">
                <thead>
                    <tr>
                        <th>Design</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $cartTotal = 0;
                    @endphp
                    @foreach ($cartItems as $item)
                        <tr>
                            <td>
                                <img style="max-height:100px ;" src="{{ asset('storage/' . $item->post->image_posts) }}"
                                    alt="{{ $item->category->name_categories }}" class="img-fluid rounded">
                            </td>
                            <td>{{ $item->post->title_posts }}
                            </td>
                            <td>{{ $item->category->name_categories }}</td>
                            <td><strong>Rp. {{ number_format($item->post->price, 0, ',', '.') }}</strong></td>
                            <td>
                                <form action="/cart/{{ $item->id }}" method="post" class="d-inline">
                                    @method('delete')
                                    @csrf
                                    <button class="btn btn-danger rounded-0"
                                        onclick="return confirm('Are you sure want to delete ?')"><i
                                            class='bx bx-trash'></i></button>
                                </form>
                            </td>
                        </tr>

                        @php
                            $cartTotal += $item->post->price;
                        @endphp
                    @endforeach
                    <tr>
                        <td colspan="3" class="text-right">
                            <h5><strong>Total :</strong></h5>
                        </td>
                        <td>
                            <h5><strong>Rp. {{ number_format($cartTotal, 0, ',', '.') }}</strong></h5>
                        </td>
                        <td>
                            <a href="{{ route('order.create') }}" class="btn btn-primary rounded-0">Checkout</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        @endif
    </div>
@endsection
