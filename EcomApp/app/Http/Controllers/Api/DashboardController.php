<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    protected $user;

    public function __construct()
    {
        $this->user = Auth::user();
    }

    public function index()
    {
        $dashboardResource = new DashboardResource($this->user);
        return response()->json($dashboardResource, 200);
    }
}
