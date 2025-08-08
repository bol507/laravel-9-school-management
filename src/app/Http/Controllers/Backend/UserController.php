<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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

    public function passwordView(){
        $user = Auth::user();
        return view('backend.user.edit-password',compact('user'));
    }

    public function passwordUpdate(UpdatePasswordRequest $request){
        $user = User::findOrFail(Auth::user()->id);
        $validated = $request->validated();
        $hashedPassword = $user->password;
        if (!Hash::check($validated['old_password'], $hashedPassword)) {
            $notification = [
                'message' => 'Old password is incorrect',
                'alert-type' => 'danger'
            ];
            return redirect()->route('user.password')->with($notification);
        }
        else {
            
            $validated['password'] = Hash::make($validated['password']);
            $user->update($validated);
            $notification = [
                'message' => 'Password updated successfully',
                'alert-type' => 'success'
            ];
            Auth::logout();
            return redirect()->route('login')->with($notification);
        }
        
    }
}
