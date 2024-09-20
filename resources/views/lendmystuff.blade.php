@extends('layouts.app')
@section('title', 'Lend my stuff')
@section('content')

<script src="{{ asset('js/category.js') }}"></script>
<link href="{{ asset('css/app.css') }}" rel="stylesheet">


<nav class="navbar navbar-expand-lg navbar-light bg-light px-4">
    <a class="navbar-brand" href="{{ url('/') }}">Lend Stuff</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
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
            <li class="nav-item">
                <a class="nav-link" href="">Contact</a>
            </li>
        </ul>
    </div>
    <div class="ml-auto">
        <a class="btn btn-sm btn-danger" href="{{ url('logout') }}">Logout</a>
    </div>
</nav>
</nav>
<div class="card mt-4">
    <div class="card-header">
        Items Available for Lending
    </div>
    <div class="card-body">
        <ul class="list-group">
            @forelse ($availableItems as $item)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <div>
                        Name: {{ $item->name }}
                        <br>Category: {{ $item->category }}
                        <br>Status: 
                        <span class="badge badge-success">Available</span>
                    </div>
                    <div>
                        <form action="{{ route('removeProduct', $item->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Remove</button>
                        </form>
                    </div>
                </li>
            @empty
                <li class="list-group-item">You do not have any items available for lending currently.</li>
            @endforelse
        </ul>
    </div>
</div>
<div class="card mt-4">
    <div class="card-header">
        Items I Am Lending Out
        <a href="{{ route('addProductForm') }}" class="btn btn-primary float-right">Add Product</a>
    </div>
    <div class="card-body">
        <ul class="list-group">
            @forelse ($lending as $item)
                <li class="list-group-item">
                    Name: {{ $item->name }}
                    <br>Category: {{ $item->category }}
                    <br>Lent to: {{ $item->borrower->name }}
                    <br>Lend Date: {{ $item->lend_date->format('F d, Y') }}
                    <br>Return Date: {{ optional($item->return_date)->format('F d, Y') ?? 'Not Available' }}
                </li>
            @empty
                <li class="list-group-item">You are not lending out any items currently.</li>
            @endforelse
        </ul>
    </div>
</div>

<!-- Items I Have Borrowed -->
<div class="card mt-4">
    <div class="card-header">
        Items I Have Borrowed
    </div>
    <div class="card-body">
        <ul class="list-group">
            @forelse ($borrowed as $item)
                <li class="list-group-item">
                    Name: {{ $item->name }}
                    <br>Category: {{ $item->category }}
                    <br>Borrowed from: {{ $item->owner->name }}
                                        @if ($item->state === 'borrowed')
                        <form action="{{ route('returnProduct', $item->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-warning" style="float: right;">Return</button>
                        </form>
                    @elseif ($item->state === 'waiting_for_acceptance')
                        <span class="badge badge-info" style="float: right; font-size:1rem;color:black">Waiting for Acceptance</span>
                    @endif
                    <br>Lend Date: {{ $item->lend_date->format('F d, Y') }}
                    <br>Return Date: {{ optional($item->return_date)->format('F d, Y') ?? 'Not Available' }}
                </li>
            @empty
                <li class="list-group-item">You have not borrowed any items.</li>
            @endforelse
        </ul>
    </div>
</div>

