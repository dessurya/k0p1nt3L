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
		{{ title_case(str_replace('-', ' ', $index)) }} <small>Form{{ $data != null ? ' Update '.title_case($data->name) : ' Add' }}</small>
	</h4>
</div>
<div class="modal-body">
	<form id="add" action="{{ route('adm.mid.content.form.store', ['index'=>$index]) }}{{ $data != null ? '?id='.$data->id : '' }}" class="form-horizontal form-label-left">
		<div class="add_respone alert alert-info alert-dismissible fade in" role="alert" style="display: none;"></div>
		<div class="form-group">
			<label class="control-label col-md-3 col-sm-3 col-xs-12" for="name_id">
				Name Id <span class="required">*</span>
				<p class="name_id error"></p>
			</label>
			<div class="col-md-9 col-sm-9 col-xs-12">
				<input 
					name="name_id" 
					type="text" 
					id="name_id" 
					class="form-control col-md-7 col-xs-12"
					value="{{ $data != null ? $data->name_id : '' }}"
				>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-md-3 col-sm-3 col-xs-12" for="name_en">
				Name En <span class="required">*</span>
				<p class="name_en error"></p>
			</label>
			<div class="col-md-9 col-sm-9 col-xs-12">
				<input 
					name="name_en" 
					type="text" 
					id="name_en" 
					class="form-control col-md-7 col-xs-12"
					value="{{ $data != null ? $data->name_en : '' }}"
				>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-md-3 col-sm-3 col-xs-12" for="content_id">
				Content Id <span class="required">*</span>
				<p class="content_id error"></p>
			</label>
			<div class="col-md-9 col-sm-9 col-xs-12">
				<textarea 
					name="content_id" 
					type="text" 
					id="content_id" 
					class="form-control col-md-7 col-xs-12"
				>{{ $data != null ? $data->content_id : '' }}</textarea>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-md-3 col-sm-3 col-xs-12" for="content_en">
				Content En <span class="required">*</span>
				<p class="content_en error"></p>
			</label>
			<div class="col-md-9 col-sm-9 col-xs-12">
				<textarea 
					name="content_en" 
					type="text" 
					id="content_en" 
					class="form-control col-md-7 col-xs-12"
				>{{ $data != null ? $data->content_en : '' }}</textarea>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-md-3 col-sm-3 col-xs-12" for="project_id">
				Ruang Lingkup Project Id <span class="required">*</span>
				<p class="project_id error"></p>
			</label>
			<div class="col-md-9 col-sm-9 col-xs-12">
				<textarea 
					name="project_id" 
					type="text" 
					id="project_id" 
					class="form-control col-md-7 col-xs-12"
				>{{ $data != null ? $data->project_id : '' }}</textarea>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-md-3 col-sm-3 col-xs-12" for="project_en">
				Ruang Lingkup Project En <span class="required">*</span>
				<p class="project_en error"></p>
			</label>
			<div class="col-md-9 col-sm-9 col-xs-12">
				<textarea 
					name="project_en" 
					type="text" 
					id="project_en" 
					class="form-control col-md-7 col-xs-12"
				>{{ $data != null ? $data->project_en : '' }}</textarea>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-md-3 col-sm-3 col-xs-12" for="picture_first">
				picture_first <span class="required">*</span>
				<p class="picture_first error"></p>
			</label>
			<div class="col-md-9 col-sm-9 col-xs-12">
				<input name="picture_first" type="file" id="picture_first" class="form-control col-md-7 col-xs-12">
			</div>
		</div>
		@if($data != null and $data->picture_first)
			<div class="text-center" style="margin: 20px auto;">
				<a href="{{ asset('asset/picture/'.$index.'/'.$data->picture_first) }}" target="_blank">
					<img src="{{ asset('asset/picture/'.$index.'/'.$data->picture_first) }}" style="max-width: 280px; max-height: 160px;">
				</a>
			</div>
		@endif
		<div class="form-group">
			<label class="control-label col-md-3 col-sm-3 col-xs-12" for="picture_second">
				picture_second <span class="required">*</span>
				<p class="picture_second error"></p>
			</label>
			<div class="col-md-9 col-sm-9 col-xs-12">
				<input name="picture_second" type="file" id="picture_second" class="form-control col-md-7 col-xs-12">
			</div>
		</div>
		@if($data != null and $data->picture_second)
			<div class="text-center" style="margin: 20px auto;">
				<a href="{{ asset('asset/picture/'.$index.'/'.$data->picture_second) }}" target="_blank">
					<img src="{{ asset('asset/picture/'.$index.'/'.$data->picture_second) }}" style="max-width: 280px; max-height: 160px;">
				</a>
			</div>
		@endif
		<div class="ln_solid"></div>
		<div class="form-group">
			<div class="add_respone alert alert-info alert-dismissible fade in" role="alert" style="display: none;"></div>
			<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
				<button type="submit" class="btn btn-success">Submit</button>
			</div>
		</div>
	</form>
</div>