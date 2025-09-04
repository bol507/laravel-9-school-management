<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function UserView(Request $request)
    {

        $perPage = (int) $request->input('limit', 10);
        $perPage = max(1, min($perPage, 100));

        $search = trim((string) $request->input('search', ''));
        $query = User::query();

        if ($search) {
            $query->where('name', 'like', "%{$search}%");
        }

        $docs = $query->orderBy('name', 'asc')
            ->paginate($perPage)
            ->appends($request->query());

        return view('backend.user.view-user', compact('docs', 'search'));
    }

    public function UserAdd()
    {
        return view('backend.user.add');
    }

    public function UserStore(StoreUserRequest $request)
    {

        $validated = $request->validated();
        $validated['password'] = Hash::make($validated['password']);
        $notification = [];

        try {
            DB::transaction(function () use ($validated) {
                User::create($validated);
            });

            $notification = [
                'message' => 'User added successfully',
                'alert-type' => 'success'
            ];
            return redirect()->route('user.view')->with($notification);
        } catch (\Exception $e) {

            Log::error('Error adding user: ' . $e->getMessage());
            $notification = [
                'message' => 'An error occurred while adding the user: ' . $e->getMessage(),
                'alert-type' => 'error'
            ];
            return redirect()->route('user.view')->with($notification);
        }
    }

    public function UserEdit($id)
    {
        $doc = User::find($id);
        return view('backend.user.edit', compact('doc'));
    }

    public function UserUpdate(UserUpdateRequest $request, $id)
    {

        try {
            DB::transaction(function () use ($request, $id) {
                $user = User::findOrFail($id);
                $user->update($request->validated());
            });


            $notification = [
                'message' => 'User updated successfully',
                'alert-type' => 'success'
            ];
            return redirect()->route('user.view')->with($notification);
        } catch (\Throwable $e) {
            Log::error('An error occurred while updating the user:', [
                'id' => $id,
                'error' => $e->getMessage()
            ]);
            $notification = [
                'message' => 'An error occurred while updating user',
                'alert-type' => 'danger'
            ];
            return redirect()->route('user.view')->with($notification);
        }
    }

    public function UserDelete($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        $notification = [
            'message' => 'User deleted successfully',
            'alert-type' => 'success'
        ];
        return redirect()->route('user.view')->with($notification);
    }

    public function passwordView()
    {
        $user = Auth::user();
        return view('backend.user.edit-password', compact('user'));
    }

    public function passwordUpdate(UpdatePasswordRequest $request)
    {
        $user = User::findOrFail(Auth::user()->id);
        $validated = $request->validated();
        try {
            if (!Hash::check($validated['old_password'], $user->password)) {
                $notification = [
                    'message' => 'Old password is incorrect',
                    'alert-type' => 'danger'
                ];
                return redirect()->route('user.password')->with($notification);
            }

            DB::transaction(function () use ($user, $validated) {
                $validated['password'] = Hash::make($validated['password']);
                $user->update(['password' => $validated['password']]);
            });

            $notification = [
                'message' => 'Password updated successfully',
                'alert-type' => 'success'
            ];
            Auth::logout();
            return redirect()->route('login')->with($notification);
        } catch (\Throwable $e) {
            Log::error('An error occurred while updating the password:', [
                'user_id' => $user->id,
                'error' => $e->getMessage()
            ]);

            $notification = [
                'message' => 'An error occurred while updating the password',
                'alert-type' => 'danger'
            ];
            return redirect()->route('user.password')->with($notification);
        }
    }
}
