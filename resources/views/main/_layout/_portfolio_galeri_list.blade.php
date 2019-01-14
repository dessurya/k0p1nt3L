<div class="list text-left">
	<div id="wrapper">
		<a href="{{ asset('asset/picture/portofolio-galeri/'.$list->picture) }}">
			<div id="img" style="background-image: url('{{ asset('asset/picture/portofolio-galeri/'.$list->picture) }}')"></div>
			<div id="desc">
				<p>{{ date("d F y", strtotime($list->created_at)) }}</p>
			</div>
		</a>
	</div>
</div>