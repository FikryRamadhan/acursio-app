<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAttendancesRequest;
use App\Http\Requests\UpdateAttendancesRequest;
use App\Models\Attendance;
use Illuminate\Support\Facades\Auth;

class AttendancesController extends Controller
{
    // Check-in
    public function checkIn()
    {
        $attendance = Attendance::firstOrCreate(
            [
                'user_id' => Auth::id(),
                'date' => today()->toDateString(),
            ],
            [
                'check_in' => now()->toTimeString(),
            ]
        );

        return response()->json(['message' => 'Masuk berhasil, semangat kerjanya ya!', 'attendance' => $attendance]);
    }

    // check-out
    public function checkOut()
    {
        $attendance = Attendance::where('user_id', Auth::id())
            ->where('date', today()->toDateString())
            ->first();

        if ($attendance) {
            $attendance->update(['check_out' => now()->toTimeString()]);
            return response()->json(['message' => 'Keluar berhasil, terimakasih kerja kerasnya!', 'attendance' => $attendance]);
        }

        return response()->json(['message' => 'Attendance record not found'], 404);
    }

    // pause
    public function pause()
    {
        $attendance = Attendance::where('user_id', Auth::id())
            ->where('date', today()->toDateString())
            ->first();

        if ($attendance) {
            $attendance->update(['pause' => now()->toTimeString()]);
            return response()->json(['message' => 'Berhasil pause, ditunggu lanjutnya ya!', 'attendance' => $attendance]);
        }

        return response()->json(['message' => 'Attendance record not found'], 404);
    }

    // resume
    public function resume()
    {
        $attendance = Attendance::where('user_id', Auth::id())
            ->where('date', today()->toDateString())
            ->first();

        if ($attendance) {
            $attendance->update(['resume' => now()->toTimeString()]);
            return response()->json(['message' => 'Berhasil melanjutkan, semangat melanjutkan kerja ya!', 'attendance' => $attendance]);
        }

        return response()->json(['message' => 'Attendance record not found'], 404);
    }
}
