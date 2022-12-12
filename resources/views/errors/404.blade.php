@extends('errors::minimal')

@section('title', __('Not Found'))
@section('code', '404')
@section('message')
    <h2>{{ $exception->getMessage() }}</h2>
@endsection
