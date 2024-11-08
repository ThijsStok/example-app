@extends('layouts.app')
@section('title', 'Welcome')
@section('content')


<script src="{{ asset('js/category.js') }}"></script>

<nav class="navbar navbar-expand-lg navbar-light bg-light px-4">
    <a class="navbar-brand" href="{{ url('/') }}">Lend Stuff</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item active">
                <a class="nav-link" href="/">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ url('lendmystuff') }}">My Stuff</a>
            </li>
            @if (auth()->check() && auth()->user()->isAdmin())
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('admin') }}">Admin</a>
                </li>
            @endif
                <div class="nav-item">
                <a class="nav-link" href="{{ url('logout') }}">Logout</a>
            </div>
        </ul>
    </div>
</nav>
</nav>

<div class="container mt-3">
    <form action="{{ url('filterByCategory') }}" method="GET">
        <div class="form-group">
            <label for="categorySelect">Select Category:</label>
            <select class="form-control" id="categorySelect" name="category">
                <option value="">All Categories</option>
                @php
                @endphp
                @foreach ($commonCategories as $category)
                    <option value="{{ $category }}">{{ $category }}</option>
                @endforeach
            </select>
        </div>
    </form>
</div>
<div class="container mt-3">
    <div class="row justify-content-center">
        @foreach ($products as $product)
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4" data-category="{{ $product->category }}">
                <div class="card h-100" data-category="{{ $product->category }}">
                    <img src="{{ $product->image }}" class="card-img-top" alt="{{ $product->name }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text">Category: {{ $product->category }}</p>
                        <p>{{ $product->description }}</p>
                        <form action="{{ route('borrow') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <div class="mb-3">
                                <label for="lend_days_{{ $product->id }}" class="form-label">Lend Period (Days):</label>
                                <select class="form-select" id="lend_days_{{ $product->id }}" name="lend_days">
                                    @for ($i = 1; $i <= 28; $i++)
                                        <option value="{{ $i }}">{{ $i }} {{ $i == 1 ? 'Day' : 'Days' }}</option>
                                    @endfor
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Borrow</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

@endsection