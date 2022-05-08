<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class AdminController extends Controller
{
    public function __construct()
    {
        // 
    }

    public function index () {
        return view('admin.home-users');
    }

    public function getUser () {
        $user = User::all();
        return Datatables::of($user)->make(true);
    }
}
