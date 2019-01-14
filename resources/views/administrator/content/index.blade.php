@extends('administrator.__layouts.basic')

@section('title')
	<title>Administrator Area - {{ title_case(str_replace('-', ' ', $index)) }}</title>
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
		table img{
			max-height: 120px;
			max-width: 120px;
		}
	</style>
	@if($index == 'portofolio-galeri')
	<link rel="stylesheet" type="text/css" href="{{ asset('vendors/dropzone/dist/dropzone.css') }}">
	<script src="{{ asset('vendors/dropzone/dist/dropzone.js') }}"></script>
	<script type="text/javascript">
		Dropzone.options.myDropzone = {
	      maxFilesize  : 6.5,
	      timeout: 5000,
	      // addRemoveLinks: true,
		  autoProcessQueue: true,
	      acceptedFiles: ".jpeg,.jpg,.png",
	      init: function(){
	      	var _this = this;
	      	$(document).on("click","a.open.btn.btn-success.btn-sm", function() {
				_this.removeAllFiles();
			});
	      },
	      error: function(file, response){
	        console.log(file);
	        console.log(response);
	        window.setTimeout(function() {
		        $(file.previewElement).remove();
		    }, 500);
	      },
	      success: function(file, response){
	        if (response.action == true) {
		        datatables.ajax.reload();
	        }
	        else{
	        	window.setTimeout(function() {
			        $(file.previewElement).remove();
			    }, 500);
	        }
	      }
	    };
	</script>
	@endif
	@if(in_array($index, array('news-event', 'portofolio')))
	<script src="{{asset('vendors/ckeditor/ckeditor.js')}}"></script>
	@endif
@endsection

@section('content')
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2>{{ title_case(str_replace('-', ' ', $index)) }} <small>list</small></h2>
					@include('administrator.content.__action_tools')
                    <div class="clearfix"></div>
				</div>
				<div class="x_content">
					@include('administrator.content.__datatables')
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade modal-aksi" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-md">
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
				@include('administrator.content._portofolio-galeri')
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

	@include('administrator.content.__script')
@endsection
