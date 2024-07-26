<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return response()->view('login.index');
    }

    public function login(Request $request)
    {
        $validate = $request->validate([
            'email' => ['required'],
            'password' => ['required'],
        ]);

        if (!Auth::attempt($validate)) {
            return back()->with('error', 'Username dan password yang anda masukan tidak sesuai');
        }

        return redirect()->route('dashboard')->with('success', 'Berhasil login!');
    }
}
