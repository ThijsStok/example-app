@extends('layouts.app')
@section('title', 'Welcome')
@section('content')

<link href="{{ asset('css/addproduct.css') }}" rel="stylesheet">
<link href="{{ asset('css/app.css') }}" rel="stylesheet">
<script src="{{ asset('js/addproduct.js') }}"></script>


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

<div class="container mt-4">
    <div class="card">
        <div class="card-header">
            Add a Product to Lend
        </div>
        <div class="card-body">
            <form action="{{ route('storeProduct') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="name">Product Name:</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="description">Description:</label>
                    <textarea class="form-control" id="description" name="description" required></textarea>
                </div>
                <div class="form-group">
                    <label for="categorySelect">Select Category:</label>
                    <select class="form-control" id="categorySelect" name="category">
                        <option value="">All Categories</option>
                        @foreach ($commonCategories as $category)
                            <option value="{{ $category }}">{{ $category }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="image">Image:</label>
                    <input type="file" class="form-control-file" id="image" name="image" required onchange="previewImage();">
                    <img id="imagePreview" src="#" alt="Image Preview" style="max-width: 200px; max-height: 200px; display: none;">
                </div>
                <button type="submit" class="btn btn-primary">Add Product</button>
            </form>
        </div>
    </div>
</div>
@endsection