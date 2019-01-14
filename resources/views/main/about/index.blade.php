@extends('main._layout.main')

@section('title')
	<title>KOPINFRA - @lang('main.tetang_perusahaan')</title>
@endsection

@section('meta')
	<meta name="title" content="KOPINFRA - @lang('main.tetang_perusahaan')">
	<meta name="description" content="KOPERASI KARYAWAN TELKOM INFRA - Maju Bersama Sukses Bersama Sejahtera Bersama | {{ Str::words(strip_tags(__('main.tetang_perusahaan_content')), 25, ' ...') }}">
	<meta name="keywords" content=""/>
@endsection

@section('include_css')
	<link rel="stylesheet" href="{{ asset('asset/css/about.css') }}">
@endsection

@section('body')
	
	<div id="about">
		<img id="top" src="{{ asset('asset/picture-default/pict_red.png') }}">
		<img id="bot" src="{{ asset('asset/picture-default/bubble-left.png') }}">
		<div class="wrapper">
			<h1>@lang('main.tetang_perusahaan')</h1>
			<div class="">
				{!! __('main.tetang_perusahaan_content') !!}
			</div>

			<div class="tab">
				<div class="row">
					<div class="col">
						<h1>@lang('main.visi')</h1>
						@lang('main.visi-content')
					</div>
					<div class="col">
						<h1>@lang('main.misi')</h1>
						@lang('main.misi-content')
					</div>
				</div>
			</div>
		</div>
	</div>

	@if(count($certificate) >= 1)
	<div id="certification" style="background-image: url('{{ asset('asset/picture-default/bg-partner.jpg') }}');">
		<div class="wrapper">
			<h1 class="text-center">
				@lang('main.sertifikasi')
				<div class="underline_style"><div></div></div>
			</h1>
			
			<div id="list-item" class="text-center">
				@foreach($certificate as $list)
				@include('main._layout._certification_list')
				@endforeach
			</div>


			<div id="link" class="text-center">
				<div id="response-call"></div>
				<a id="call-certification" class="links" href="{{ route('main.certification.cl') }}">
					@lang('main.lihat_lebih_banyak')
				</a>
			</div>
		</div>
	</div>
	@endif

	@if(count($management) >= 1)
	<div id="management">
		<img id="left" src="{{ asset('asset/picture-default/bubble-left.png') }}">
		<img id="right" src="{{ asset('asset/picture-default/bubble-right.png') }}">
		<div class="wrapper">
			<h1 class="text-center">
				@lang('main.tim_manajemen')
				<div class="underline_style"><div></div></div>
			</h1>
			
			<div id="list-item" class="text-center">
				@foreach($management as $list)
				<div class="list text-left">
					<div id="img" style="background-image: url('{{ asset('asset/picture/management/'.$list->picture) }}')"></div>
					<div id="desc" class="text-center">
						<h2>{{ $list->name }}</h2>
						<h3>{{ $list->position }}</h3>
					</div>
				</div>
				@endforeach
			</div>
		</div>
	</div>
	@endif
@endsection

@section('include_js')
	<script type="text/javascript">
		var page = 1;
		$(function(){
			$(document).on('click', 'a#call-certification', function(){
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
	                            $('#certification #list-item').append(data.html);
	                        }, 350);
	                        window.setTimeout(function() {
	                            $('#response-call').hide().html('');
	                        }, 1675);
	                	}
	                	else{
	                		window.setTimeout(function() {
		                		$('#certification a#call-certification').addClass('disable');
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
