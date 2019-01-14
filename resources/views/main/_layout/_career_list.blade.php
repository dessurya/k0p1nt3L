<div class="list text-left">
	<div id="wrapper">
		<a href="{{ asset('asset/picture/career/'.$list->picture) }}" title="{{ title_case($list->name) }}">
			<div id="img" title="{{ title_case($list->name) }}" style="background-image: url('{{ asset('asset/picture/career/'.$list->picture) }}')"></div>
			<div id="desc">
				<h3>{{ title_case($list->name) }}</h3>
				<p>{{ date("d F y", strtotime($list->publish_at)) }}</p>
			</div>
		</a>
	</div>
</div>