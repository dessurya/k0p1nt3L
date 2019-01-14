<!DOCTYPE html>
<html>
<head>
	@yield('title')

	<meta charset="utf-8">
	<meta http-equiv="Content-Language" content="{{ App::getLocale() }}" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @yield('meta')

	<meta name="image" content="{{ asset('asset/picture-default/kopin-icon.png') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
	<meta name="robots" content="index, follow" />
	<meta name="googlebot" content="all"/>

	<link rel="icon" type="image/png" href="{{ asset('asset/picture-default/kopin-icon.png') }}" />
	
	<link rel="stylesheet" href="{{ asset('asset/font/_font.css') }}">
	<link rel="stylesheet" href="{{ asset('asset/css/public.css') }}">
	
	@if(!route::is('main.home'))
	<link rel="stylesheet" type="text/css" href="{{ asset('asset/css/public-sub.css') }}">
	@endif
	@yield("include_css")
	
	<script src="{{ asset('jquery/jquery-3.2.0.min.js') }}"></script>
</head>
<body>
	@include('main._layout.navigasibar')
	<div id="kopin_banner">
		<div class="wrapper lg">
			<img src="{{ asset('asset/picture-default/kopin_banner.png') }}">
			<div id="burger">
				<div></div>
				<div></div>
				<div></div>
			</div>
		</div>
	</div>
	@yield("body")
	@include('main._layout.footer')

	<script type="text/javascript" src="{{ asset('asset/js/public.js') }}"></script>
	@yield("include_js")
</body>
</html>