@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card mt-4">
        <div class="card-header">
            Leave a Comment
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <form action="{{ route('comments.store', $product->id) }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="comment">Comment</label>
                    <textarea name="comment" id="comment" class="form-control" placeholder="Add a comment"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Submit Comment</button>
            </form>
        </div>
    </div>
</div>
@endsection