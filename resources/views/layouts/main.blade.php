<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
		<link rel="stylesheet" href="{{ asset('css/my.css') }}">
		<script src="{{asset('js/jquery.js')}}"></script>
		<script src="{{asset('js/my.js')}}"></script>
		<title>@yield('head_title')</title>
	</head>
	<body class="m-2">
		@yield('content')
	</body>
</html>
