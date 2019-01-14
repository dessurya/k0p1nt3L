@extends('main._layout.main')

@section('title')
	<title>KOPINFRA - @lang('main.berita_acara')</title>
@endsection

@section('meta')
	<meta name="title" content="KOPINFRA - @lang('main.berita_acara')">
	<meta name="description" content="KOPERASI KARYAWAN TELKOM INFRA - Maju Bersama Sukses Bersama Sejahtera Bersama | {{ Str::words(strip_tags(__('main.tetang_perusahaan_content')), 25, ' ...') }}">
	<meta name="keywords" content=""/>
@endsection

@section('include_css')
	<link rel="stylesheet" href="{{ asset('asset/css/newsevent.css') }}">
@endsection

@section('body')
	
	<div id="newsevent">
		<div class="wrapper">
			<h1 class="text-center">
				@lang('main.berita_acara')
				<div class="underline_style"><div></div></div>
			</h1>
			
			<div id="list-item" class="text-center">
				@foreach($newsevent as $list)
				@include('main._layout._newsevent_list')
				@endforeach
			</div>

			<div id="link" class="text-center">
				<div id="response-call"></div>
				<a id="call-newsevent" class="links @if(count($newsevent) == 0) disable @endif" href="{{ route('main.newsevent.cl') }}">
					@lang('main.lihat_lebih_banyak')
				</a>
			</div>

		</div>
	</div>
@endsection

@section('include_js')
	<script type="text/javascript">
		var page = 1;
		$(function(){
			$(document).on('click', 'a#call-newsevent', function(){
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
	                            $('#newsevent #list-item').append(data.html);
	                        }, 350);
	                        window.setTimeout(function() {
	                            $('#response-call').hide().html('');
	                        }, 1675);
	                	}
	                	else{
	                		window.setTimeout(function() {
		                		$('#newsevent a#call-newsevent').addClass('disable');
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
