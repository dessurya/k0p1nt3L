<div class="list text-left">
	<div id="wrapper">
		<div id="img" style="background-image: url('{{ asset('asset/picture/news-event/'.$list->picture) }}')"></div>
		<a href="{{ route('main.newsevent.view', ['slug'=>$list->slug]) }}" target="_blank">
			<div id="desc">
				<h3>{{ title_case($list->name) }}</h3>
				<p>{{ date("d F y", strtotime($list->publish_at)) }}</p>
			</div>
		</a>
	</div>
</div>