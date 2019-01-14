@extends('main._layout.main')

@section('title')
	<title>KOPINFRA - @lang('main.portofolio')</title>
@endsection

@section('meta')
	<meta name="title" content="KOPINFRA - @lang('main.portofolio')">
	<meta name="description" content="KOPERASI KARYAWAN TELKOM INFRA - Maju Bersama Sukses Bersama Sejahtera Bersama | {{ Str::words(strip_tags(__('main.tetang_perusahaan_content')), 25, ' ...') }}">
	<meta name="keywords" content=""/>
@endsection

@section('include_css')
	<link rel="stylesheet" href="{{ asset('asset/css/portofolio.css') }}">
@endsection

@section('body')
	<div id="portofolio">
		<h1 class="text-center">
			@lang('main.portofolio')
			<div class="underline_style"><div></div></div>
		</h1>
		
		<div id="list-item">
			@foreach($portofolio as $list)
			<div class="list">
				<div class="float">
					<div class="tab">
						<div class="row">
							<div class="col">
								<div class="pad">
									<h2>{{ $list->name }}</h2>
									{!! $list->content !!}
									<div class="link">
										<a class="links" href="{{ route('main.portofolio.galeri', ['slug'=>$list->slug]) }}">@lang('main.tampilkan')</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="float">
					<div class="tab">
						<div class="row">
							<div class="col">
								<img src="{{ asset('asset/picture/portofolio/'.$list->picture_second) }}">
							</div>
						</div>
					</div>
				</div>
				<div class="clearfix"></div>
				<img class="bubble left" src="{{ asset('asset/picture-default/bubble-left.png') }}">
				<img class="bubble right" src="{{ asset('asset/picture-default/bubble-right.png') }}">
			</div>
			@endforeach
		</div>

	</div>
@endsection

@section('include_js')
	
@endsection
