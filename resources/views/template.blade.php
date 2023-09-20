@extends('layouts.master')

@section('title', 'Page Title')

@section('styles')
    <!-- Include specific CSS styles for this page -->
    <link rel="stylesheet" href="path/to/your/css/file.css">
@endsection

@section('content')
    <!-- Content specific to this page -->
    <h1>Welcome to My Page</h1>
    <p>This is the content of the page.</p>
@endsection

@section('scripts')
    <!-- Include specific JavaScript for this page -->
    <script src="path/to/your/js/file.js"></script>
@endsection
