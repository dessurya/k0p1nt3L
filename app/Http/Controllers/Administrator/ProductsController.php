<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Industry;
use App\Models\Category;
use App\Models\Product;

use App\Models\Administrator;

use Auth;
use DataTables;
use DB;
use Validator;
use Image;
use File;

use UserLogHelper;
use ContentWebHelper;

class ProductsController extends Controller
{
	public function index($index, request $request){
		$indexList = array('industry', 'category', 'product');
		if(!in_array($index, $indexList)){
			return redirect()->route('adm.mid.dashboard');
		}

		$adm = Administrator::orderBy('name', 'asc')->get();
		if ($request->administrator) {
			$getFilterAdministrator = Administrator::where('email',$request->administrator)->first();
			if (!$getFilterAdministrator) {
	    		return redirect()->route('adm.mid.product.list', ['index'=>$index])
					->with('notif', 'Sorry! Something Wrong!');
			}
		}
		$industry = null;
		if ($index == 'category') {
			$industry = Industry::orderBy('name', 'asc')->get();
			if ($request->industry) {
				$getFilterIndustry = Industry::where('slug',$request->industry)->first();
				if (!$getFilterIndustry) {
		    		return redirect()->route('adm.mid.product.list', ['index'=>$index])
						->with('notif', 'Sorry! Something Wrong!');
				}
			}
		}
		$category = null;
		if ($index == 'product') {
			$category = Category::orderBy('name', 'asc')->get();
			if ($request->category) {
				$getFilterCategory = Category::where('slug',$request->category)->first();
				if (!$getFilterCategory) {
		    		return redirect()->route('adm.mid.product.list', ['index'=>$index])
						->with('notif', 'Sorry! Something Wrong!');
				}
			}
		}
		
		return view('administrator.product.index', compact('index', 'request', 'adm', 'industry', 'category'));
	}

	public function indexData($index, request $request){
		$Model = "App\Models\\".studly_case($index);
		$data = $Model::select('*');

		if ($request->administrator != null and isset($request->administrator)) {
			$getFilterAdministrator = Administrator::where('email',$request->administrator)->first();
    		$data->where('administrator_id', $getFilterAdministrator->id);
		}
		if ($request->status != null and isset($request->status)) {
			if ($request->status == 'active') {
				$data->where('flag', 'Y');
			}
			else if ($request->status == 'deactive') {
	    		$data->where('flag', 'N');
			}
		}
		if ($request->industry != null and isset($request->industry)) {
			$getFilterIndustry = Industry::where('slug', $request->industry)->first();
    		$data->where('product_industry_id', $getFilterIndustry->id);
		}
		if ($request->category != null and isset($request->category)) {
			$getFilterCategory = Category::where('slug', $request->category)->first();
    		$data->where('product_category_id', $getFilterCategory->id);
		}
		$data = $data->orderBy('created_at', 'desc')->get();

		$Datatables = Datatables::of($data)
			->editColumn('name', function($data) use ($index){
				$html = '';
				if ($index == 'category' or $index == 'product') {
					$html .= $data->getIndustry->name.' - | - ';
				}
				if ($index == 'product') {
					$html .= $data->getCategory->name.' - | - ';
				}
				$html .= title_case($data->name);
				if ($data->picture != null) {
					$html .= ' <br><a href="'.asset('asset/picture/'.$index.'/'.$data->picture).'" target="_blank"><img src="'.asset('asset/picture/'.$index.'/'.$data->picture).'"></a>';
				}
				return $html;
			})->editColumn('administrator_id', function($data){
				$html = '';
				if($data->getAdministrator == null){
	    			$html .= 'User Tidak Terdeteksi';
	    		}
	    		else{
					$html .= $data->getAdministrator->name.' <br>'.$data->getAdministrator->email;
				}
				return $html;
			})->editColumn('flag', function($data){
				$html = $data->flag == 'Y' ? 'Active' : 'Deactive' ;
				return $html;
			})->addColumn('action', function ($data) use ($index){
				$html = '';
				$html .= "<div class='btn-group'>";
				$html .= "<button type='button' class='btn btn-sm choice' data-slug='".$data->slug."'><i class='fa fa-square-o'></i></button>";
				$html .= "<button type='button' class='btn btn-sm btn-success'>";
				$html .= "<i class='fa fa-gears'></i> Tools";
				$html .= "</button>";
				$html .= "<button type='button' class='btn btn-sm btn-success dropdown-toggle' data-toggle='dropdown'>";
				$html .= "<span class='caret' style='color:white;'></span>";
				$html .= "</button>";
				$html .= "<ul class='dropdown-menu' role='menu'>";
				$html .= "<li><a class='open' data-href='".route('adm.mid.product.list.form', ['index'=>$index, 'slug'=>$data->slug])."' data-toggle='modal' data-target='.modal-add'><i class='fa fa-folder-open-o'></i> Open</a></li>";
				if ($index == 'industry') {
					$html .= "<li><a href='".route('adm.mid.product.list', ['index'=>'category', 'industry'=>$data->slug])."'><i class='fa fa-search'></i> Detail</a></li>";
				}
				if ($index == 'category') {
					$html .= "<li><a href='".route('adm.mid.product.list', ['index'=>'product', 'category'=>$data->slug])."'><i class='fa fa-search'></i> Detail</a></li>";
				}
				if($data->flag == 'Y'){
					$html .= "<li><a class='deactivate' data-href='".route('adm.mid.product.list.action', ['index'=>$index, 'action'=>'deactivate', 'slug'=>$data->slug])."' data-toggle='modal' data-target='.modal-aksi'><i class='fa fa-ban'></i> Deactivate</a></li>";
				}
				else{
					$html .= "<li><a class='activate' data-href='".route('adm.mid.product.list.action', ['index'=>$index, 'action'=>'activate', 'slug'=>$data->slug])."' data-toggle='modal' data-target='.modal-aksi'><i class='fa fa-check'></i> Activate</a></li>";
				}
				$html .= "<li><a class='delete' data-href='".route('adm.mid.product.list.action', ['index'=>$index, 'action'=>'delete', 'slug'=>$data->slug])."' data-toggle='modal' data-target='.modal-aksi'><i class='fa fa-trash-o'></i> Delete</a></li>";
				if ($data->picture != null) {
					$html .= "<li><a class='picture' data-href='".route('adm.mid.product.list.action', ['index'=>$index, 'action'=>'remove-picture', 'slug'=>$data->slug])."' data-toggle='modal' data-target='.modal-aksi'><i class='fa fa-scissors'></i> Remove Picture</a></li>";
				}
				$html .= "</ul>";
				$html .= "</div>";

	    		return $html;
			})->escapeColumns(['*'])->make();

		return $Datatables;
	}

	public function indexAction($index, request $request){
		$Model = "App\Models\\".studly_case($index);
		$getSlug = explode('^', $request->slug);
		foreach ($getSlug as $slug) {
			if ($slug != null) {
				$get = $Model::where('slug', $slug)->first();

				if (!$get) {
					return response()->json([
						'response'=>false,
						'msg'=>'Sorry...! Something Wrong!'
					]);
				}

				if($request->action == 'deactivate' OR $request->action == 'activate'){
					$get->flag = $request->action == 'deactivate' ? 'N' : 'Y';
					$get->save();
				}
				else if($request->action == 'remove-picture'){
					$directory = 'asset/picture/'.$index;
					File::delete($directory.'/'.$get->picture);
					$get->picture = null;
					$get->save();
				}
				else if($request->action == 'delete'){
					if ($index == 'industry') {
						$product = Product::where('product_industry_id', $get->id)->get();
						foreach ($product as $data) {
							File::delete('asset/picture/product/'.$data->picture);
							$data->delete();
							UserLogHelper::saved('Product', 'Delete', title_case($data->name));
						}
						$category = Category::where('product_industry_id', $get->id)->get();
						foreach ($category as $data) {
							File::delete('asset/picture/category/'.$data->picture);
							$data->delete();
							UserLogHelper::saved('Category', 'Delete', title_case($data->name));
						}
					}
					else if ($index == 'category') {
						$product = Product::where('product_category_id', $get->id)->get();
						foreach ($product as $data) {
							File::delete('asset/picture/product/'.$data->picture);
							$data->delete();
							UserLogHelper::saved('Product', 'Delete', title_case($data->name));
						}
					}
					File::delete('asset/picture/'.$index.'/'.$get->picture);
					$get->delete();
				}

				UserLogHelper::saved(
					title_case(str_replace('-', ' ', $index)), 
					title_case(str_replace('-', ' ', $request->action)), 
					title_case($get->name)
				);
			}
		}
		return response()->json([
			'response'=>true,
			'msg'=>'<strong>Success!</strong> Execute Your Request!'
		]);
	}

	public function openForm($index, request $request){
		$data = null;

		if (isset($request->slug)) {
			$Model = "App\Models\\".studly_case($index);
			$data = $Model::where('slug', $request->slug)->first();
			if (!$data) {
				return response()->json([
					'response'=>false,
					'html'=>'Sorry! Something Wrong!'
				]);
			}
		}

		$view = view('administrator.product._'.$index, compact('index','data'))->render();
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
			$Model = "App\Models\\".studly_case($index);
			$text = '';
			if ($request->slug) {
				$save = $Model::where('slug', $request->slug)->first();
				if (!$save) {
					return response()->json([
						'response'=>false,
			         	'resault'=>null,
			         	'msg'=>'Sorry! Something Wrong...!'
		         	]);
				}
				$action = 'Update';
				$text .= $save->name.' to ';
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

			if ($request->industry and in_array('product_industry_id', $columns)) {
				$save->product_industry_id = $request->industry;
			}

			if ($request->category and in_array('product_category_id', $columns)) {
				$save->product_category_id = $request->category;
			}

			if ($request->content and in_array('content', $columns)) {
				$save->content = $request->content;
			}

			if($request->file('picture') and in_array('picture', $columns)){
				
				$directory = 'asset/picture/'.$index;
				if ($save->picture != null) {
					File::delete($directory.'/'.$save->picture);
				}
				$salt = str_random(4);
				$image = $request->file('picture');
				$img_url = str_slug($request->name,'-').'-'.$salt. '.' . $image->getClientOriginalExtension();

				$upload1 = Image::make($image)->encode('data-url');
				$upload1->save($directory.'/'.$img_url);
				$save->picture = $img_url;
			}
			

			if (in_array('administrator_id', $columns)) {
				$save->administrator_id = Auth::guard('administrator')->user()->id;
			}
			$save->save();

			$text .= $save->name;

			UserLogHelper::saved(title_case($index), $action, $text);

			return $save;
		});

		return response()->json([
			'response'=>true,
         	'msg'=>'Saved Data '.$hasil->name
		]);
	}

	public function getIndustry(request $request){
		$industry = Industry::orderBy('name', 'asc')->get();

		if (isset($request->slug)) {
			$find = Category::where('slug', $request->slug)->first();
			if (!$find) {
				$find = Product::where('slug', $request->slug)->first();
			}
		}

		$html = '';
		$html .="<option value=''>Please Select One Option</option>";
		foreach ($industry as $data) {
			$html .="<option value='".$data->id."'";
			if(isset($request->slug)) {
				$find->product_industry_id == $data->id ? $html .=' selected' : '';
			}
			$html .=">".$data->name."</option>";
		}
		return response()->json(['response'=>true,'html'=>$html]);
	}

	public function getCategory(request $request){
		$html = '';
		$html .="<option value=''>Please Select One Option</option>";
		
		if(isset($request->slug) or isset($request->id)){
			if(isset($request->slug)){
				$me = Product::where('slug', $request->slug)->first();
			}

			$category = Category::orderBy('name', 'asc');
			if (isset($request->id)) {
				$category->where('product_industry_id', $request->id);
			}
			else if(isset($request->slug)){
				$category->where('product_industry_id', $me->product_industry_id);
			}

			$category = $category->get();
			
			foreach ($category as $data) {
				$html .="<option value='".$data->id."'";
				if(isset($request->slug)) {
					$me->product_category_id == $data->id ? $html .=' selected' : '';
				}
				$html .=">".$data->name."</option>";
			}
		}

		return response()->json(['response'=>true,'html'=>$html]);
	}
}
