<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Pagination\Paginator;


class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
    }

	public function index()
    {
        $data['tasks'] = [
            [ 'progress' => '87', 'color' => 'danger', 'name' => 'Design New Dashboard' ],
            [ 'progress' => '76', 'color' => 'warning', 'name' => 'Create Home Page' ],
            [ 'progress' => '32', 'color' => 'success', 'name' => 'Some Other Task' ],
            [ 'progress' => '56', 'color' => 'info', 'name' => 'Start Building Website' ],
            [ 'progress' => '10', 'color' => 'primary', 'name' => 'Develop an Awesome Algorithm', ],
            [ 'progress' => '15', 'color' => 'dark', 'name' => 'Develop an Awesome Algorithm' ]
        ];

        $home = view('layouts.dashboard_content')->with($data);
        return view('dashboard')->with('main_content', $home);
    }
}
