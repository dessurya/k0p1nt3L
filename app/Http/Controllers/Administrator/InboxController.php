<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Administrator;
use App\Models\Inbox;
use App\Models\InboxMailNotif;
use DataTables;

class InboxController extends Controller
{
	public function index($index){
		return view('administrator.inbox.index', compact('index'));
	}

	public function data($index, request $request){
		if ($index == 'list') {
			$data = Inbox::select('*')->orderBy('created_at', 'desc')->get();

			return $Datatables = Datatables::of($data)->editColumn('message', function ($data){
					$html = '<div class="content">'.$data->message.'</div>';
		    		return $html;
				})->escapeColumns(['*'])->make();
		}
		else{
			$data = Administrator::select('*')->orderBy('created_at', 'desc')->get();
			
			return $Datatables = Datatables::of($data)
				->editColumn('confirmed', function ($data){
					$html = $data->confirmed == 'Y' ? 'Active' : 'Deactive';
		    		return $html;
				})
				->addColumn('send', function ($data){
					if ($data->getIMN) {
						$html = "<button type='button' class='btn btn-success btn-sm choice' data-href='".route('adm.mid.inbox.action', ['id' => $data->id])."' data-confirmed='".$data->confirmed."'><i class='fa fa-check-square-o'></i></button>";
					}
					else{
						$html = "<button type='button' class='btn btn-sm choice' data-href='".route('adm.mid.inbox.action', ['id' => $data->id])."' data-confirmed='".$data->confirmed."'><i class='fa fa-square-o'></i></button>";
					}
		    		return $html;
				})
				->escapeColumns(['*'])->make();	
		}
	}

	public function action($id){
		$cek = InboxMailNotif::where('administrator_id', $id)->first();

		if($cek){
			$cek->delete();
		}
		else{
			$new = new InboxMailNotif;

			$new->administrator_id = $id;
			$new->save();
		}
		return response()->json([
			'response'=>true,
			'msg'=>'<strong>Success!</strong> Execute Your Request!'
		]);
	}
}
