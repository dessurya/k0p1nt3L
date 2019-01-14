<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Banner;
use App\Models\Career;
use App\Models\Certificate;
use App\Models\Management;
use App\Models\NewsEvent;
use App\Models\Partner;
use App\Models\Portofolio;
use App\Models\PortofolioGaleri;
use App\Models\Inbox;
use App\Models\InboxMailNotif;

use App;
use Validator;
use DB;
use Mail;

use Illuminate\Support\Facades\Route;

class FrontController extends Controller{

	public static function getNavbar($type){
		$html = "";
		$routename = Route::currentRouteName();
		if ($type == "header") {
			if (Portofolio::where('flag', 'Y')->count() >= 1) {
				if($routename == 'main.portofolio' or $routename == 'main.portofolio.galeri'){ $class = 'active'; } else { $class = ''; }
				$html .= '<div class="col">';
				$html .= '	<a class="'.$class.'" href="'. route('main.portofolio') .'">';
				$html .= 		__('main.portofolio');
				$html .= '	</a>';
				$html .= '</div>';
			}
			if (NewsEvent::where('flag', 'Y')->count() >= 1) {
				if($routename == 'main.newsevent' or $routename == 'main.newsevent.view'){ $class = 'active'; } else { $class = ''; }
				$html .= '<div class="col">';
				$html .= '	<a class="'.$class.'" href="'. route('main.newsevent') .'">';
				$html .= 		__('main.berita_acara');
				$html .= '	</a>';
				$html .= '</div>';
			}
			if (Career::where('flag', 'Y')->count() >= 1) {
				if($routename == 'main.career'){ $class = 'active'; } else { $class = ''; }
				$html .= '<div class="col">';
				$html .= '	<a class="'.$class.'" href="'. route('main.career') .'">';
				$html .= 		__('main.karier');
				$html .= '	</a>';
				$html .= '</div>';
			}
		}else if ($type == "footer"){
			if (Portofolio::where('flag', 'Y')->count() >= 1) {
				if($routename == 'main.portofolio' or $routename == 'main.portofolio.galeri'){ $class = 'active'; } else { $class = ''; }
				$html .= '<div>';
				$html .= '	<a class="'.$class.'" href="'. route('main.portofolio') .'">';
				$html .= 		__('main.portofolio');
				$html .= '	</a>';
				$html .= '</div>';
			}
			if (NewsEvent::where('flag', 'Y')->count() >= 1) {
				if($routename == 'main.newsevent' or $routename == 'main.newsevent.view'){ $class = 'active'; } else { $class = ''; }
				$html .= '<div>';
				$html .= '	<a class="'.$class.'" href="'. route('main.newsevent') .'">';
				$html .= 		__('main.berita_acara');
				$html .= '	</a>';
				$html .= '</div>';
			}
			if (Career::where('flag', 'Y')->count() >= 1) {
				if($routename == 'main.career'){ $class = 'active'; } else { $class = ''; }
				$html .= '<div>';
				$html .= '	<a class="'.$class.'" href="'. route('main.career') .'">';
				$html .= 		__('main.karier');
				$html .= '	</a>';
				$html .= '</div>';
			}
		}
		return $html;
	}

	public function home(){
		$name = "name_".App::getLocale()." as name";
		$content = "content_".App::getLocale()." as content";

		$banner = Banner::where('flag', 'Y')->orderBy('publish_at', 'desc')->limit(5)->get();
		$portofolio = Portofolio::select("*", "$name", "$content")->where('flag', 'Y')->orderBy('publish_at', 'desc')->limit(5)->get();
		$newsevent = NewsEvent::select("*", "$name", "$content")->where('flag', 'Y')->orderBy('publish_at', 'desc')->limit(3)->get();
		$banner = Banner::where('flag', 'Y')->orderBy('publish_at', 'desc')->limit(5)->get();
		$partner = Partner::where('flag', 'Y')->inRandomOrder()->limit(5)->get();

		return view('main.home.index', compact('banner', 'portofolio', 'newsevent', 'partner'));
	}

	public function about(){
		$name = "name_".App::getLocale()." as name";
		$position = "position_".App::getLocale()." as position";

		$certificate = Certificate::select("*", "$name")->where('flag', 'Y')->orderBy('publish_at', 'desc')->paginate(3);
		$management = Management::select("*", "$position")->where('flag', 'Y')->orderBy('publish_at', 'desc')->get();

		return view('main.about.index', compact(
			'certificate',
			'management'
		));
	}

	public function certificationCallList(request $request){
		$name = "name_".App::getLocale()." as name";
		$certificate = Certificate::select("*", "$name")->where('flag', 'Y')->orderBy('publish_at', 'desc')->paginate(3);
		$view = "";
		foreach ($certificate as $list) {
			$view .= view('main._layout._certification_list', compact('list'));	
		}
		return response()->json(['html'=>$view]);
	}

	public function portofolio(){
		$name = "name_".App::getLocale()." as name";
		$content = "content_".App::getLocale()." as content";

		$portofolio = Portofolio::select("*", "$name", "$content")->where('flag', 'Y')->orderBy('publish_at', 'desc')->get();

		if (count($portofolio) <= 0) {
			return redirect()->route('main.home');
		}
		
		return view('main.portofolio.index', compact(
			'portofolio'
		));
	}
	public function portofolioGaleri($slug){
		$name = "name_".App::getLocale()." as name";
		$content = "content_".App::getLocale()." as content";
		$project = "project_".App::getLocale()." as project";

		$portofolio = Portofolio::select("*", "$name", "$content", "$project")->where('flag', 'Y')->where('slug', $slug)->first();

		if (!$portofolio) {
			return redirect()->route('main.home');
		}

		$gallery= PortofolioGaleri::where('portofolio_id', $portofolio->id)->orderBy('created_at', 'desc')->paginate(6);

		return view('main.portofolio.show', compact(
			'portofolio', 'gallery'
		));
	}

	public function portofolioGaleriCallList($slug, request $request){
		$portofolio = Portofolio::where('flag', 'Y')->where('slug', $slug)->first();
		$gallery= PortofolioGaleri::where('portofolio_id', $portofolio->id)->orderBy('created_at', 'desc')->paginate(6);
		$view = "";
		foreach ($gallery as $list) {
			$view .= view('main._layout._portfolio_galeri_list', compact('list'));	
		}
		return response()->json(['html'=>$view]);
	}

	public function newsevent(){
		$name = "name_".App::getLocale()." as name";
		$newsevent = NewsEvent::select("*", "$name")->where('flag', 'Y')->orderBy('publish_at', 'desc')->paginate(12);
		if (count($newsevent) <= 0) {
			return redirect()->route('main.home');
		}
		return view('main.newsevent.index', compact(
			'newsevent'
		));
	}

	public function newseventCallList(request $request){
		$name = "name_".App::getLocale()." as name";
		$newsevent = NewsEvent::select("*", "$name")->where('flag', 'Y')->orderBy('publish_at', 'desc')->paginate(12);
		$view = "";
		foreach ($newsevent as $list) {
			$view .= view('main._layout._newsevent_list', compact('list'));	
		}
		return response()->json(['html'=>$view]);
	}

	public function newseventView($slug){
		$name = "name_".App::getLocale()." as name";
		$content = "content_".App::getLocale()." as content";
		$view = NewsEvent::select("*", "$name", "$content")->where('flag', 'Y')->where('slug', $slug)->first();
		if (!$view) {
			return redirect()->route('main.home');
		}
		$newsevent = NewsEvent::select("*", "$name")->where('flag', 'Y')->inRandomOrder()->limit(4)->get();
		if ($view) {
			return view('main.newsevent.view', compact(
				'view',
				'newsevent'
			));
		}
		else{

		}
	}

	public function career(){
		$name = "name_".App::getLocale()." as name";
		$career = Career::select("*", "$name")->where('flag', 'Y')->orderBy('publish_at', 'desc')->paginate(10);
		if (count($career) <= 0) {
			return redirect()->route('main.home');
		}
		return view('main.career.index', compact(
			'career'
		));
	}

	public function careerCallList(request $request){
		$name = "name_".App::getLocale()." as name";
		$career = Career::select("*", "$name")->where('flag', 'Y')->orderBy('publish_at', 'desc')->paginate(10);
		$view = "";
		foreach ($career as $list) {
			$view .= view('main._layout._career_list', compact('list'));	
		}
		return response()->json(['html'=>$view]);
	}

	public function contact(){
		return view('main.contact.index');
	}

	public function sendMessage(request $request){
        $message = [];
		$validator = Validator::make($request->all(), [
			'name' => 'required|max:75',
			'handphone' => 'nullable|min:8|max:25',
			'email' => 'required|email',
			'subject' => 'required',
			'message' => 'required|min:10',
		], $message);

		if($validator->fails()){
			return response()->json([
				'response'=>false,
	        	'resault'=>$validator->getMessageBag()->toArray(),
	        	'msg'=>__('main.maaf_terjadi_kesalahan')
	        ]);
		}

		DB::transaction(function () use($request) {
			$save = new Inbox;
			$save->name		= $request->name;
			$save->email	= $request->email;
			$save->handphone= $request->handphone;
			$save->subject	= $request->subject;
			$save->message	= $request->message;
			$save->save();
		});

		$imn = InboxMailNotif::get();
		$cc = null;

		if ($imn) {
			$cc = array();

			foreach ($imn as $key) {
				array_push($cc, $key->getAdministrator->email);
			}
		}

		$data = array('name'=>"Sam Jose", "body" => "Test mail");
	    
		Mail::send('mail.try', $data, function($message) use ($data, $cc) {
		    $message->to('fourline66@gmail.com', 'Adam');
		    if ($cc != null) {
		    	$message->cc($cc);
		    }
		    $message->subject('Email Baru');
		    $message->from('asd.robot001@gmail.com','asd robot 001');
		});

		return response()->json([
			'response'=>true,
        	'msg'=>__('main.berhasil_dikirim')
        ]);
    }
}
