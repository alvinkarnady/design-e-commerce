@extends('layouts.main')

@section('container')
    <h1 class="mb-5 text-center">{{ $title }} </h1>

    {{-- @dd($posts[0]->category->name_categories ?? null) --}}


    <div class="row justify-content-center mb-3">
        <div class="col-md-6">
            @if (session()->has('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            <form action="/posts">
                @if (request('category'))
                    <input type="hidden" name="category" value="{{ request('category') }}">
                @endif
                @if (request('author'))
                    <input type="hidden" name="author" value="{{ request('author') }}">
                @endif
                <div class="input-group mb-3">
                    <input type="text" class="form-control border-primary" placeholder="Cari..." name="search"
                        value="{{ request('search') }}">
                    <button class="btn btn-primary" type="submit">Cari</button>
                </div>
            </form>
        </div>
    </div>

    @if ($posts->count())
        {{-- <div class="card mb-3">
            @if ($posts[0]->image_posts)
                <div style="max-height: 300px; overflow:hidden;">
                    <img src="{{ asset('storage/' . $posts[0]->image_posts) }}"
                        alt="{{ $posts[0]->category->name_categories }}" class="img-fluid rounded">
                </div>
            @else
                <img src="https://source.unsplash.com/random/1200x400?{{ $posts[0]->category->name_categories }}"
                    class="card-img-top" alt="{{ $posts[0]->category->name_categories }}">
            @endif


            <div class="card-body text-center">
                <h3 class="card-title"> <a href="/posts/{{ $posts[0]->slug_posts }}"
                        class="text-decoration-none text-dark">{{ $posts[0]->title_posts }}</a> </h3>
                <p>
                    <small class="text-muted">
                        <b>By <a href="/posts?author={{ $posts[0]->author->username_users }}" class="text-decoration-none">
                                {{ $posts[0]->author->name_users }}</a></b> in <a
                            href="/posts?category={{ $posts[0]->category->slug_categories }}"
                            class="text-decoration-none ">{{ optional($posts[0]->category)->name_categories }}</a>
                        {{ $posts[0]->created_at->diffForHumans() }}
                    </small>
                </p>
                <p class="card-text">{{ $posts[0]->excerpt_posts }}</p>

                <a href="/posts/{{ $posts[0]->slug_posts }}"
                    class="text-decoration-none btn btn-primary rounded-0">Details</a>
                <a href="/posts/{{ $posts[0]->slug_posts }}" class="text-decoration-none btn btn-success rounded-0"><i
                        class="fi fi-sr-shopping-cart-add"></i></a>


            </div>
        </div> --}}


        <div class="container">
            <div class="row">
                @foreach ($posts as $post)
                    <div class="col-md-4 mb-3">
                        <div class="card shadow border-primary">
                            <div class="position-absolute px-3 py-2 rounded" style="background-color: rgba(0,0,0,0.4)"><a
                                    href="/posts?category={{ $post->category->slug_categories }}"
                                    class="text-white text-decoration-none">{{ $post->category->name_categories }}</a>
                            </div>

                            @if ($post->image_posts)
                                <div style="max-height: 277px; overflow:hidden;">
                                    <img style="min-height:280px ;" src="{{ asset('storage/' . $post->image_posts) }}"
                                        alt="{{ $post->category->name_categories }}" class="img-fluid rounded">
                                </div>
                            @else
                                <img src="https://source.unsplash.com/random/500x400?{{ $post->category->name_categories }}"
                                    class="card-img-top" alt={{ $post->category->name_categories }}>
                            @endif

                            <div class="card-body">
                                <h5 class="card-title">{{ $post->title_posts }}</h5>
                                <p>
                                    <small class="text-muted">
                                        <b>By <a href="/posts?author={{ $post->author->username_users }}"
                                                class="text-decoration-none"> {{ $post->author->name_users }}</a></b>
                                        {{ $post->created_at->diffForHumans() }}
                                    </small>
                                </p>

                                <p class="card-text">{{ $post->excerpt_posts }}</p>

                                <div class="d-flex justify-content-start align-items-center ">
                                    <a href="/posts/{{ $post->slug_posts }}" class="btn btn-primary rounded-0">Detail</a>
                                    @if (auth()->check() && !auth()->user()->is_admin)
                                        <form action="{{ route('cart.store') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="id_post" value="{{ $post->id }}">
                                            <input type="hidden" name="id_category" value="{{ $post->id_category }}">
                                            {{-- <input type="hidden" name="id_user" value="{{ $post->id_user }}"> --}}
                                            <button type="submit" class="btn btn-success rounded-0 ms-1"><i
                                                    class="fi fi-sr-shopping-cart-add"></i></button>
                                        </form>
                                    @endif

                                    <span class="ms-2"><strong>Rp.
                                            {{ number_format($post->price, 0, ',', '.') }}</strong></span>
                                </div>

                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <p class="text-center fs-4">No post found.</p>
    @endif
    <div class="d-flex justify-content-end">
        {{ $posts->links() }}
    </div>

@endsection
