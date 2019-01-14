@extends('main._layout.main')

@section('title')
	<title>KOPINFRA - {{ $view->name }}</title>
@endsection

@section('meta')
	<meta name="title" content="KOPINFRA - {{ $view->name }}">
	<meta name="description" content="{{ $view->name.' - '.Str::words(strip_tags(__($view->content)), 25, ' ...') }}">
	<meta name="keywords" content=""/>
@endsection

@section('include_css')
	<link rel="stylesheet" href="{{ asset('asset/css/newsevent.css') }}">
@endsection

@section('body')
	
	<div id="newsevent" class="view">
		<div class="wrapper">
			<h1 class="text-center">
				{{ title_case($view->name) }}
				<div class="underline_style"><div></div></div>
			</h1>
		</div>
		<div class="wrapper read">
			<img src="{{ asset('asset/picture/news-event/'.$view->picture) }}">
			{!! $view->content !!}
			<div class="clearfix"></div>
		</div>
		<div class="wrapper">
			<div id="list-item" class="text-center">
				@foreach($newsevent as $list)
				@include('main._layout._newsevent_list')
				@endforeach
			</div>
		</div>
	</div>
@endsection