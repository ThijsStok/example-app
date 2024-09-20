@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card mt-4">
        <div class="card-header">
            All Users and Their Products
        </div>
        <div class="card-body">
            @forelse ($users as $user)
                <h5>{{ $user->name }} ({{ $user->email }})</h5>
                <ul class="list-group mb-4">
                    @forelse ($user->products as $product)
                        <li class="list-group-item">
                            Name: {{ $product->name }}
                            <br>Category: {{ $product->category }}
                            <br>Status: 
                            @if ($product->state === 'available')
                                <span class="badge badge-success">Available</span>
                            @elseif ($product->state === 'borrowed')
                                <span class="badge badge-warning">Borrowed</span>
                            @elseif ($product->state === 'waiting_for_acceptance')
                                <span class="badge badge-info">Waiting for Acceptance</span>
                            @endif
                        </li>
                    @empty
                        <li class="list-group-item">No products found for this user.</li>
                    @endforelse
                </ul>
            @empty
                <p>No users found.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection