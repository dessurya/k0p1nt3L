@extends('main._layout.main')

@section('title')
	<title>KOPINFRA</title>
@endsection

@section('meta')
	<meta name="title" content="KOPINFRA">
	<meta name="description" content="KOPERASI KARYAWAN TELKOM INFRA - Maju Bersama Sukses Bersama Sejahtera Bersama | {{ Str::words(strip_tags(__('main.tetang_perusahaan_content')), 25, ' ...') }}">
	<meta name="keywords" content=""/>
@endsection

@section('include_css')
	<link rel="stylesheet" type="text/css" href="{{ asset('vendors/owl-carousel/owl.carousel.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('vendors/owl-carousel/owl.theme.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('vendors/owl-carousel/owl.transitions.css') }}">

	<link rel="stylesheet" href="{{ asset('asset/css/home.css') }}">
@endsection

@section('body')
	@if((count($portofolio)+count($banner)) >= 1)
	<div id="banner">
		@foreach($portofolio as $list)
		<div class="item">
			<div id="img" style="background-image: url('{{ asset('asset/picture/portofolio/'.$list->picture_first) }}');">
				<div id="wrapper">
					<h1>{{ $list->name }}</h1>
					<p>{{ Str::words(strip_tags($list->content), 25, ' ...') }}</p>
					<div id="link">
						<a class="links" href="">
							@lang('main.lihat_detail')
						</a>
					</div>
				</div>
			</div>
		</div>
		@endforeach
		@foreach($banner as $list)
		<div class="item">
			<div id="img" style="background-image: url('{{ asset('asset/picture/banner/'.$list->picture) }}');"></div>
		</div>
		@endforeach
	</div>
	@endif
	
	<div id="about" style="background-image: url('{{ asset('asset/picture-default/bg-company.jpg') }}');">
		<div class="wrapper text-center">
			<h1>@lang('main.tetang_perusahaan')</h1>
			<p>
				{{ Str::words(strip_tags(__('main.tetang_perusahaan_content')), 65, ' ...') }}
			</p>
			<div id="link">
				<a class="links" href="">
					@lang('main.baca_selengkapnya')
				</a>
			</div>
		</div>
		@if(count($newsevent) >= 1)<img src="{{ asset('asset/picture-default/newsevent-top.png') }}">@endif
	</div>

	@if(count($newsevent) >= 1)
	<div id="newsevent">
		<div class="wrapper">
			<h1 class="text-center">
				@lang('main.berita_acara')
				<div class="underline_style"><div></div></div>
			</h1>
			<div id="list-item" class="text-center">
				@foreach($newsevent as $list)
				<div class="list text-left">
					<a href="">
						<div id="img" style="background-image: url('{{ asset('asset/picture/news-event/'.$list->picture) }}')"></div>
					</a>
					<div id="desc">
						<h3>{{ $list->name }}</h3>
						<p>{{ Str::words(strip_tags($list->content), 5, ' ...') }}</p>
					</div>
				</div>
				@endforeach
			</div>
		</div>
	</div>
	@endif

	@if(count($partner) >= 1)
	<div id="partners" style="background-image: url('{{ asset('asset/picture-default/bg-partner.jpg') }}');">
		@if(count($newsevent) >= 1)<img id="newsevent_img" src="{{ asset('asset/picture-default/newsevent-bottom.png') }}">@endif
		<div class="wrapper text-center">
			<h1>@lang('main.mitra_kami')</h1>
			<div id="list-item">
				@foreach($partner as $list)
				<a href="{{ $list->web == null ? '#' : $list->web }}">
					<img title="{{ $list->name }}" src="{{ asset('asset/picture/partner/'.$list->picture) }}">
				</a>
				@endforeach
			</div>
		</div>
	</div>
	@endif

@endsection

@section('include_js')
	<script type="text/javascript" src="{{ asset('vendors/owl-carousel/owl.carousel.min.js') }}"></script>
	<script type="text/javascript">
		$("#banner").owlCarousel({
			transitionStyle : "fadeUp",
			navigation : false,
			items: 1,
			singleItem:true,
			pagination:true,
			autoPlay: 5000,
		    stopOnHover:false
		});
	</script>
@endsection
