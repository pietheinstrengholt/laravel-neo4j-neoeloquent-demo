<!-- /resources/views/terms/index.blade.php -->
@extends('layouts.app')

@section('content')

	<ul class="breadcrumb breadcrumb-section">
	<li><a href="{!! url('/'); !!}">Home</a></li>
	<li class="active">Terms</li>
	</ul>

	<h2>Terms</h2>
	<h4>Please make a selection of one of the following terms</h4>

	@if ( !$terms->count() )
		No terms found in the database!<br><br>
	@else
		<table class="table section-table dialog table-striped" border="1">

		<tr class="info">
			<td class="header">Term name</td>
			<td class="header">Term definition</td>
		</tr>

		@foreach( $terms as $term )
			<tr>
				<td>{{ $term->term_name }}</td>
				<td>{{ $term->term_defition }}</td>
			</tr>
		@endforeach

		</table>
	@endif

	@if (Auth::check())
		<p>
		<a href="{{ route('terms.create') }}">Create term</a>
		</p>
	@endif

@endsection
