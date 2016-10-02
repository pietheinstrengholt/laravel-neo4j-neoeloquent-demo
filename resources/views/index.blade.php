<!-- /resources/views/index.blade.php -->
@extends('layouts.app')
<head>
	<style>
	.img-thumbnail, body {
	    background-color: #f5f8fa;
	}
	</style>
</head>
@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">Dashboard</div>

				<div class="panel-body">
					@if (Auth::check())
						You are logged in!
					@else
						You need to log on first!
					@endif
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
