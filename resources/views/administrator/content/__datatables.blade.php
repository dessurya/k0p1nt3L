<div class="table-responsive">
	<table id="table-data" class="table table-striped table-bordered no-footer" width="100%">
		<thead>
			<tr role="row">
				@if(in_array($index, array('banner', 'career', 'certificate', 'management', 'news-event', 'partner', 'portofolio')))
					<th>Created At</th>
					<th>Publish At</th>
					<th>Created By</th>
					<th>Status</th>
					<th>Data</th>
					<th>Action</th>
				@elseif(in_array($index, array('portofolio-galeri')))
					<th>Created At</th>
					<th>Created By</th>
					<th>Portofolio</th>
					<th>Picture</th>
					<th>Action</th>
				@endif
			</tr>
		</thead>
		<tfoot>
			<tr>
				@if(in_array($index, array('banner', 'career', 'certificate', 'management', 'news-event', 'partner', 'portofolio')))
					<td></td> <td></td> <td></td> <td></td> <td></td> <td></td>
				@elseif(in_array($index, array('portofolio-galeri')))
					<td></td> <td></td> <td></td> <td></td> <td></td>
				@endif
			</tr>
		</tfoot>
	</table>
</div>