@extends('layout.frontLayout')

@section('title')
    Admin
@endsection

@section('content')

@section('css')
    @parent
    <link rel="stylesheet" href="{{asset('/')}}css/paginacija.css">
@endsection

@include('admin.admin_link')

@yield('admin')

@endsection
