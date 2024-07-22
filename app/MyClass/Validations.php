<?php 

namespace App\MyClass;

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
}