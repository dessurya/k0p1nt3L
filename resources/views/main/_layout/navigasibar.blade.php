<div id="navigasi">
	<div id="wrapper">
		<div id="logo">
		</div>
		<div id="list">
			<div class="tab">
				<div class="row">
					<div class="col">
						<a class="{{ route::is('main.home') ? 'active' : '' }}" href="{{ route('main.home') }}">
							@lang('main.beranda')
						</a>
					</div>
					<div class="col">
						<a class="{{ route::is('main.about') ? 'active' : '' }}" href="{{ route('main.about') }}">
							@lang('main.tetang_perusahaan')
						</a>
					</div>
					{!! (new App\Http\Controllers\FrontController)->getNavbar('header') !!}
					<?php 
					/* semua dipanggil dari controller diatas
					<div class="col">
						<a class="{{ route::is('main.portofolio*') ? 'active' : '' }}" href="{{ route('main.portofolio') }}">
							@lang('main.portofolio')
						</a>
					</div>
					<div class="col">
						<a class="{{ route::is('main.newsevent*') ? 'active' : '' }}" href="{{ route('main.newsevent') }}">
							@lang('main.berita_acara')
						</a>
					</div>
					<div class="col">
						<a class="{{ route::is('main.career') ? 'active' : '' }}" href="{{ route('main.career') }}">
							@lang('main.karier')
						</a>
					</div>
					*/?>
					<div class="col">
						<a class="{{ route::is('main.contact') ? 'active' : '' }}" href="{{ route('main.contact') }}">
							@lang('main.kontak')
						</a>
					</div>
					<div class="col">
						<a id="lc" href="{{ route('locale.change', ['lang' => App::getLocale() == 'id' ? 'en' : 'id' ]) }}">
							@lang('main.select_lang') &nbsp;&nbsp;&nbsp;&nbsp;<div></div>
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>