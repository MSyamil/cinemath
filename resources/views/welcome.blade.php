@extends('layouts.app')

@section('body_class', 'h-screen overflow-hidden')
@section('wrapper_class', 'h-screen overflow-hidden')

@section('content')
    <div class="w-full flex justify-center items-center">
        <x-ahp-card />
    </div>
@endsection
