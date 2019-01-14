@extends('administrator.__layouts.basic')

@section('title')
	<title>Administrator Area - Profile</title>
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
					<h2>Account <small>report</small></h2>
                    <div class="clearfix"></div>
				</div>
				<div class="x_content">
					<div class="col-md-3 col-sm-3 col-xs-12 profile_left">
						<div class="profile_img">
	                        <div id="crop-avatar">
	                          <img class="img-responsive avatar-view" src="{{ Auth::guard('administrator')->user()->picture == null ? asset('asset/picture-default/users.png') : asset('asset/picture/administrator/'.Auth::guard('administrator')->user()->picture) }}" alt="Avatar" title="Change the avatar">
	                        </div>
						</div>
						<h3>{{ $me->name }}</h3>
						<ul class="list-unstyled user_data">
							<li>
								<i class="fa fa-at"></i> Email:
								<br>
								{{ $me->email }}
							</li>
							<li>
								<i class="fa fa-key"></i> Status:
								<br>
								{{ $me->confirmed == 'Y' ? 'Active' : 'Non Active' }}
							</li>
							<li>
								<i class="fa fa-check-square-o"></i> Login Count:
								<br>
								{{ $me->login_count }}
							</li>
							<li>
								<i class="fa fa-calendar"></i> Register On:
								<br>
								{{ $me->created_at }}
							</li>
						</ul>
					</div>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<div class="" role="tabpanel" data-example-id="togglable-tabs">
							<ul class="nav nav-tabs bar_tabs right" role="tablist">
								<li role="presentation" class="active">
									<a href="#tab_logs" id="logs-tabb" role="tab" data-toggle="tab" aria-controls="logs" aria-expanded="true">
										Activity
									</a>
		                        </li>
		                        <li role="presentation" class="">
		                        	<a href="#tab_form" role="tab" id="form-tabb" data-toggle="tab" aria-controls="form" aria-expanded="false">
		                        		Update Profile
		                        	</a>
		                        </li>
							</ul>
							<div class="tab-content">
								<div role="tabpanel" class="tab-pane fade active in" id="tab_logs" aria-labelledby="logs-tab">
									<div class="row">
										<div class="col-md-12 col-sm-12 col-xs-12">
											<div class="x_panel">
												<div class="x_title">
													<h3>Activity <small>Report</small></h3>
												</div>
												<div class="x_content">
													<div class="table-responsive">
														<table id="table-data" class="table table-striped table-bordered no-footer" width="100%">
															<thead>
																<tr role="row">
																	<th>On</th>
																	<th>Logs</th>
																</tr>
															</thead>
															<tfoot>
																<tr>
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
		                        </div>
		                        <div role="tabpanel" class="tab-pane fade" id="tab_form" aria-labelledby="form-tabb">
									<form id="profile_update" action="{{ route('adm.mid.account.me.update') }}" class="form-horizontal form-label-left">
										<div class="row">
											<div class="col-md-12 col-sm-12 col-xs-12">
												<div class="x_panel">
													<div class="x_title">
														<h3>Profile <small>Update</small></h3>
													</div>
													<div class="x_content">
														<div id="notif" class="alert alert-info alert-dismissible fade in" role="alert"></div>
														<div class="form-group">
															<label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">
																Name <span class="required">*</span>
																<p id="name" class="error"></p>
															</label>
															<div class="col-md-6 col-sm-6 col-xs-12">
																<input name="name" value="{{ $me->name }}" type="text" id="name" required class="form-control col-md-7 col-xs-12">
															</div>
														</div>
														<div class="form-group">
															<label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">
																Email <span class="required">*</span>
																<p id="email" class="error"></p>
															</label>
															<div class="col-md-6 col-sm-6 col-xs-12">
																<input name="email" value="{{ $me->email }}" type="email" id="email" required class="form-control col-md-7 col-xs-12">
															</div>
														</div>
														<div class="form-group">
															<label class="control-label col-md-3 col-sm-3 col-xs-12" for="password_old">
																Old Password <span class="required">*</span>
																<p id="password_old" class="error"></p>
															</label>
															<div class="col-md-6 col-sm-6 col-xs-12">
																<input name="password_old" type="password" id="password_old" required class="form-control col-md-7 col-xs-12">
															</div>
														</div>
														<div class="form-group">
															<label class="control-label col-md-3 col-sm-3 col-xs-12" for="password_new">
																New Password
																<p id="password_new" class="error"></p>
															</label>
															<div class="col-md-6 col-sm-6 col-xs-12">
																<input name="password_new" type="password" id="password_new" class="form-control col-md-7 col-xs-12">
															</div>
														</div>
														<div class="form-group">
															<label class="control-label col-md-3 col-sm-3 col-xs-12" for="password_confirm">
																Confirm Password
																<p id="password_confirm" class="error"></p>
															</label>
															<div class="col-md-6 col-sm-6 col-xs-12">
																<input name="password_confirm" type="password" id="password_confirm" class="form-control col-md-7 col-xs-12">
															</div>
														</div>
														<div class="form-group">
															<label class="control-label col-md-3 col-sm-3 col-xs-12" for="picture">
																Picture
																<p id="picture" class="error"></p>
															</label>
															<div class="col-md-6 col-sm-6 col-xs-12">
																<input name="picture" type="file" id="picture" class="form-control col-md-7 col-xs-12">
															</div>
														</div>
														<div class="ln_solid"></div>
														<div class="form-group">
															<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
																<button type="submit" class="btn btn-success">Submit</button>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</form>
		                        </div>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>

@endsection


@section('js')
	<script type="text/javascript">
		$(function(){
			$('form #notif, form p.error').hide();
			$(document).on('submit', 'form#profile_update', function(){
		        var url   = $(this).attr('action');
		        // var data  = $(this).serializeArray(); // digunakan jika hanya mengirim form tanpa file
		        var data  = new FormData($(this)[0]); // digunakan untuk mengirim form dengan file
		        

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
		            processData:false, // untuk menggunakan new FormData wajib menggunakan ini dengan value false
		            contentType:false, // untuk menggunakan new FormData wajib menggunakan ini dengan value false
		            beforeSend: function() {
		              $('form #notif').show().html('Please Wait...! Please Wait...! Please Wait...!');
		              $('form p.error').hide().html('');
		            },
		            success: function(data) {
		              $('form #notif').html(data.msg);
		              if (data.response == true) {
			            $('form p.error').hide().html('');
		                window.setTimeout(function() {
		                  $('form #notif').hide().html('');
		                }, 1500);
		                window.setTimeout(function() {
		                  location.reload();
		                }, 2000);
		              }
		              else{
		              	if (data.resault == null) {
		              		$('form p#password_old.error').show().html(data.old_pass);
		              	}
		              	else{
			                $.each(data.resault, function(key, val){
			                	$('form p#'+key+'.error').show().html(val);
			                });
		              	}
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
		var url = "{!! route('adm.mid.account.me.logs') !!}";

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
	          {data: 'created_at'},
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
