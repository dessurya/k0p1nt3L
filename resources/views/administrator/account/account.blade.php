@extends('administrator.__layouts.basic')

@section('title')
	<title>Administrator Area - Account</title>
@endsection

@section('css')
	<link href="{{ asset('vendors/datatables.net-bs/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
	<link href="{{ asset('vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css') }}" rel="stylesheet">
	<style type="text/css">
		form p.error{
			color: red;
			margin: 0;
		}
	</style>
@endsection

@section('content')
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2>Account <small>List</small></h2>
					<div class="nav navbar-right panel_toolbox">
			            <div class="btn-group">
			              <a 
			              	data-toggle='modal' 
			              	data-target='.modal-add'
			                class="btn btn-success btn-sm"
			                href="#" 
			              >
			                <i class="fa fa-plus"></i> Add Account
			              </a>
			            </div>
			        </div>
                    <div class="clearfix"></div>
				</div>
				<div class="x_content">
					<div class="table-responsive">
						<table id="table-data" class="table table-striped table-bordered no-footer" width="100%">
							<thead>
								<tr role="row">
									<th>Status</th>
									<th>Name</th>
									<th>Email</th>
									<th>Register On</th>
									<th>Last Login</th>
									<th>Login Count</th>
									<th>Action</th>
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
									<td></td>
								</tr>
							</tfoot>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade modal-aksi" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-header">
					<button 
						type="button" 
						class="close" 
						data-dismiss="modal" 
						aria-label="Close"
					>
						<span aria-hidden="true">×</span>
					</button>
					<h4 id="title-aksi" class="modal-title"></h4>
				</div>
				<div id="text-aksi" class="modal-body">
				</div>
				<div class="modal-footer">
					<div id="action_respone" class="alert alert-info alert-dismissible fade in" role="alert"></div>
					<a class="btn btn-primary" id="aksi-url">Yes</a>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade modal-add" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button 
						type="button" 
						class="close" 
						data-dismiss="modal" 
						aria-label="Close"
					>
						<span aria-hidden="true">×</span>
					</button>
					<h4 class="modal-title">New Administrator <small>Account</small></h4>
				</div>
				<div class="modal-body">
					<form id="add" action="{{ route('adm.mid.account.add') }}" class="form-horizontal form-label-left">
						<div id="add_respone" class="alert alert-info alert-dismissible fade in" role="alert"></div>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">
								Name <span class="required">*</span>
								<p id="name" class="error"></p>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input name="name" type="text" id="name" required class="form-control col-md-7 col-xs-12">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">
								Email <span class="required">*</span>
								<p id="email" class="error"></p>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input name="email" type="email" id="email" required class="form-control col-md-7 col-xs-12">
							</div>
						</div>
						<div class="ln_solid"></div>
						<div class="form-group">
							<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
								<button type="submit" class="btn btn-success">Submit</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>


@endsection


@section('js')
	<script type="text/javascript">
		$(function(){
			$('form #add_respone, form p.error').hide();
			$(document).on('submit', 'form#add', function(){
		        var url   = $(this).attr('action');
		        var data  = $(this).serializeArray(); // digunakan jika hanya mengirim form tanpa file
		        // var data  = new FormData($(this).get(0)); // digunakan untuk mengirim form dengan file
		        
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
		              $('form #add_respone').show().html('Please Wait...! Please Wait...! Please Wait...!');
		              $('form p.error').hide().html('');
		            },
		            success: function(data) {
		              $('form #add_respone').html(data.msg);
		              if (data.response == true) {
			            $('form p.error').hide().html('');
		                window.setTimeout(function() {
		                  datatables.ajax.reload();
		                  $('form #add_respone').hide().html('');
		                  $('div.modal.modal-add').modal('hide');
		                }, 1750);
		              }
		              else{
		                $.each(data.resault, function(key, val){
		                	$('form p#'+key+'.error').show().html(val);
		                });
		              }
		            }
		        })
		        return false;
			});

	    });	
	</script>

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
		var url = "{{ route('adm.mid.account.list.data') }}";

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
	          {data: 'confirmed'},
	          {data: 'name'},
	          {data: 'email'},
	          {data: 'created_at'},
	          {data: 'updated_at'},
	          {data: 'login_count'},
	          {data: 'action', orderable: false, searchable: false}
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

	<script type="text/javascript">
		$('#action_respone').hide();

		$('#table-data').on('click', 'a.delete', function(){
			var a = $(this).data('href');
			$('#aksi-url').attr('href', a);
			$('#title-aksi').html("Administrator Account Delete");
			$('#text-aksi').html("<h5>Are You Sure? To Delete This Account?</h5>");
		});
		$('#table-data').on('click', 'a.deactivate', function(){
			var a = $(this).data('href');
			$('#aksi-url').attr('href', a);
			$('#title-aksi').html("Administrator Account Deactivate");
			$('#text-aksi').html("<h5>Are You Sure? To Deactivate This Account?</h5>");
		});
		$('#table-data').on('click', 'a.activate', function(){
			var a = $(this).data('href');
			$('#aksi-url').attr('href', a);
			$('#title-aksi').html("Administrator Account Activate");
			$('#text-aksi').html("<h5>Are You Sure? To Activate This Account?</h5>");
		});

		$('div.modal-aksi').on('click', 'a#aksi-url', function(){
	        var url   = $(this).attr('href');
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
	              $('#action_respone').show().html('Please Wait...! Please Wait...!');
	            },
	            success: function(data) {
	              $('#action_respone').html(data.msg);
	              window.setTimeout(function() {
	                datatables.ajax.reload();
	                $('#action_respone').hide().html('');
	                $('div.modal.modal-aksi').modal('hide');
	              }, 1750);
	            }
	        });
	        return false;
		});
	</script>
@endsection
