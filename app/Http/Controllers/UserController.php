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
        try {
            $id = Crypt::decrypt($encryptedId);
        } catch (\Exception $e) {
            Log::error('Decryption failed: ' . $e->getMessage());
            return redirect()->route('admin.dashboard')->withErrors(['error' => 'Invalid user ID']);
        }
    
        $user = User::findOrFail($id);
    
        $user->update($request->only(['name', 'email', 'role']));
    
        return redirect()->route('admin.users.edit', Crypt::encrypt($user->id))
            ->with('success', 'User updated successfully');
    }
    
    
    
    
    public function destroy( $encryptedId){
        $id = Crypt::decrypt($encryptedId);
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('admin.dashboard')->with('success', 'User deleted successfully');
    }
}
