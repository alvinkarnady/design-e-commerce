@extends('layouts.main') @section('container')
    <div class="container">
        <div class="row justify-content-center mb-5">
            <div class="col-md-8">
                <h1 class="mb-3">{{ $post->title_posts }}</h1>
                @if (session()->has('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                @endif
                <p>
                    By
                    <a href="/posts?author={{ $post->author->username_users }}" class="text-decoration-none">
                        {{ $post->author->name_users }}
                    </a>
                    in
                    <a href="/posts?category={{ $post->category->slug_categories }}"
                        class="text-decoration-none">{{ $post->category->name_categories }}</a>
                </p>

                @if ($post->image_posts)
                    <div
                        style="background-size: cover; overflow:hidden; display: flex; justify-content: center; align-items: center;">
                        <img src="{{ asset('storage/' . $post->image_posts) }}" alt="{{ $post->category->name_categories }}"
                            class="img-fluid rounded" />
                    </div>
                @else
                    <img src="https://source.unsplash.com/random/1200x400?{{ $post->category->name_categories }}"
                        alt="{{ $post->category->name_categories }}" class="img-fluid rounded" />
                @endif

                <article class="my-3 fs-5 mb-5">{!! $post->body_posts !!}</article>
                <h4><strong>Rp. {{ number_format($post->price, 0, ',', '.') }}</strong></h4>
                @if (auth()->check() && !auth()->user()->is_admin)
                    <form action="{{ route('cart.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id_post" value="{{ $post->id }}">
                        <input type="hidden" name="id_category" value="{{ $post->id_category }}">
                        {{-- <input type="hidden" name="id_user" value="{{ $post->id_user }}"> --}}
                        <button type="submit" class="btn btn-success rounded-0">Add
                            to
                            chart <i class="fi fi-sr-shopping-cart-add"></i></button>
                    </form>
                @endif

                <!-- Tampilkan komentar -->
                @foreach ($comments as $comment)
                    <div>
                        <div class="rating-hasil">
                            @for ($i = 1; $i <= 5; $i++)
                                @if ($i <= $comment->rating_comments)
                                    <i class="fas fa-star"></i>
                                @else
                                    <i class="far fa-star"></i>
                                @endif
                            @endfor
                            <p>
                                <strong>{{ $comment->user->name_users }}:</strong>
                                {{ $comment->content_comments }}
                            </p>
                        </div>
                    </div>
                @endforeach
                {{-- ratings start --}}
                <div class="form-container">
                    <div class="wrapper">
                        <form action="{{ route('comments.store') }}" method="POST" class="rating-form">
                            @csrf
                            <div class="rating">
                                <input type="radio" id="star1" name="rating" value="1" hidden />
                                <label for="star1"><i class='bx bx-star star' style="--i: 0;"></i></label>
                                <input type="radio" id="star2" name="rating" value="2" hidden />
                                <label for="star2"><i class='bx bx-star star' style="--i: 1;"></i></label>
                                <input type="radio" id="star3" name="rating" value="3" hidden />
                                <label for="star3"><i class='bx bx-star star' style="--i: 2;"></i></label>
                                <input type="radio" id="star4" name="rating" value="4" hidden />
                                <label for="star4"><i class='bx bx-star star' style="--i: 3;"></i></label>
                                <input type="radio" id="star5" name="rating" value="5" hidden />
                                <label for="star5"><i class='bx bx-star star' style="--i: 4;"></i></label>
                            </div>
                            <input type="hidden" name="id_post" value="{{ $post->id }}">
                            <textarea name="content" placeholder="Leave a comment" value="{{ old('content') }}"></textarea>
                            <button type="submit" id="submitBtn" disabled>
                                Submit
                            </button>
                        </form>
                    </div>
                </div>
                {{-- ratings end --}}
                <a href="/posts" class="d-block mt-3">Back to Posts</a>
            </div>
        </div>
    </div>
@endsection
