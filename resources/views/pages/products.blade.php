@extends('layouts.app')

@section('title', 'Products')

@section('content')
    <div class="products">
        <div class="header">
            {{-- <h1 class="fw-bold text-center">Products</h1> --}}
        </div>

        <div class="form">
            <h3 class="fw-bold mb-4">Add a Product</h3>
            @include('partials.product-form')
        </div>

        <div class="product-table-container">
            <h3 class="fw-bold mb-3 mt-4">Products</h3>
            @include('partials.product-table')
        </div>
    </div>
@endsection

<script src="{{ asset('js/products.js') }}" defer></script>
