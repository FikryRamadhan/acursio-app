<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $guarded = ['id'];

    /**
     * Function For Crud
     */
    public static function createUser($request)
    {
        $data = self::create($request);
        return $data;
    }

    public function updateUser($request){
        return $this->update($request);
    }

    public function deleteUser()
    {
        return $this->delete();
    }

    /**
     *function For DataTable
     */
    public static function DataTable($request)
    {
        $data = self::select(['users.*']);

        return \DataTables::eloquent($data)
            ->addColumn('action', function ($data) {
                $action = '
                <div class="dropdown">
                    <button
                    class="btn btn-primary dropdown-toggle me-1"
                    type="button"
                    id="dropdownMenuButtonIcon"
                    data-bs-toggle="dropdown"
                    aria-haspopup="true"
                    aria-expanded="false"
                    >
                    <i class="bi bi-error-circle me-50"></i> Icon Left
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonIcon">
                    <a class="dropdown-item edit" data-get-href="'. route('user.get', $data->id) .'" data-update-href="'. route('user.update', $data->id).'"><i class="bi bi-pencil-square me-50"></i> Edit</a>
                    <a class="dropdown-item delete" data-delete-message="Yakin Ingin Menghapus Data '. $data->name.'" data-delete-href="'. route('user.destroy', $data->id). '"><i class="bi bi-trash3 me-50"></i> Delete</a>
                    </div>
                </div>

                ';
                return $action;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
