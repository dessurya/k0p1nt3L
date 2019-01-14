<?php
namespace App\Helpers;

use Validator;
use Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class ContentWebHelper {

	public static function store($index, $request){
		$message = [];
		if (isset($request->slug)) {
			$Model = "App\Models\\".studly_case($index);
			$save = $Model::where('slug', $request->slug)->first();
			if (!$save) {
				return response()->json([
					'response'=>false,
		         	'resault'=>null,
		         	'msg'=>'Sorry! Some Thing Wrong...!'
	         	]);
			}
			$id = $save->id;
		}
		else if (isset($request->id)) {
			$Model = "App\Models\\".studly_case($index);
			$save = $Model::find($request->id);
			if (!$save) {
				return response()->json([
					'response'=>false,
		         	'resault'=>null,
		         	'msg'=>'Sorry! Some Thing Wrong...!'
	         	]);
			}
			$id = $save->id;
		}

		if ($index == 'banner') {
			if (isset($id)) {
				$validator = Validator::make($request->all(), [
					'name' => 'required|max:175',
					'picture' => 'nullable|image|mimes:jpeg,bmp,png|max:6500',
				], $message);
			}
			else {
				$validator = Validator::make($request->all(), [
					'name' => 'required|max:175',
					'picture' => 'required|image|mimes:jpeg,bmp,png|max:6500',
				], $message);
			}
		}
		else if ($index == 'career') {
			if (isset($id)) {
				$validator = Validator::make($request->all(), [
					'name_id' => 'required|max:175|unique:kti_career,name_id,'.$id,
					'name_en' => 'required|max:175|unique:kti_career,name_en,'.$id,
					'picture' => 'nullable|image|mimes:jpeg,bmp,png|max:6500',
				], $message);
			}
			else {
				$validator = Validator::make($request->all(), [
					'name_id' => 'required|max:175|unique:kti_career,name_id',
					'name_en' => 'required|max:175|unique:kti_career,name_en',
					'picture' => 'nullable|image|mimes:jpeg,bmp,png|max:6500',
				], $message);
			}
		}
		else if ($index == 'certificate') {
			if (isset($id)) {
				$validator = Validator::make($request->all(), [
					'name_id' => 'required|max:175|unique:kti_certificate,name_id,'.$id,
					'name_en' => 'required|max:175|unique:kti_certificate,name_en,'.$id,
					'picture' => 'nullable|image|mimes:jpeg,bmp,png|max:6500',
				], $message);
			}
			else {
				$validator = Validator::make($request->all(), [
					'name_id' => 'required|max:175|unique:kti_certificate,name_id',
					'name_en' => 'required|max:175|unique:kti_certificate,name_en',
					'picture' => 'nullable|image|mimes:jpeg,bmp,png|max:6500',
				], $message);
			}
		}
		else if ($index == 'management') {
			if (isset($id)) {
				$validator = Validator::make($request->all(), [
					'name' => 'required|max:175',
					'picture' => 'nullable|image|mimes:jpeg,bmp,png|max:6500',
					'position_id' => 'required|max:175',
					'position_en' => 'required|max:175',
				], $message);
			}
			else {
				$validator = Validator::make($request->all(), [
					'name' => 'required|max:175',
					'picture' => 'required|image|mimes:jpeg,bmp,png|max:6500',
					'position_id' => 'required|max:175',
					'position_en' => 'required|max:175',
				], $message);
			}
		}
		else if ($index == 'news-event') {
			if (isset($id)) {
				$validator = Validator::make($request->all(), [
					'name_id' => 'required|max:175|unique:kti_news_event,name_id,'.$id,
					'name_en' => 'required|max:175|unique:kti_news_event,name_en,'.$id,
					'content_id' => 'required',
					'content_en' => 'required',
					'picture' => 'nullable|image|mimes:jpeg,bmp,png|max:6500',
				], $message);
			}
			else {
				$validator = Validator::make($request->all(), [
					'name_id' => 'required|max:175|unique:kti_news_event,name_id',
					'name_en' => 'required|max:175|unique:kti_news_event,name_en',
					'content_id' => 'required',
					'content_en' => 'required',
					'picture' => 'required|image|mimes:jpeg,bmp,png|max:6500',
				], $message);
			}
		}
		else if ($index == 'partner') {
			if (isset($id)) {
				$validator = Validator::make($request->all(), [
					'name' => 'required|max:175',
					'web' => 'nullable',
					'picture' => 'nullable|image|mimes:jpeg,bmp,png|max:6500',
				], $message);
			}
			else {
				$validator = Validator::make($request->all(), [
					'name' => 'required|max:175',
					'web' => 'nullable',
					'picture' => 'required|image|mimes:jpeg,bmp,png|max:6500',
				], $message);
			}
		}
		else if ($index == 'portofolio') {
			if (isset($id)) {
				$validator = Validator::make($request->all(), [
					'name_id' => 'required|max:175|unique:kti_portofolio,name_id,'.$id,
					'name_en' => 'required|max:175|unique:kti_portofolio,name_en,'.$id,
					'content_id' => 'required',
					'content_en' => 'required',
					'picture_first' => 'nullable|image|mimes:jpeg,bmp,png|max:6500',
					'picture_second' => 'nullable|image|mimes:jpeg,bmp,png|max:6500',
				], $message);
			}
			else {
				$validator = Validator::make($request->all(), [
					'name_id' => 'required|max:175|unique:kti_portofolio,name_id',
					'name_en' => 'required|max:175|unique:kti_portofolio,name_en',
					'content_id' => 'required',
					'content_en' => 'required',
					'picture_first' => 'required|image|mimes:jpeg,bmp,png|max:6500',
					'picture_second' => 'required|image|mimes:jpeg,bmp,png|max:6500',
				], $message);
			}	
		}
		else{
			return array(
				'response'=>false,
	         	'resault'=>'terjadi kesalahan dalam pengambilan data...!'
			);
		}

		if($validator->fails()){
			return array(
				'response'=>false,
	         	'resault'=>$validator->getMessageBag()->toArray()
			);
		}
		return array(
			'response'=>true
		);
	}
}