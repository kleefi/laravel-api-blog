<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::paginate(10);
        return response()->json([
            "status" => true,
            "message" => "list of users",
            "data" => UserResource::collection($users)
        ]);
    }
}
