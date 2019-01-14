@extends('main._layout.main')

@section('title')
	<title>KOPINFRA - @lang('main.karier')</title>
@endsection

@section('meta')
	<meta name="title" content="KOPINFRA - @lang('main.karier')">
	<meta name="description" content="KOPERASI KARYAWAN TELKOM INFRA - Maju Bersama Sukses Bersama Sejahtera Bersama | {{ Str::words(strip_tags(__('main.tetang_perusahaan_content')), 25, ' ...') }}">
	<meta name="keywords" content=""/>
@endsection

@section('include_css')
	<link rel="stylesheet" href="{{ asset('vendors/baguetteBox/baguetteBox.min.css') }}">
	<link rel="stylesheet" href="{{ asset('asset/css/career.css') }}">
@endsection

@section('body')
	
	<div id="career">
		<div class="wrapper">
			<h1 class="text-center">
				@lang('main.karier')
				<div class="underline_style"><div></div></div>
			</h1>
			
			<div id="list-item" class="text-center">
				@foreach($career as $list)
				@include('main._layout._career_list')
				@endforeach
			</div>

			<div id="link" class="text-center">
				<div id="response-call"></div>
				<a id="call-career" class="links @if(count($career) == 0) disable @endif" href="{{ route('main.career.cl') }}">
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
