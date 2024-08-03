<?php

namespace App\Models;

use App\MyClass\Response;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Attendance extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public static function checkIn($userId)
    {
        return self::firstOrCreate(
            ['user_id' => $userId, 'status' => 'ongoing'],
            ['date'=>today()->toDateString(),'check_in' => now()->toTimeString()]
        );
    }

    public static function pause($attendance_id) {
        $attendance = self::find($attendance_id);

        if ( $attendance->pause != null ) {
            return ['error' => 'error'];
        }

        $attendance->update([
            'pause' => now()->toTimeString(),
        ]);

        return $attendance;
    }

    public static function resumeAtt ($attendance_id) {
        $attendance = self::find($attendance_id);

        if (!$attendance) {
            return ['error' => 'Attendance record not found.'];
        }

        if (!$attendance->pause || $attendance->resume != null) {
            return ['error' => 'Attendance is not paused or already resumed.'];
        }

        $attendance->update([
            'resume' => now()->toTimeString(),
        ]);

        return $attendance;
    }

    public static function checkOut($attendance_id) {
        $attendance = self::find($attendance_id);

        if(!$attendance || $attendance->status === 'completed') {
            return ['error' => 'Gagal'];
        }

        $checkOutNow = now()->toTimeString();

        $checkIn = strtotime($attendance->check_in);
        $checkOut = strtotime($checkOutNow);

        $totalTime =  $checkOut - $checkIn;

        if($attendance->pause && $attendance->resume) {
            $pause = strtotime($attendance->pause);
            $resume = strtotime($attendance->resume);

            $rest = $resume - $pause;

            $totalTime = $totalTime - $rest;
        }

        $hours = floor($totalTime / 3600);
        $minutes = floor(($totalTime % 3600) / 60);
        $seconds = $totalTime % 60;

        $total = sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);

        $attendance->update([
            'check_out' => $checkOutNow,
            'status' => 'completed',
            'total' => $total
        ]);

        return $attendance;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function getDataTableQuery($userId = null)
    {
        $data = self::with('user');

        if ($userId) {
            $data->where('user_id', $userId);
        }

        return $data;
    }

    public static function DataTable($userId = null)
    {
        $data = self::getDataTableQuery($userId);

        return \DataTables::eloquent($data)
            ->addColumn('user_name', function($attendance) {
                return $attendance->user?$attendance->user->name:'Tidak ada user';
            })
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
                    <a class="dropdown-item delete" data-delete-message="Yakin Ingin Menghapus Data ' . $data->name . '" data-delete-href="' . route('attendance.destroy', $data->id) . '"><i class="bi bi-trash3 me-50"></i> Delete</a>
                    </div>
                </div>

                ';
                return $action;
            })
            ->rawColumns(['action'])
            ->make(true);
    }


}
