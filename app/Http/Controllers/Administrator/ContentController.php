<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Administrator;
use App\Models\Portofolio;

use App;
use Auth;
use DataTables;
use DB;
use Validator;
use Image;
use File;

use UserLogHelper;
use ContentWebHelper;

use Carbon\Carbon;

class ContentController extends Controller
{
	public function __construct(){
		$this->indexList = array('banner', 'career', 'certificate', 'management', 'news-event', 'partner', 'portofolio', 'portofolio-galeri');
		$this->baseModals = "App\Models\\";
	}

	public function index($index, request $request){
		if(!in_array($index, $this->indexList)){
			return redirect()->route('adm.mid.dashboard');
		}

		$adm = Administrator::orderBy('name', 'asc')->get();
		if ($request->administrator) {
			$getFilterAdministrator = Administrator::where('email',$request->administrator)->first();
			if (!$getFilterAdministrator) {
	    		return redirect()->route('adm.mid.content', ['index'=>$index])
					->with('notif', 'Sorry! Something Wrong!');
			}
		}

		$listPG = null;
		if ($index == 'portofolio-galeri') {
			$listPG = Portofolio::get();
			if ($request->portofolio) {
				if ($request->portofolio != 'unknown') {
					$getFilterPortofolio = Portofolio::where('slug',$request->portofolio)->first();
					if (!$getFilterPortofolio) {
			    		return redirect()->route('adm.mid.content', ['index'=>$index])
							->with('notif', 'Sorry! Something Wrong!');
					}
				}
			}
		}

		return view('administrator.content.index', compact('index', 'request', 'adm', 'listPG'));
	}

	public function data($index, request $request){
		if(!in_array($index, $this->indexList)){
			return false;
		}

		$Model = $this->baseModals.studly_case($index);
		$data = $Model::select('*');

		if ($request->administrator != null and isset($request->administrator)) {
			$getFilterAdministrator = Administrator::where('email',$request->administrator)->first();
    		$data = $data->where('administrator_id', $getFilterAdministrator->id);
		}
		if ($request->status != null and isset($request->status)){
			if ($request->status == 'active') {
	    		$data = $data->where('flag', 'Y');
			}
			else if ($request->status == 'deactive') {
	    		$data = $data->where('flag', 'N');
			}
		}
		if ($request->portofolio != null and isset($request->portofolio)){
			if ($request->portofolio == 'unknown') {
				$data = $data->whereNull('portofolio_id');
			}
			else{
				$getFilterPortofolio = Portofolio::where('slug',$request->portofolio)->first();
				$data = $data->where('portofolio_id', $getFilterPortofolio->id);
			}
		}
		$data = $data->orderBy('created_at', 'desc')->get();

		if(in_array($index, array('banner', 'career', 'certificate', 'management', 'news-event', 'partner', 'portofolio'))){
			return $Datatables = Datatables::of($data)
				->addColumn('data', function($data) use ($index){
					$html = '';
					if (in_array($index, array('banner', 'management', 'partner'))) {
						$html .= title_case($data->name);
						if ($index == 'management') {
							$html .= ' <br>Position Id : '.title_case($data->position_id);
							$html .= ' <br>Position En : '.title_case($data->position_en);
						}
					}
					else if(in_array($index, array('career', 'certificate', 'news-event', 'portofolio'))) {
						$html .= 'Id : '.title_case($data->name_id).'<br>';
						$html .= 'En : '.title_case($data->name_en).'<br>';
					}

					if (in_array($index, array('banner', 'career', 'certificate', 'management', 'news-event', 'partner'))) {
						if ($data->picture != null) {
							$html .= ' <br><a href="'.asset('asset/picture/'.$index.'/'.$data->picture).'" target="_blank"><img src="'.asset('asset/picture/'.$index.'/'.$data->picture).'"></a>';
						}
					}
					else if (in_array($index, array('portofolio'))) {
						if ($data->picture_first != null) {
							$html .= ' <br><a href="'.asset('asset/picture/'.$index.'/'.$data->picture_first).'" target="_blank"><img src="'.asset('asset/picture/'.$index.'/'.$data->picture_first).'"></a>';
						}
						if ($data->picture_second != null) {
							$html .= ' <br><a href="'.asset('asset/picture/'.$index.'/'.$data->picture_second).'" target="_blank"><img src="'.asset('asset/picture/'.$index.'/'.$data->picture_second).'"></a>';
						}
					}

					return $html;})
				->editColumn('publish_at', function($data){
					$html = '';
					if($data->publish_at == null){
		    			$html .= '-';
		    		}
		    		else{
						$html .= $data->publish_at;
					}
					return $html;})
				->editColumn('administrator_id', function($data){
					$html = '';
					if($data->getAdministrator == null){
		    			$html .= 'User Tidak Terdeteksi';
		    		}
		    		else{
						$html .= $data->getAdministrator->name.' <br>'.$data->getAdministrator->email;
					}
					return $html;})
				->editColumn('flag', function($data){
					$html = $data->flag == 'Y' ? 'Active' : 'Deactive' ;
					return $html;})
				->addColumn('action', function ($data) use ($index){
					$html = '';
					$html .= "<div><div class='btn-group'>";
					$html .= "<button type='button' class='btn btn-sm choice' data-id='".$data->id."'><i class='fa fa-square-o'></i></button>";
					$html .= "<button type='button' class='btn btn-sm btn-success'>";
					$html .= "<i class='fa fa-gears'></i> Tools";
					$html .= "</button>";
					$html .= "<button type='button' class='btn btn-sm btn-success dropdown-toggle' data-toggle='dropdown'>";
					$html .= "<span class='caret' style='color:white;'></span>";
					$html .= "</button>";
					$html .= "<ul class='dropdown-menu' role='menu'>";
					$html .= "<li><a class='open' data-href='".route('adm.mid.content.form', ['index'=>$index, 'id'=>$data->id])."' data-toggle='modal' data-target='.modal-add'><i class='fa fa-folder-open-o'></i> Open</a></li>";
					if ($index == 'portofolio') {
						$html .= "<li><a href='".route('adm.mid.content', ['index'=>'portofolio-galeri', 'portofolio'=>$data->slug])."'><i class='fa fa-search'></i> Detail</a></li>";
					}
					if($data->flag == 'Y'){
						$html .= "<li><a class='deactivate' data-href='".route('adm.mid.content.action', ['index'=>$index, 'action'=>'deactivate', 'id'=>$data->id])."' data-toggle='modal' data-target='.modal-aksi'><i class='fa fa-ban'></i> Deactivate</a></li>";
					}
					else{
						$html .= "<li><a class='activate' data-href='".route('adm.mid.content.action', ['index'=>$index, 'action'=>'activate', 'id'=>$data->id])."' data-toggle='modal' data-target='.modal-aksi'><i class='fa fa-check'></i> Activate</a></li>";
					}
					$html .= "<li><a class='delete' data-href='".route('adm.mid.content.action', ['index'=>$index, 'action'=>'delete', 'id'=>$data->id])."' data-toggle='modal' data-target='.modal-aksi'><i class='fa fa-trash-o'></i> Delete</a></li>";
					$html .= "</ul>";
					$html .= "</div></div>";

		    		return $html;})
				->escapeColumns(['*'])->make();
		}
		else if(in_array($index, array('portofolio-galeri'))){
			return $Datatables = Datatables::of($data)
				->editColumn('picture', function($data) use ($index){
					$html = '<a href="'.asset('asset/picture/'.$index.'/'.$data->picture).'" target="_blank"><img src="'.asset('asset/picture/'.$index.'/'.$data->picture).'"></a>';
					return $html;})
				->editColumn('administrator_id', function($data){
					$html = '';
					if($data->getAdministrator == null){
		    			$html .= 'User Tidak Terdeteksi';
		    		}
		    		else{
						$html .= $data->getAdministrator->name.' <br>'.$data->getAdministrator->email;
					}
					return $html;})
				->editColumn('portofolio_id', function($data){
					$html = '';
					if($data->getPortofolio == null){
		    			$html .= '-';
		    		}
		    		else{
						$html .= $data->getPortofolio->name_id.' | '.$data->getPortofolio->name_en;
					}
					return $html;})
				->addColumn('action', function ($data) use ($index){
					$html = '';
					$html .= "<div><div class='btn-group'>";
					$html .= "<button type='button' class='btn btn-sm choice' data-id='".$data->id."'><i class='fa fa-square-o'></i></button>";
					$html .= "<button type='button' class='btn btn-sm btn-success'>";
					$html .= "<i class='fa fa-gears'></i> Tools";
					$html .= "</button>";
					$html .= "<button type='button' class='btn btn-sm btn-success dropdown-toggle' data-toggle='dropdown'>";
					$html .= "<span class='caret' style='color:white;'></span>";
					$html .= "</button>";
					$html .= "<ul class='dropdown-menu' role='menu'>";
					$html .= "<li><a class='delete' data-href='".route('adm.mid.content.action', ['index'=>$index, 'action'=>'delete', 'id'=>$data->id])."' data-toggle='modal' data-target='.modal-aksi'><i class='fa fa-trash-o'></i> Delete</a></li>";
					$html .= "</ul>";
					$html .= "</div></div>";

		    		return $html;})
				->escapeColumns(['*'])->make();
		}
	}

	public function openForm($index, request $request){
		if ($index == 'change-portofolio') {
			$Portofolio = Portofolio::get();
			$view = '<div class="form-horizontal form-label-left">';
			$view .= '<div class="form-group">';
			$view .= '<label class="control-label col-md-3 col-sm-3 col-xs-12" for="portofolio">';
			$view .= 'Portofolio';
			$view .= '</label>';
			$view .= '<div class="col-md-6 col-sm-6 col-xs-12">';
			$view .= '<select name="portofolio" class="form-control col-md-7 col-xs-12">';
			$view .= '<option value="0">Unknown</option>';
			foreach ($Portofolio as $key) {
				$view .= '<option value="'.$key->id.'">'.$key->name_id.'</option>';
			}
			$view .= '</select>';
			$view .= '</div></div></div>';
		}
		else{
			$data = null;

			if (isset($request->id)) {
				$Model = $this->baseModals.studly_case($index);
				$data = $Model::find($request->id);
				if (!$data) {
					return response()->json([
						'response'=>false,
						'html'=>'Sorry! Something Wrong!'
					]);
				}
			}

			$view = view('administrator.content._'.$index, compact('index','data'))->render();
		}
		return response()->json(['response'=>true,'html'=>$view]);
	}

	public function openFormStore($index, request $request){

		$cek = ContentWebHelper::store($index, $request);

		if($cek['response'] == false){
			return response()->json([
				'response'=>false,
	         	'resault'=>$cek['resault'],
	         	'msg'=>'Sorry! Something Wrong...!'
			]);
		}

		$hasil = DB::transaction(function() use($index, $request){
			$Model = $this->baseModals.studly_case($index);
			$text = '';
			if ($request->id) {
				$save = $Model::find($request->id);
				if (!$save) {
					return response()->json([
						'response'=>false,
			         	'resault'=>null,
			         	'msg'=>'Sorry! Something Wrong...!'
		         	]);
				}
				$action = 'Update';
				if (in_array($index, array('banner', 'management', 'partner'))) {
					$text .= title_case($save->name).' to ';
				}
				else if(in_array($index, array('certificate', 'news-event', 'portofolio'))) {
					$text .= title_case($save->name_id).' - '.title_case($save->name_en).' to ';
				}
			}
			else{
				$save = new $Model;
				$action = 'Add';
			}

			$columns=$save->getTableColumns(); // memanggil semua column/field pada table


			if ($request->name and in_array('name', $columns)) {
				$save->name = $request->name;
				if (in_array('slug', $columns)) {
					$save->slug = str_slug($request->name);
				}
			}

			if ($request->name_id and in_array('name_id', $columns)) {
				$save->name_id = $request->name_id;
				if (in_array('slug', $columns)) {
					$save->slug = str_slug($request->name_id);
				}
			}

			if ($request->name_en and in_array('name_en', $columns)) {
				$save->name_en = $request->name_en;
			}

			if ($request->position_id and in_array('position_id', $columns)) {
				$save->position_id = $request->position_id;
			}

			if ($request->position_en and in_array('position_en', $columns)) {
				$save->position_en = $request->position_en;
			}

			if ($request->content_id and in_array('content_id', $columns)) {
				$save->content_id = $request->content_id;
			}

			if ($request->content_en and in_array('content_en', $columns)) {
				$save->content_en = $request->content_en;
			}

			if ($request->project_id and in_array('project_id', $columns)) {
				$save->project_id = $request->project_id;
			}

			if ($request->project_en and in_array('project_en', $columns)) {
				$save->project_en = $request->project_en;
			}

			if($request->file('picture') and in_array('picture', $columns)){
				
				$directory = 'asset/picture/'.$index;
				if ($save->picture != null) {
					File::delete($directory.'/'.$save->picture);
				}
				$salt = str_random(4);
				$image = $request->file('picture');

				if (in_array($index, array('banner', 'management', 'partner'))) {
					$nmp = str_slug($request->name,'-');
				}
				else if(in_array($index, array('career', 'certificate', 'news-event'))) {
					$nmp = str_slug($request->name_id,'-');
				}

				$img_url = $nmp.'-'.$salt. '.' . $image->getClientOriginalExtension();

				$upload1 = Image::make($image)->encode('data-url');
				$upload1->save($directory.'/'.$img_url);
				$save->picture = $img_url;
			}

			if($request->file('picture_first') and in_array('picture_first', $columns)){
				
				$directory = 'asset/picture/'.$index;
				if ($save->picture_first != null) {
					File::delete($directory.'/'.$save->picture_first);
				}
				$salt = str_random(4);
				$image = $request->file('picture_first');

				$nmp = str_slug($request->name_id,'-');

				$img_url = $nmp.'-'.$salt. '.' . $image->getClientOriginalExtension();

				$upload1 = Image::make($image)->encode('data-url');
				$upload1->save($directory.'/'.$img_url);
				$save->picture_first = $img_url;
			}

			if($request->file('picture_second') and in_array('picture_second', $columns)){
				
				$directory = 'asset/picture/'.$index;
				if ($save->picture_second != null) {
					File::delete($directory.'/'.$save->picture_second);
				}
				$salt = str_random(4);
				$image = $request->file('picture_second');

				$nmp = str_slug($request->name_id,'-');

				$img_url = $nmp.'-'.$salt. '.' . $image->getClientOriginalExtension();

				$upload1 = Image::make($image)->encode('data-url');
				$upload1->save($directory.'/'.$img_url);
				$save->picture_second = $img_url;
			}

			if (in_array('administrator_id', $columns)) {
				$save->administrator_id = Auth::guard('administrator')->user()->id;
			}
			$save->save();

			if (in_array($index, array('banner', 'management', 'partner'))) {
				$text .= title_case($save->name);
			}
			else if(in_array($index, array('certificate', 'news-event', 'portofolio'))) {
				$text .= title_case($save->name_id).' - '.title_case($save->name_en);
			}
				

			UserLogHelper::saved(title_case($index), $action, $text);

			return $save;
		});

		if(isset($hasil->name)){
			$hasil_name = $hasil->name;
		}
		else{
			$hasil_name = $hasil->name_id.' - '.$hasil->name_en;
		}

		return response()->json([
			'response'=>true,
         	'msg'=>'Saved Data '.$hasil_name
		]);
	}

	public function action($index, request $request){
		$Model = $this->baseModals.studly_case($index);
		$getId = explode('^', $request->id);
		foreach ($getId as $id) {
			if ($id != null) {
				$get = $Model::find($id);

				if (!$get) {
					return response()->json([
						'response'=>false,
						'msg'=>'Sorry...! Something Wrong!'
					]);
				}

				if($request->action == 'deactivate' OR $request->action == 'activate'){
					if ($get->publish_at == null and $request->action == 'activate') {
						$get->publish_at = date("Y-m-d h:i:s");
					}
					$get->flag = $request->action == 'deactivate' ? 'N' : 'Y';
					$get->save();
				}
				else if($request->action == 'delete'){
					$columns=$get->getTableColumns();
					if(in_array('picture', $columns)){
						File::delete('asset/picture/'.$index.'/'.$get->picture);
					}
					if(in_array('picture_first', $columns)){
						File::delete('asset/picture/'.$index.'/'.$get->picture_first);
					}
					if(in_array('picture_second', $columns)){
						File::delete('asset/picture/'.$index.'/'.$get->picture_second);
					}
					
					$get->delete();
				}
				else if ($request->action == 'portofolio') {
					$get->portofolio_id = $request->portofolio == 0 ? null : $request->portofolio;
					$get->save();
				}

				if ($request->action != 'portofolio' and $index != 'portofolio-galeri'){
					if (in_array($index, array('banner', 'management', 'partner'))) {
						$nameULH = $get->name;
					}
					else if(in_array($index, array('career', 'certificate', 'news-event', 'portofolio'))) {
						$nameULH = $get->name_id.' - '.$get->name_en;
					}

					UserLogHelper::saved(
						title_case(str_replace('-', ' ', $index)), 
						title_case(str_replace('-', ' ', $request->action)), 
						title_case($nameULH)
					);
				}
			}
		}
		return response()->json([
			'response'=>true,
			'msg'=>'<strong>Success!</strong> Execute Your Request!'
		]);
	}

	public function StorePortofolioGaleri(request $request){
		$message = [];

		$validator = Validator::make($request->all(), [
			'file' => 'required|image|mimes:jpeg,png',
		], $message);

		if($validator->fails()){
	        return response()->json([
				'action'=>false
	        	// 'resault'=>$validator->getMessageBag()->toArray()
	        ]);
		}
		$index = 'portofolio-galeri';
		$Model = $this->baseModals.studly_case($index);

		$resault = DB::transaction(function () use($request, $index, $Model) {
			$save = new $Model;

			$columns=$save->getTableColumns(); // memanggil semua column/field pada table
			
			if (in_array('administrator_id', $columns)) {
				$save->administrator_id = Auth::guard('administrator')->user()->id;
			}

			$salt = str_random(4);
			$image = $request->file('file');
			$img_url = $index.'-'.$salt.'_'.str_slug(Carbon::now()).'.'. $image->getClientOriginalExtension();
			$upload1 = Image::make($image)->encode('data-url');
			$upload1->save('asset/picture/'.$index.'/'.$img_url);
			$save->picture 			= $img_url;
			$save->save();

		    return $save;
		});

		return response()->json([
			'action'=>true
        ]);
	}
}
