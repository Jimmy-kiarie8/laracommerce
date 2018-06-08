@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    {{-- {{$products}} --}}
                    {{-- <form action="{{ route('addcart', ['id']) }}" method="post">
                        <input type="text" name="price">
                        <input type="text" name="qty">
                        <input type="submit" value="add">
                    </form> --}}
                    @if (Session::has('user'))
                        @foreach ($products as $product)
                            <li class="list-group">
                                <span class="badge"> {{ $product['qty'] }} </span>
                                <strong> {{ $product['price'] }} </strong>
                            </li>
                        @endforeach
                    @else
                    no cart
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
