@extends('layouts.main')

@section('container')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    @if ($order->is_paid == true)
                        <div class="card-header bg-success text-light" style="--bs-bg-opacity: .5;"> Order Detail
                        </div>
                    @else
                        <div class="card-header bg-warning text-dark" style="--bs-bg-opacity: .5;"> Order Detail
                        </div>
                    @endif
                    @php
                        $total_price = 0;
                    @endphp
                    <div class="card-body">
                        <h5 class="card-title">Order ID {{ $order->id }}</h5>
                        <h6 class="card-subtitle mb-2 text-muted">By {{ $order->user->name_users }}</h6>
                        <p class=" mb-2 text-muted" style="font-size: 13px"> {{ $order->created_at->format('d M Y - H:i') }}
                        </p>

                        @if ($order->is_paid == true)
                            <p class="card-text" style='color:#3fdb5b'>Paid <i class='bx bx-check'></i></p>
                        @else
                            <p class="card-text" style='color:#e3b212'>Pending <i class='bx bx-time'></i></p>
                        @endif
                        <hr>
                        @foreach ($cartItems as $item)
                            <p>{{ $item->post->title_posts }} - Rp. {{ number_format($item->post->price, 0, ',', '.') }} pcs
                            </p>
                            @php
                                $total_price += $item->post->price;
                            @endphp
                        @endforeach
                        <hr>
                        <p><strong>Total Rp. {{ number_format($total_price, 0, ',', '.') }}</strong></p>
                        <hr>
                        @if ($order->is_paid == false && $order->payment_receipt == null && !Auth::user()->is_admin)
                            <form action="{{ route('submit_payment') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="order_id" value="{{ $order->id }}">
                                <div class="form-group">
                                    <label for="payment_receipt">Upload Payment Receipt</label>
                                    <input class="form-control" type="file" name="payment_receipt" id="payment_receipt">
                                </div>
                                @if ($errors->any())
                                    @foreach ($errors->all() as $error)
                                        <p style="color: red">{{ $error }}</p>
                                    @endforeach
                                @endif
                                <button class="btn btn-primary mt-3" type="submit">Confirm Payment</button>
                            </form>

                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
