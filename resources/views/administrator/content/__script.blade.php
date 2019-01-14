<script type="text/javascript">
	// call datatables
		var url = '{!! route('adm.mid.content.data', ['index'=>$index, 'administrator'=>$request->administrator, 'status'=>$request->status, 'portofolio'=>$request->portofolio]) !!}';

		var datatables = $('#table-data').DataTable({
			dom: 'Bfrtip',
		    lengthMenu: [
		        [ 10, 25, 50, 100, 250 ],
		        [ '10 rows', '25 rows', '50 rows', '100 rows', '250 rows' ]
		    ],
		    buttons: {
		      buttons: [
		        'pageLength'//, 'copy', 'print'
		      ]
		    },
	        processing: true,
	        serverSide: true,
	        ajax: url,
	        aaSorting: [ [0,'desc'] ],
	        columns: [
	        @if(in_array($index, array('banner', 'career', 'certificate', 'management', 'news-event', 'partner', 'portofolio')))
	          {data: 'created_at'},
	          {data: 'publish_at'},
	          {data: 'administrator_id'},
	          {data: 'flag'},
	          {data: 'data'},
	          {data: 'action', orderable: false, searchable: false}
	        @elseif(in_array($index, array('portofolio-galeri')))
	          {data: 'created_at'},
	          {data: 'administrator_id'},
	          {data: 'portofolio_id'},
	          {data: 'picture'},
	          {data: 'action', orderable: false, searchable: false}
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
	// call datatables

	// open form and store
		$(function(){
			// call form
				@if($index != 'portofolio-galeri')
				$(document).on('click', '.open.btn, ul li a.open', function(){
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
			              $('div.modal-add div.modal-content').html(data.html);
			              window.setTimeout(function() {
			              	@if(in_array($index, array('news-event', 'portofolio')))
				                CKEDITOR.replace('content_id');
				                CKEDITOR.replace('content_en');
				                @if(in_array($index, array('portofolio')))
				                CKEDITOR.replace('project_id');
				                CKEDITOR.replace('project_en');
				                @endif
			                @endif
			              }, 250);
			            }
			        })
			        return false;
				});
				@endif
			// call form

			// store form
				$(document).on('submit', 'form#add', function(){
			        var url   = $(this).attr('action');
			        // var data  = $(this).serializeArray(); // digunakan jika hanya mengirim form tanpa file
			        var data  = new FormData($(this)[0]); // digunakan untuk mengirim form dengan file
			        // console.log(data);
			        
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
			              $('form .add_respone').show().html('Please Wait...! Please Wait...! Please Wait...!');
			              $('form p.error').hide().html('');
			            },
			            success: function(data) {
			              $('form .add_respone').html(data.msg);
			              if (data.response == true) {
				            $('form p.error').hide().html('');
			                datatables.ajax.reload();
			                window.setTimeout(function() {
			                  $('form .add_respone').hide().html('');
			                  $('div.modal.modal-add').modal('hide');
			                }, 1750);
			              }
			              else{
			                $.each(data.resault, function(key, val){
			                	$('form p.'+key+'.error').show().html(val);
			                });
			              }
			            }
			        })
			        return false;
				});
			// store form
	    });	
	// open form and store

	// action respons
		$('#action_respone').hide();

		$('#table-data').on('click', 'a.delete', function(){
			var a = $(this).data('href');
			$('#aksi-url').attr('href', a);
			$('#title-aksi').html("{{ title_case(str_replace('-', ' ', $index)) }} Delete");
			$('#text-aksi').html("<h5>Are You Sure? To Delete This {{ title_case(str_replace('-', ' ', $index)) }}?</h5>");
		});
		$('#table-data').on('click', 'a.deactivate', function(){
			var a = $(this).data('href');
			$('#aksi-url').attr('href', a);
			$('#title-aksi').html("{{ title_case(str_replace('-', ' ', $index)) }} Deactivate");
			$('#text-aksi').html("<h5>Are You Sure? To Deactivate This {{ title_case(str_replace('-', ' ', $index)) }}?</h5>");
		});
		$('#table-data').on('click', 'a.activate', function(){
			var a = $(this).data('href');
			$('#aksi-url').attr('href', a);
			$('#title-aksi').html("{{ title_case(str_replace('-', ' ', $index)) }} Activate");
			$('#text-aksi').html("<h5>Are You Sure? To Activate This {{ title_case(str_replace('-', ' ', $index)) }}?</h5>");
		});

		$('div.modal-aksi').on('click', 'a#aksi-url', function(){
	        var url   = $(this).attr('href');

	        @if ($index == 'portofolio-galeri') 
	        	url = url+'&portofolio='+$('select[name=portofolio]').val();
	        @endif

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
	              datatables.ajax.reload();
	              window.setTimeout(function() {
	                $('#action_respone').hide().html('');
	                $('div.modal.modal-aksi').modal('hide');
	              }, 1750);
	            }
	        });
	        return false;
		});
	// action respons

	// check row
		$('#table-data').on('click', 'button.choice', function(){
			$(this).toggleClass('btn-success');
			if ($(this).hasClass('btn-success')) {
				$(this).children().removeClass('fa-square-o').addClass('fa-check-square-o');
			}
			else{
				$(this).children().removeClass('fa-check-square-o').addClass('fa-square-o');
			}
		});
	// check row

	// excute check row
		$(document).on('click', 'a.tools', function(){
			if ($(this).hasClass('select-all')) {
				$('#table-data button.choice').addClass('btn-success').children().removeClass('fa-square-o').addClass('fa-check-square-o');
			}
			else if($(this).hasClass('unselect-all')) {
				$('#table-data button.choice').removeClass('btn-success').children().removeClass('fa-check-square-o').addClass('fa-square-o');
			}
			else if($(this).hasClass('action')) {
				var a = $(this).data('href');
				var b = '';
				$('#table-data button.choice.btn-success').each(function(){
					b += $(this).data('id')+'^';
				});
				if (b == '') {
					$('#aksi-url').attr('href', '#').hide();
					$('#title-aksi').html("<strong>Sorry!</strong> Please Select...!");
					$('#text-aksi').html("<strong>Sorry!</strong> Please Select...!<strong> Sorry!</strong> Please Select...!");
				}
				else{
					$('#aksi-url').attr('href', a+'&id='+b).show();
					if ($(this).hasClass('activate')) {
						$('#title-aksi').html("{{ title_case(str_replace('-', ' ', $index)) }} Activate");
						$('#text-aksi').html("<h5>Are You Sure? To Activate This {{ title_case(str_replace('-', ' ', $index)) }}?</h5>");
					}
					else if ($(this).hasClass('deactivate')) {
						$('#title-aksi').html("{{ title_case(str_replace('-', ' ', $index)) }} Deactivate");
						$('#text-aksi').html("<h5>Are You Sure? To Deactivate This {{ title_case(str_replace('-', ' ', $index)) }}?</h5>");
					}
					else if ($(this).hasClass('delete')) {
						$('#title-aksi').html("{{ title_case(str_replace('-', ' ', $index)) }} Delete");
						$('#text-aksi').html("<h5>Are You Sure? To Delete This {{ title_case(str_replace('-', ' ', $index)) }}?</h5>");
					}
					else if ($(this).hasClass('portofolio')) {
						$('#title-aksi').html("Set Portofolio");
						var url   = '{{ route("adm.mid.content.form", ["index"=>"change-portofolio"]) }}';
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
				              // $('#action_respone').show().html('Please Wait...! Please Wait...!');
				            },
				            success: function(data) {
							  $('#text-aksi').html(data.html);
				            }
				        });
					}
				}
				return false;
			}
		});
	// excute check row
</script>