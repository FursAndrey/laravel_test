@extends('layouts.main')

@section('head_title')Laravel V1.1 @endsection

@section('content')
	<h1>Test</h1>
	<p>
		<a href="{{ route('calc-form') }}" class="btn btn-primary stretched-link col-12">Расчет</a>
	</p>
@endsection