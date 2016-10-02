<!-- /resources/views/terms/create.blade.php -->
@extends('layouts.app')

@section('content')

	<ul class="breadcrumb breadcrumb-section">
		<li><a href="{!! url('/'); !!}">Home</a></li>
		<li><a href="{!! url('/terms/'); !!}">Terms</a></li>
		<li class="active">Create new term</li>
	</ul>

	<h2>Create Term</h2>

	@if (count($errors) > 0)
		<div class="alert alert-danger">
		<ul>
		@foreach ($errors->all() as $error)
			<li>{{ $error }}</li>
		@endforeach
		</ul>
		</div>
	@endif

	{!! Form::model(new App\Term, ['route' => ['terms.store']]) !!}
	@include('terms/partials/_form', ['submit_text' => 'Create Term'])
	{!! Form::close() !!}
@endsection
