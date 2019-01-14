<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Administrator;
use App\Models\AdministratorLogs;

use Auth;
use Hash;
use DataTables;
use Validator;
use Image;
use File;

use Mail;

use UserLogHelper;

class AccountController extends Controller
{
	public function profile(){
		$id = Auth::guard('administrator')->user()->id;
		$me = Administrator::find($id);

		return view('administrator.account.profile', compact('me'));
	}
	public function meLogs(request $request){
		$id = Auth::guard('administrator')->user()->id;
		$logs = AdministratorLogs::select('created_at', 'logs')->where('administrator_id', $id)->orderBy('created_at', 'desc')->get();
		return $Datatables = Datatables::of($logs)->escapeColumns(['*'])->make();
	}

	public function logs(request $request){
		$adm = Administrator::orderBy('name', 'asc')->get();
		if ($request->administrator) {
			$getFilterAdministrator = Administrator::where('email',$request->administrator)->first();
			if (!$getFilterAdministrator) {
	    		return redirect()->route('adm.mid.account.logs')
					->with('notif', 'Sorry! Something Wrong!');
			}
		}
		return view('administrator.account.logs', compact('adm', 'request'));
	}
	public function logsList(request $request){
		$logs = AdministratorLogs::select('created_at', 'administrator_id', 'logs')->orderBy('created_at', 'desc');
		if ($request->administrator) {
			$getFilterAdministrator = Administrator::where('email',$request->administrator)->first();

    		$logs->where('administrator_id', $getFilterAdministrator->id);
		}
		$logs->get();

		return $Datatables = Datatables::of($logs)->editColumn('administrator_id', function ($logs){
	    		if($logs->getAdministrator == null){
	    			return 'User Tidak Terdeteksi';
	    		}
	    		else{
					return $logs->getAdministrator->name." <br>".$logs->getAdministrator->email;
	    		}
			})->escapeColumns(['*'])->make();
	}

	public function profileUpdate(request $request){
		$id = Auth::guard('administrator')->user()->id;
		$message = [];
		$validator = Validator::make($request->all(), [
			'name' => 'required|min:3',
			'email' => 'required|email|unique:kti_administrator,email,'.$id,
			'password_old' => 'required',
			'password_new' => 'nullable|min:8',
			'password_confirm' => 'nullable|required_with:password_new|min:8',
			'picture' => 'nullable|image|mimes:jpeg,bmp,png|max:6500',
		], $message);

		if($validator->fails()){
			return response()->json([
				'response'=>false,
				'resault'=>$validator->getMessageBag()->toArray(),
				'msg'=>'Sorry...! Something Wrong!'
			]);
		}

		$me = Administrator::find($id);

		if(Hash::check($request->password_old, $me->password)){
			if ($request->password_new) {
				$me->password = Hash::make($request->password_new);
			}
			if($request->file('picture')){
				
				$directory = 'asset/picture/administrator';
				if ($me->picture != null) {
					File::delete($directory.'/'.$me->picture);
				}
				$salt = str_random(4);
				$image = $request->file('picture');
				$img_url = str_slug($request->name,'-').'-'.$salt. '.' . $image->getClientOriginalExtension();

				$upload1 = Image::make($image)->encode('data-url');
				$upload1->save($directory.'/'.$img_url);
				$me->picture = $img_url;
			}

			$me->name = $request->name;
			$me->email = $request->email;
			$me->save();

			return response()->json([
				'response'=>true,
				'msg'=>'Success! Your Profile Change...'
			]);
		}
		else{
			return response()->json([
				'response'=>false,
				'resault'=>null,
				'old_pass'=>"Wrong Old Password.",
				'msg'=>'Sorry...! Something Wrong!'
			]);		
		}
	}

	public function add(request $request){
		$message = [];
		$validator = Validator::make($request->all(), [
			'name' => 'required|min:3',
			'email' => 'required|email|unique:kti_administrator,email',
		], $message);

		if($validator->fails()){
			return response()->json([
				'response'=>false,
				'resault'=>$validator->getMessageBag()->toArray(),
				'msg'=>'Sorry...! Something Wrong!'
			]);
		}

		$save = new Administrator;
		$np = 'kopin'.rand(0,9).rand(0,9).str_random(2);
		$save->password = Hash::make($np);
		$save->name = $request->name;
		$save->email = $request->email;

		$data = array('name'=>$save->name, "email" => $save->email, 'password' => $np);
	    $note = '';
	    try {
			Mail::send('mail.administrator_new', ['data' => $data], function($message) use ($data) {
			    $message->to($data['email'], $data['name']);
			    $message->subject('Welcome New Administrator');
			    $message->from('asd.robot001@gmail.com','Robot Administrator');
			});
			$note .= ' Success add administrator and send mail to '.$save->email;
			$save->save();
		} catch (\Exception $e) {
          $note .= ' Fail add administrator and send mail to '.$save->email;
        }

		UserLogHelper::saved('Administrator', 'Add', title_case($save->name));

		return response()->json([
			'response'=>true,
			'msg'=>$note
		]);
	}

	public function list(){
		return view('administrator.account.account');		
	}

	public function listData(request $request){
		$id = Auth::guard('administrator')->user()->id;
		$data = Administrator::whereNotIn('id',[$id])->get();

		return $Datatables = Datatables::of($data)->addColumn('action', function ($data){
				$html = '';
				$html .= "<div class='btn-group'>";
				$html .= "<button type='button' class='btn btn-sm btn-success'>";
				$html .= "<i class='fa fa-gears'></i> Tools";
				$html .= "</button>";
				$html .= "<button type='button' class='btn btn-sm btn-success dropdown-toggle' data-toggle='dropdown'>";
				$html .= "<span class='caret' style='color:white;'></span>";
				$html .= "</button>";
				$html .= "<ul class='dropdown-menu' role='menu'>";
				$html .= "<li><a href='".route('adm.mid.account.logs', ['administrator'=>$data->email])."'><i class='fa fa-history'></i> Logs</a></li>";
				if($data->confirmed == 'Y'){
					$html .= "<li><a class='deactivate' data-href='".route('adm.mid.account.list.data.action', ['action'=>'deactivate', 'administrator'=>$data->email])."' data-toggle='modal' data-target='.modal-aksi'><i class='fa fa-ban'></i> Deactivate</a></li>";
				}
				else{
					$html .= "<li><a class='activate' data-href='".route('adm.mid.account.list.data.action', ['action'=>'activate', 'administrator'=>$data->email])."' data-toggle='modal' data-target='.modal-aksi'><i class='fa fa-check'></i> Activate</a></li>";
				}
				$html .= "<li><a class='delete' data-href='".route('adm.mid.account.list.data.action', ['action'=>'delete', 'administrator'=>$data->email])."' data-toggle='modal' data-target='.modal-aksi'><i class='fa fa-trash-o'></i> Delete</a></li>";
				$html .= "</ul>";
				$html .= "</div>";

	    		return $html;
			})->editColumn('confirmed', function ($data){
				$html = '';
				if($data->confirmed == 'Y'){
					$html .= "Active";
				}
				else{
					$html .= "Deactive";
				}
				$html .= "</ul>";
				$html .= "</div>";

	    		return $html;
			})->escapeColumns(['*'])->make();
	}

	public function listDataAction($action, request $request){
		$get = Administrator::where('email',$request->administrator)->first();
		if (!$get) {
			return response()->json([
				'response'=>false,
				'msg'=>'Sorry...! Something Wrong!'
			]);
		}

		if($action == 'deactivate' OR $action == 'activate'){
			$get->confirmed = $action == 'deactivate' ? 'N' : 'Y';
			$get->save();
		}
		else if($action == 'delete'){
			$get->delete();
		}
		else{
			return response()->json([
				'response'=>false,
				'msg'=>'Sorry...! Something Wrong!'
			]);
		}

		UserLogHelper::saved('Administrator', title_case($action), title_case($get->name));

		return response()->json([
			'response'=>true,
			'msg'=>'<strong>Success!</strong> Execute Your Request!'
		]);
	}

}