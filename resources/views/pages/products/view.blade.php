@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <p>Producs Show</p>
                            <a href="{{ route('product.index') }}" class="btn btn-primary">list product</a>
                        </div>
                    </div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <div class="d-flex w-100">
                            @foreach ($product->images as $image)
                                <img class="w-25 h-25" src="{{ asset($image->image ?? '') }}" alt="">
                            @endforeach
                        </div>

                        <div class="mt-4">
                            <h4>Product Info</h4>
                            <table class="table">
                                <tr>
                                    <td>Product Name</td>
                                    <td>{{ $product->name ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td>product Details</td>
                                    <td>{{$product->description ?? 'N/A'}}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
