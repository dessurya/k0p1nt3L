@extends('main._layout.main')

@section('title')
	<title>KOPINFRA - {{ $portofolio->name }}</title>
@endsection

@section('meta')
	<meta name="title" content="KOPINFRA - {{ $portofolio->name }}">
	<meta name="description" content="KOPERASI KARYAWAN TELKOM INFRA - {{ $portofolio->name }} | {{ Str::words(strip_tags($portofolio->content), 25, ' ...') }}">
	<meta name="keywords" content=""/>
@endsection

@section('include_css')
	<link rel="stylesheet" href="{{ asset('vendors/baguetteBox/baguetteBox.min.css') }}">
	<link rel="stylesheet" href="{{ asset('asset/css/career.css') }}">
@endsection

@section('body')
	
	<div id="career">
		<div class="wrapper">
			<h1 class="text-center" style="margin-bottom: 60px;">
				{{ $portofolio->name }}
				<div class="underline_style"><div></div></div>
			</h1>
			{!! $portofolio->content !!}
			@if($portofolio->project)
			<h3>@lang('main.ruang_lingkup_project')</h3>
			{!! $portofolio->project !!}
			@endif
			<div id="list-item" class="text-center">
				@foreach($gallery as $list)
				@include('main._layout._portfolio_galeri_list')
				@endforeach
			</div>

			<div id="link" class="text-center">
				<div id="response-call"></div>
				<a id="call-career" class="links @if(count($gallery) == 0) disable @endif" href="{{ route('main.portofolio.galeri.cl', ['slug'=>$portofolio->slug]) }}">
					@lang('main.lihat_lebih_banyak')
				</a>
			</div>

		</div>
	</div>
@endsection

@section('include_js')
	<script type="text/javascript" src="{{ asset('vendors/baguetteBox/baguetteBox.min.js') }}"></script>
	<script type="text/javascript">
		baguetteBox.run('#career #list-item');
	</script>
	<script type="text/javascript">
		var page = 1;
		$(function(){
			$(document).on('click', 'a#call-career', function(){
				if ($(this).hasClass('disable')) {
					return false;
				}
				page += 1;
				var url = $(this).attr('href')+'?page='+page;
				$.ajaxSetup({
	                headers: {
	                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	                }
	            });
	            $.ajax({
	                url: url,
	                type: 'get',
	                dataType: 'json',
	                beforeSend: function() {
	                    $('#response-call').show().html("{{ __('main.memuat_harap_tunggu') }}... {{ __('main.memuat_harap_tunggu') }}...");
	                },
	                success: function(data) {
	                	if (data.html) {
	                		window.setTimeout(function() {
	                            $('#career #list-item').append(data.html);
	                        }, 350);
	                        window.setTimeout(function() {
		                        baguetteBox.run('#career #list-item');
	                        }, 750);
	                        window.setTimeout(function() {
	                            $('#response-call').hide().html('');
	                        }, 1675);
	                	}
	                	else{
	                		window.setTimeout(function() {
		                		$('#career a#call-career').addClass('disable');
	                        }, 350);
	                        window.setTimeout(function() {
	                            $('#response-call').show().html("{{ __('main.data_tidak_ditemukan') }}");
	                        }, 475);
	                        window.setTimeout(function() {
	                            $('#response-call').hide().html('');
	                        }, 1675);
	                	}
	                }
	            });
	            return false;
			});
		});
	</script>	
@endsection
