<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    //
    protected $user;

    public function __construct()
    {
        $this->user = Auth::user();
    }

    public function index(Request $request)
    {
        $user_ids = $this->user->flattenTree();
        $users = User::whereIn('id', $user_ids)->where('id', '!=', $this->user->id)->get();
        $userCollection = UserResource::collection($users);
        return response()->json($userCollection, 200);
    }
}
