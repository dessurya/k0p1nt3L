@extends('administrator.__layouts.basic')

@section('title')
	<title>Administrator Area - Inbox</title>
@endsection

@section('css')
	<link href="{{ asset('vendors/datatables.net-bs/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
	<link href="{{ asset('vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css') }}" rel="stylesheet">
	<style type="text/css">
		.content{
			margin: 0px auto;
			padding: 10px;
			max-width: 300px;
			max-height: 180px;
			overflow-y: auto;
		}
	</style>
@endsection

@section('content')
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2>Inbox <small>{{$index}}</small></h2>
                    <div class="clearfix"></div>
				</div>
				<div class="x_content">
					<div class="table-responsive">
						<table id="table-data" class="table table-striped table-bordered no-footer" width="100%">
							@if($index == 'list')
							<thead>
								<tr role="row">
									<th>On</th>
									<th>Name</th>
									<th>Phone</th>
									<th>Email</th>
									<th>Subject</th>
									<th>Message</th>
								</tr>
							</thead>
							<tfoot>
								<tr>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
							</tfoot>
							@else
							<thead>
								<tr role="row">
									<th>Name</th>
									<th>Email</th>
									<th>Status</th>
									<th>Send</th>
								</tr>
							</thead>
							<tfoot>
								<tr>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
							</tfoot>
							@endif
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection


@section('js')
	<script src="{{ asset('vendors/datatables.net/js/jquery.dataTables.min.js') }}"></script>
	<script src="{{ asset('vendors/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
	<script src="{{ asset('vendors/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
	<script src="{{ asset('vendors/datatables.net-scroller/js/datatables.scroller.min.js') }}"></script>

	<script src="{{ asset('vendors/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js') }}"></script>

    <script src="{{ asset('vendors/datatables.net-buttons/js/buttons.flash.min.js') }}"></script>
    <script src="{{ asset('vendors/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('vendors/datatables.net-buttons/js/buttons.print.min.js') }}"></script>

	<script type="text/javascript">
		var url = "{!! route('adm.mid.inbox.data', ['index'=>$index]) !!}";

		var datatables = $('#table-data').DataTable({
			dom: 'Bfrtip',
		    lengthMenu: [
		        [ 10, 25, 50, 100, 250 ],
		        [ '10 rows', '25 rows', '50 rows', '100 rows', '250 rows' ]
		    ],
		    buttons: {
		      buttons: [
		        'pageLength', 'copy', 'print'
		      ]
		    },
	        processing: true,
	        serverSide: true,
	        ajax: url,
		    aaSorting: [ [0,'desc'] ],
	        columns: [
	          @if($index == 'list')
	          {data: 'created_at'},
	          {data: 'name'},
	          {data: 'handphone'},
	          {data: 'email'},
	          {data: 'subject'},
	          {data: 'message'}
	          @else
	          {data: 'name'},
	          {data: 'email'},
	          {data: 'confirmed'},
	          {data: 'send'}
	          @endif
	        ],
	        initComplete: function () {
	            this.api().columns().every(function () {
	                var column = this;
	                var input = document.createElement("input");
	                $(input).appendTo($(column.footer()).empty())
	                .on('change', function () {
	                    var val = $.fn.dataTable.util.escapeRegex($(this).val());

	                    column.search(val ? val : '', true, false).draw();
	                });
	            });
	        }
		});

		$('#table-data').on('click', 'button.btn.choice', function(){
	        var confirmed   = $(this).data('confirmed');
	        if (confirmed == 'N') {
		        return false;
	        }
	        var url   = $(this).data('href');
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
	            },
	            success: function(data) {
	              datatables.ajax.reload();
	            }
	        });
	        return false;
		});
	</script>
@endsection
