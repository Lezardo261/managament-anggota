<?php

namespace App\Http\Controllers;

use App\Models\User;
use inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Crypt;

class UserController extends Controller
{
    public function edit($encryptedId)
    {
        $id = Crypt::decrypt($encryptedId);
        $user = User::findOrFail($id);
        return Inertia::render('Admin/EditUser', [
            'user' => [
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
                'encrypted_id' => $encryptedId 
            ],
        ]);
    }
    
    public function update(Request $request, $encryptedId)
    {
        $id = Crypt::decrypt($encryptedId);

        $user = User::findOrFail($id);
    
        $user->update($request->only(['name', 'email', 'role']));
    
        return redirect()->route('admin.users.edit', Crypt::encrypt($user->id))
            ->with('success', 'User updated successfully');
    }

    public function updateRole(Request $request, $encryptedId)
    {
        $id = Crypt::decrypt($encryptedId);
        $user = User::findOrFail($id);
        
        $request->validate([
            'role' => 'required|in:admin,user',
        ]);
        
        $user->role = $request->input('role');
        $user->save();
    }

    
    
    
    public function destroy( $encryptedId){
        $id = Crypt::decrypt($encryptedId);
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('admin.dashboard')->with('success', 'User deleted successfully');
    }
}
