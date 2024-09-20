@extends('layouts.app')

@section('content')
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
                        <div class="row">
                            @forelse ($user->products as $product)
                                <div class="col-md-4 mb-3">
                                    <div class="card">
                                        <div class="card-body">
                                            <p>Name: {{ $product->name }}</p>
                                            <p>Category: {{ $product->category }}</p>
                                            <p>Status: {{ $product->state }}</p>
                                            <form action="{{ route('admin.removeProduct', $product->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">Remove Item</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <p>No products found for this user.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            @empty
                <p>No users found.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection