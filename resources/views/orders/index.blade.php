@extends('layouts.main')

@section('container')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-primary text-light" style="--bs-bg-opacity: .5;">{{ __('List Order') }}</div>
                    <div class="card-body m-auto">
                        @foreach ($orders as $order)
                            <div class="card mb-2 border-primary" style="width: 30rem">
                                <div class="card-body ">
                                    <a href="{{ route('order.show', $order) }}">
                                        <h5 class="card-title">Order ID: {{ $order->id }}</h5>
                                    </a>
                                    <h6 class="card-subtitle mb-2 text-muted">By {{ $order->user->name_users }}
                                    </h6>
                                    <p class="card-text" style="font-size: 13px">
                                        {{ $order->created_at->format(' d M Y - H:i') }}</p>

                                    @if ($order->is_paid == true)
                                        <p class="card-text" style='color:#3fdb5b'>Sukses <i class='bx bx-check'></i></p>
                                    @else
                                        <p class="card-text" style='color:#e3b212'>Tertunda <i class='bx bx-time'></i></p>
                                        @if ($order->payment_receipt)
                                            <div class="d-flex flew-row">
                                                <a href="{{ url('storage/' . $order->payment_receipt) }}"
                                                    class="btn btn-sm btn-outline-primary">Lihat Bukti Pembayaran</a>
                                                @if (Auth::user()->is_admin)
                                                    <form action="{{ route('confirm_payment', $order) }}" method="post">
                                                        @method('PUT')
                                                        @csrf
                                                        <button class="btn btn-sm btn-success ms-1"
                                                            type="submit">Confirm</button>
                                                    </form>
                                                @endif
                                            </div>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
