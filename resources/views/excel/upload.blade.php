<!-- /resources/views/excel/upload.blade.php -->
@extends('layouts.app')

@section('content')

	<ul class="breadcrumb breadcrumb-section">
	<li><a href="{!! url('/'); !!}">Home</a></li>
	<li class="active">Import excel content</li>
	</ul>

	<h2>Import terms</h2>
	<h4>Please make use of the upload form below</h4>

	<p>This page can be used to import content to the tool</p>
	<p><a href="{{ url('downloadexcel') }}">Download the excel template</a></p>

	@if (count($errors) > 0)
		<div class="alert alert-danger">
		<ul>
		@foreach ($errors->all() as $error)
			<li>{{ $error }}</li>
		@endforeach
		</ul>
		</div>
	@endif

	{!! Form::open(array('action' => 'ExcelController@postexcel', 'id' => 'form', 'files'=> 'true')) !!}

	<br>
	{!! Form::file('excel') !!}
	<p class="errors">{!! $errors->first('excel') !!}</p>

	<button type="submit" class="btn btn-primary">Upload</button>
	<input type="hidden" name="_token" value="{!! csrf_token() !!}">
	{!! Form::close() !!}

@endsection
