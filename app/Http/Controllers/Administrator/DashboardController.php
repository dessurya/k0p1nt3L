<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App;

class DashboardController extends Controller
{
	public function index(){
		return view('administrator.dashboard.index');
	}
}
