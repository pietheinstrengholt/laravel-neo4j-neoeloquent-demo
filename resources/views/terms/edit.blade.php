<!-- /resources/views/terms/edit.blade.php -->
@extends('layouts.app')

@section('content')

	<ul class="breadcrumb breadcrumb-section">
		<li><a href="{!! url('/'); !!}">Home</a></li>
		<li><a href="{!! url('/terms/'); !!}">Terms</a></li>
		<li class="active">{{ $term->term_name }}</li>
	</ul>

	<h2>Edit Term</h2>

	@if (count($errors) > 0)
		<div class="alert alert-danger">
		<ul>
		@foreach ($errors->all() as $error)
			<li>{{ $error }}</li>
		@endforeach
		</ul>
		</div>
	@endif

	{!! Form::model($term, ['method' => 'PATCH', 'route' => ['terms.update', $term->id]]) !!}
	@include('terms/partials/_form', ['submit_text' => 'Edit Term', 'propose_text' => 'Propose Term'])
	{!! Form::close() !!}
@endsection
