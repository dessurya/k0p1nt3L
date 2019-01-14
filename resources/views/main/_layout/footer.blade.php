<div id="footer">
	<div id="information">
		<div id="wrap">
			<div class="tab">
				<div class="row">
					<div class="col">
						<h2>@lang('main.informasi')</h2>
						<div id="info" class="tab">
							<div class="row">
								<div class="col">
									<img src="{{ asset('asset/picture-default/i-phone.png') }}">
								</div>
								<div class="col">
									<p>021 8308464</p>
								</div>
							</div>
							<div class="row">
								<div class="col">
									<img src="{{ asset('asset/picture-default/i-mail.png') }}">
								</div>
								<div class="col">
									<p>marketing@kopinfra.co.id</p>
								</div>
							</div>
							<div class="row">
								<div class="col">
									<img src="{{ asset('asset/picture-default/i-location.png') }}">
								</div>
								<div class="col">
									<p>Jln. MT Haryono Kav 10 Lantai 5 Suit 504 Jakarta Selatan, Indonesia</p>
								</div>
							</div>
						</div>
					</div>
					<div class="col">
						<div>
							<a class="{{ route::is('main.home') ? 'active' : '' }}" href="{{ route('main.home') }}">
								@lang('main.beranda')
							</a>
						</div>
						<div>
							<a class="{{ route::is('main.about') ? 'active' : '' }}" href="{{ route('main.about') }}">
								@lang('main.tetang_perusahaan')
							</a>
						</div>
						{!! (new App\Http\Controllers\FrontController)->getNavbar('footer') !!}
						<?php 
							/* semua dipanggil di controll diatas
						<div>
							<a class="{{ route::is('main.portofolio*') ? 'active' : '' }}" href="{{ route('main.portofolio') }}">
								@lang('main.portofolio')
							</a>
						</div>
						<div>
							<a class="{{ route::is('main.newsevent*') ? 'active' : '' }}" href="{{ route('main.newsevent') }}">
								@lang('main.berita_acara')
							</a>
						</div>
						<div>
							<a class="{{ route::is('main.career') ? 'active' : '' }}" href="{{ route('main.career') }}">
								@lang('main.karier')
							</a>
						</div>
						*/?>
						<div>
							<a class="{{ route::is('main.contact') ? 'active' : '' }}" href="{{ route('main.contact') }}">
								@lang('main.kontak')
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="copyright">
		<div id="wrap">
			<div class="tab">
				<div class="row">
					<div class="col">
						<img src="{{ asset('asset/picture-default/copy_right.png') }}"> <!-- &copy; --> @lang('main.footer_hakcipta')
					</div>
					<div class="col">
						|
					</div>
					<div class="col">
						@lang('main.footer_didukung') Telkominfra
					</div>
				</div>
			</div>
		</div>
	</div>
</div>