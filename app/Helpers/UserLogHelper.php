<?php
namespace App\Helpers;

use App\Models\AdministratorLogs;

use Auth;

class UserLogHelper {
	public static function saved($index, $action, $data){
		$text = title_case(str_replace('_', ' ', $index))." | ".$action." - ".$data;
		$record = new AdministratorLogs;
        $record->administrator_id = Auth::guard('administrator')->user()->id;
        $record->logs = $text;
        $record->save();
	}	
}