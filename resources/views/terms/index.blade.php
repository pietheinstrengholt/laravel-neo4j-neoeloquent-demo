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
			@if (Auth::check())
				 <td class="header" style="width: 190px;">Options</td>
			@endif
		</tr>

		@foreach( $terms as $term )
			<tr>
				<td>{{ $term->term_name }}</td>
				<td>{{ $term->term_definition }}</td>
				<td>
					@if (Auth::check())
						{!! Form::open(array('class' => 'form-inline', 'method' => 'DELETE', 'route' => array('terms.destroy', $term->id), 'onsubmit' => 'return confirm(\'Are you sure to delete this terms?\')')) !!}
						{!! link_to_route('terms.edit', 'Edit', array($term->id), array('class' => 'btn btn-info btn-xs')) !!}
						{!! Form::submit('Delete', array('class' => 'btn btn-danger btn-xs', 'style' => 'margin-left:3px;')) !!}
						{!! Form::close() !!}
					@endcan
				</td>
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
