@extends('administrator.__layouts.basic')

@section('title')
	<title>Administrator Area - Account Logs</title>
@endsection

@section('css')
	<link href="{{ asset('vendors/datatables.net-bs/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
	<link href="{{ asset('vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css') }}" rel="stylesheet">
@endsection

@section('content')
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2>Account <small>report</small></h2>
					<div class="nav navbar-right panel_toolbox">
	                    <div class="btn-group">
			              <button type="button" class="btn btn-sm btn-success">
			                Administrator {{ $request->administrator != '' ? ' : '.$request->administrator : ' : All'}}
			              </button>
			              <button type="button" class="btn btn-sm btn-success dropdown-toggle" data-toggle="dropdown">
			                <span class="caret" style="color:white;"></span>
			              </button>
			              <ul class="dropdown-menu" role="menu">
			                <li>
			                  <a href="{{ route('adm.mid.account.logs', ['administrator'=>'']) }}">
			                    Show All
			                  </a>
			                </li>
			                @php $lastAuthor = 0 @endphp
			                @foreach($adm as $data)
			                @if($lastAuthor != $data->id)
			                <li>
			                  <a href="{{ route('adm.mid.account.logs', ['administrator'=>$data->email]) }}">
			                    {{ $data->name }}
			                  </a>
			                </li>
			                @endif
			                @php $lastAuthor = $data->id @endphp
			                @endforeach
			              </ul>
			            </div>
			            <div class="btn-group">
			              <a 
			                class="btn btn-success btn-sm"
			                href="{{ route('adm.mid.account.logs') }}" 
			              >
			                <i class="fa fa-refresh"></i> Clear Filter
			              </a>
			            </div>
			        </div>
                    <div class="clearfix"></div>
				</div>
				<div class="x_content">
					<h3>Activity Report</h3>
					<div class="table-responsive">
						<table id="table-data" class="table table-striped table-bordered no-footer" width="100%">
							<thead>
								<tr role="row">
									<th>On</th>
									<th>Account</th>
									<th>Logs</th>
								</tr>
							</thead>
							<tfoot>
								<tr>
									<td></td>
									<td></td>
									<td></td>
								</tr>
							</tfoot>
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
		var url = "{{ route('adm.mid.account.logs.list', ['administrator'=>$request->administrator]) }}";

		var datatables = $('#table-data').DataTable({
			dom: 'Bfrtip',
		    lengthMenu: [
		        [ 10, 25, 50 ],
		        [ '10 rows', '25 rows', '50 rows' ]
		    ],
		    buttons: {
		      buttons: [
		        'pageLength', 'copy', 'print'
		      ]
		    },
	        processing: true,
	        serverSide: true,
	        ajax: url,
	        columns: [
	          {data: 'created_at'},
	          {data: 'administrator_id'},
	          {data: 'logs'}
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
	</script>
@endsection
