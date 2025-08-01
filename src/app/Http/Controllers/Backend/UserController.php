<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserStoreRequest;
use App\Models\User;

class UserController extends Controller
{
    public function UserView(){
        $data['allData'] = User::all();
        return view('backend.user.view-user',$data);
    }

    public function UserAdd(){
        return view('backend.user.add');
    }

    public function UserStore(UserStoreRequest $request){
        
        $data = new User();
        $data->user_type = $request->user_type;
        $data->name = $request->name;
        $data->email = $request->email;
        $data->password = bcrypt($request->password);
        $data->save();

        $notification = [
            'message' => 'User added successfully',
            'alert-type' => 'success'
        ];


        return redirect()->route('user.view')->with($notification);
    
    }
}
