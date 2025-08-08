<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\Profile;
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

    public function UserEdit($id){
        $editUser = User::find($id);
        return view('backend.user.edit',compact('editUser'));
    }

    public function UserUpdate(UserUpdateRequest $request, $id){
        $user = User::findOrFail($id);
        $user->update($request->validated());
        $notification = [
            'message' => 'User updated successfully',
            'alert-type' => 'success'
        ];
        return redirect()->route('user.view')->with($notification);
    }

    public function UserDelete($id){
        $user = User::findOrFail($id);
        $user->delete();
        $notification = [
            'message' => 'User deleted successfully',
            'alert-type' => 'success'
        ];
        return redirect()->route('user.view')->with($notification);
    }
}
