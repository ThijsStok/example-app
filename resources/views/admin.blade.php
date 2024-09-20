@extends('layouts.app')
@section('title', 'Manage Users')
@section('content')
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
<div class="container">
    <div class="card mt-4">
        <div class="card-header">
            All Users and Their Products
        </div>
        <div class="card-body">
            @forelse ($users as $user)
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <p>{{ $user->name }}</p>
                            <p>Email: {{ $user->email }}</p>
                            <p>Role: {{ $user->role }}</p>
                            <p>Status: {{ $user->blocked ? 'Blocked' : 'Active' }}</p>
                            <p>Created At: {{ $user->created_at }}</p>
                            <p>Updated At: {{ $user->updated_at }}</p>
                        </div>
                        <form action="{{ route('admin.blockUser', $user->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-danger">Block User</button>
                        </form>
                    </div>
                    <div class="card-body">
                        <h6>Products</h6>
                        @forelse ($user->products as $product)
                        <div class="card mb-3">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="card-title">{{ $product->name }}</h5>
                                    <p class="card-text">Description: {{ $product->description }}</p>
                                    <p class="card-text">Created At: {{ $product->created_at }}</p>
                                    <p class="card-text">Updated At: {{ $product->updated_at }}</p>
                                </div>
                                <form action="{{ route('admin.removeProduct', $product->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Remove Item</button>
                                </form>
                            </div>
                        </div>
                        @empty
                            <p class="card-text">No products available.</p>
                        @endforelse
                    </div>
                </div>
            @empty
                <p>No users found.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection