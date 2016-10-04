<!-- /resources/views/errors/403.blade.php -->
@extends('layouts.app')

@section('content')
	<h2>403 Error</h2>
	<div class="title">{{ $exception->getMessage() }}</div>
@endsection
