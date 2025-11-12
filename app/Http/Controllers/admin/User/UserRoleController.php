<?php

namespace App\Http\Controllers\admin\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserRoleController extends Controller
{
    // Show all users with their roles
    public function index()
    {
        $users = User::orderBy('id', 'desc')->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    // Edit user role
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    // Update user role
    public function update(Request $request, $id)
    {
        $request->validate([
            'role' => 'required|in:viewer,admin,hr',
        ]);

        $user = User::findOrFail($id);
        $user->role = $request->role;
        $user->save();

        return redirect()->route('admin.users.index')
            ->with('success', 'User role updated successfully.');
    }

    public function destroy(User $user)
    {
        if (Auth::id() == $user->id) {
            return redirect()->back()->with('error', 'You cannot delete your own account.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully.');
    }

    public function list()
    {
        $users = User::orderBy('name')->paginate();
        return view('admin.users.list', compact('users'));
    }
}
