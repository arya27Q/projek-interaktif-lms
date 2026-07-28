<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{

    public function register(Request $request) {
        $request->validate([
            'name'=>'required|string|max:255',
            'email'=>'required|email|unique:users,email',
            'password'=>['required','confirmed',Password::min(8)->symbols()],
        ], [
            'password.min' => 'Kata sandi kekpendekan bro! Minimal 8 huruf/angka.',
            'password.symbols' => 'Kata sandinya harus ada simbolnya bro! (contoh: @, #, $, dll).',
            'password.confirmed' => 'Password yang kamu ketik ulang di bawah nggak sama sama yang di atas.',
            'email.unique' => 'Email ini udah pernah didaftarin. Pake email lain ya!',
            'email.required' => 'Emailnya jangan dikosongin dong.',
            'name.required' => 'Namanya wajib diisi bro.'
        ]);

        $user = User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
        ]);

        Auth::login($user); 

        return response()->json([
            'success' => true,
            'message' => 'Welcome to our LMS ,register berhasil'
        ]);
    }
    
    public function login(Request $request) {
        $request->validate([
            'email'=>'required|email',
            'password'=>'required',
        ], [
            'email.required' => 'Woy emailnya jangan kosong!',
            'email.email' => 'Format emailnya salah bro.',
            'password.required' => 'Passwordnya wajib diisi ya.'
        ]);

        $credentials = $request->only('email','password');
        
        if(Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return response()->json([
                'message'=>'login success',
                'success'=>true,
            ]);
        }
        
        return response()->json([
            'success'=>false,
            'message'=>'Invalid Credentials (email or password is not found)',],401);
    }

    public function logout(Request $request)
    {
        Auth::logout(); 
        $request->session()->invalidate(); 
        $request->session()->regenerateToken(); 

        return response()->json([
            'message'=>'Successfully logged out',
            
        ]);
    }
}
