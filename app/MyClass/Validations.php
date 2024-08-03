<?php

namespace App\MyClass;

use App\Rules\CheckPassword;
use Illuminate\Http\Request;

class Validations
{
    public static function createUser($request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:8'],
            'phone' => ['required'],
            'role' => ['required'],
            'status' => ['required']
        ],[
            'name.required' => 'Nama Wajib Diisi',
            'email.required' => 'Email Wajib Diisi',
            'password.required' => 'Password Wajib Diisi',
            'phone.required' => 'No Hp Wajib Diisi',
            'role.required' => 'Role Wajib Diisi',
            'status.required' => 'Status Wajib Diisi',
        ]);
    }

    public static function updateUser($request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'phone' => ['required'],
            'role' => ['required'],
            'status' => ['required']
        ],[
            'name.required' => 'Nama Wajib Diisi',
            'email.required' => 'Email Wajib Diisi',
            'phone.required' => 'No Hp Wajib Diisi',
            'role.required' => 'Role Wajib Diisi',
            'status.required' => 'Status Wajib Diisi',
        ]);
    }

    public static function loginValidate($request){
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required'
        ]);
    }

    public static function setProfile($request){
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required'
        ]);
    }

    public static function setPassword($request, $userId){
        $request->validate([
			'old_password' => ['required', new CheckPassword($userId)],
			'password' => 'required',
			'confirm_password' => 'required|same:password',
		], [
			'old_password.required' => 'Password lama wajib diisi',
			'password.required' => 'Password baru wajib diisi',
			'confirm_password.required' => 'Wajib diisi',
			'confirm_password.same' => 'Password baru yang dimasukkan tidak sama',
		]);
    }

    public static function attendance(Request $request){
        $request->validate([
            'attendance_id' => 'required|exists:attendances,id',
        ], [
            'required' => 'Anda belum check in',
            'exists' => 'Tidak ada absen yang sesuai'
        ]);
    }
}
