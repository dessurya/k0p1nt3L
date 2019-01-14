<div class="modal-header">
	<button 
		type="button" 
		class="close" 
		data-dismiss="modal" 
		aria-label="Close"
	>
		<span aria-hidden="true">×</span>
	</button>
	<h4 class="modal-title">
		{{ title_case(str_replace('-', ' ', $index)) }} <small>Form Add</small>
	</h4>
</div>
<div class="modal-body">
	<form 
		action="{{ route('adm.mid.content.form.store', ['index'=>$index]) }}"
		method="post" 
		enctype="multipart/form-data" 
		class="dropzone" 
		id="my-dropzone"
	>
		{{ csrf_field() }}
	</form>
</div>