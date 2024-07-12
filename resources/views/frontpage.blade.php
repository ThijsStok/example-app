@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Mijn uitgeleende producten</div>
                <p>hallo
                <div class="card-body">
                    {{-- @if (count($user->products) > 0) --}}
                        {{-- <table class="table">
                            <thead>
                                <tr>
                                    <th>Productnaam</th>
                                    <th>Uitgeleend aan</th>
                                    <th>Deadline</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($user->products as $product)
                                    <tr>
                                        <td>{{ $product->name }}</td>
                                        <td>{{ $product->borrower->name }}</td>
                                        <td>{{ $product->deadline }}</td>
                                        <td>{{ $product->status }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table> --}}
                    {{-- @else --}}
                        <p>Je hebt nog geen producten uitgeleend.</p>
                    {{-- @endif --}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
