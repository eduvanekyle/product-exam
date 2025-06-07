@extends('layouts.app')

@section('title', 'Products')

@section('content')
    <div class="products">
        <div class="header">
            <h1 class="fw-bold text-center">Products</h1>
        </div>

        <div class="form">
            @include('partials.product-form')
        </div>

        <div class="product-table-container">
            @include('partials.product-table')
        </div>
    </div>
@endsection

<script src="{{ asset('js/products.js') }}" defer></script>
