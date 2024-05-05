@extends('layouts.horizontal')

@section('content')
    @livewire('cart', ['cart' => $cart])
@endsection
