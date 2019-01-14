@extends('main._layout.main')

@section('title')
	<title>KOPINFRA - @lang('main.kontak')</title>
@endsection

@section('meta')
	<meta name="title" content="KOPINFRA - @lang('main.kontak')">
	<meta name="description" content="KOPERASI KARYAWAN TELKOM INFRA - Maju Bersama Sukses Bersama Sejahtera Bersama | {{ Str::words(strip_tags(__('main.tetang_perusahaan_content')), 25, ' ...') }}">
	<meta name="keywords" content=""/>
@endsection

@section('include_css')
	<link rel="stylesheet" href="{{ asset('asset/css/contact.css') }}">
@endsection

@section('body')
	
	<div id="location">
		<div class="wrapper text-center">
			<h1>
				@lang('main.lokasi_kami')
				<div class="underline_style"><div></div></div>
			</h1>
			<p>@lang('main.lokasi_kami_content')</p>
			<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15864.66699219473!2d106.84679211999813!3d-6.241742569391065!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f3bb92b76439%3A0x741cf9783321790d!2sTelkom+Infra!5e0!3m2!1sid!2sid!4v1540797256638" width="100%" frameborder="0" style="border:0" allowfullscreen></iframe>
			<div id="link" class="text-center">
				<a class="links" href="https://goo.gl/maps/wn2WALLWSfx" target="_blank">
					@lang('main.dapatkan_arah')
				</a>
			</div>
		</div>
	</div>

	<div id="contact" style="background-image: url('{{ asset('asset/picture-default/bg-partner.jpg') }}');">
		<div class="wrapper">
			<h1 class="text-center">
				@lang('main.hubungin_kami')
				<div class="underline_style"><div></div></div>
			</h1>
			
			<form action="{{ route('main.contact.send') }}">
				<h3>@lang('main.pesan')</h3>
				<div>
					<label id="e_name"></label>
					<input type="text" name="name" placeholder="@lang('main.nama')" required>
				</div>
				<div>
					<label id="e_handphone"></label>
					<input type="text" name="handphone" placeholder="Handphone">
				</div>
				<div>
					<label id="e_email"></label>
					<input type="mail" name="email" placeholder="Email" required>
				</div>
				<div>
					<label id="e_subject"></label>
					<input type="text" name="subject" placeholder="@lang('main.subyek')" required>
				</div>
				<div>
					<label id="e_message"></label>
					<textarea name="message" placeholder="@lang('main.pesan')" rows="5" required></textarea>
				</div>
				<div id="link" class="text-center">
					<div id="response-send"></div>
					<button type="submit" class="links">
						@lang('main.kirim_submit')
					</button>
				</div>
			</form>
		</div>
	</div>
@endsection

@section('include_js')
	<script type="text/javascript">
		$(function(){
	        $(document).on('submit', '#contact form', function(){
	            var url   = $(this).attr('action');
	            var data  = $(this).serializeArray();

	            $.ajaxSetup({
	                headers: {
	                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	                }
	            });
	            $.ajax({
	                url: url,
	                type: 'post',
	                dataType: 'json',
	                data: data,
	                beforeSend: function() {
	                    $('#contact form label').html('').hide();
	                    $('#contact form #response').show();
	                    $('#contact form #response-send').show().html("{{ __('main.mengirim_permintaan_anda') }}");
	                },
	                success: function(data) {
	                    $('#contact form #response-send').html(data.msg);
	                    if (data.response == false) {
	                        $.each(data.resault, function(key, val){
	                            $('#contact form label#e_'+key).html(val).show();
	                        });
	                        window.setTimeout(function() {
	                            // $('#contact form label').html('').hide();
	                            $('#contact form #response-send').html('').hide();
	                        }, 2750);
	                    }
	                }
	            });
	            return false;
	        });
	    });
	</script>	
@endsection
