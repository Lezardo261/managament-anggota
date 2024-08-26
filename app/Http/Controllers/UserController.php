<?php

namespace App\Http\Controllers;

use App\Models\User;
use inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return Inertia::render('Admin/EditUser', [
            'user' => $user,
        ]);
    }

    public function update(Request $request, $id)
    {
        // Temukan model yang ada berdasarkan ID dari parameter rute
        $user = User::findOrFail($id);
        
        
        
        // Perbarui data model
        $user->update($request->only(['name', 'email', 'role']));
    
        // Redirect dengan ID pengguna yang diperbarui
        return redirect()->route('admin.users.edit', $user->id)
            ->with('success', 'User updated successfully');
    }
    
    
    
    public function destroy(User $user){
        $user->delete();
        return redirect()->route('admin.dashboard')->with('success', 'User deleted successfully');
    }
}
