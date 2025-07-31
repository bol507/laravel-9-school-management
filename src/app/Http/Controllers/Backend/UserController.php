<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function UserView(){
        $data['allData'] = User::all();
        return view('backend.user.view-user',$data);
    }

    public function UserAdd(){
        return view('backend.user.add');
    }
}
