<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function index()
    {
        return response()->view('login.index');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'required' => ':attribute wajib diisi!',
            'email' => 'Email wajib berupa email!'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422); // Status code 422 untuk validasi error
        }

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return response()->json([
                'status' => 'success',
                'message' => 'Login berhasil'
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Email dan password yang anda masukan tidak sesuai!'
            ], 401);
        }
    }
}
