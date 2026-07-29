<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'avatar_base64' => 'nullable|string',
        ]);

        if ($request->filled('avatar_base64')) {
            $imageData = $request->input('avatar_base64');
            if (preg_match('/^data:image\/(\w+);base64,/', $imageData, $type)) {
                $data = substr($imageData, strpos($imageData, ',') + 1);
                $ext = strtolower($type[1]);
                if ($ext === 'jpeg') $ext = 'jpg';
                
                if (in_array($ext, ['jpg', 'png', 'gif', 'webp'])) {
                    $decodedData = base64_decode($data);
                    $fileName = 'avatars/' . $user->id . '_' . time() . '.' . $ext;
                    Storage::disk('public')->put($fileName, $decodedData);
                    
                    // Hapus avatar lama jika bukan null
                    if ($user->avatar) {
                        $oldPath = str_replace('/storage/', '', $user->avatar);
                        if (Storage::disk('public')->exists($oldPath)) {
                            Storage::disk('public')->delete($oldPath);
                        }
                    }
                    
                    $user->avatar = '/storage/' . $fileName;
                }
            }
        }

        $user->name = $request->name;
        $user->bio = $request->bio;
        
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Profil berhasil diperbarui',
            'user' => $user
        ]);
    }
}
