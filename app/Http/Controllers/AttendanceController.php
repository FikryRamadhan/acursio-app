<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\MyClass\Response;
use App\MyClass\Validations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AttendanceController extends Controller
{
    /**
     * Menampilkan data absen semua user.
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            return Attendance::DataTable();
        }

        return view('.index',[
            'title' => 'Absen',
            'description' => 'Ini adalah page untuk mengelola data absen',
            'breadcrumbs' => [
                'title' => 'Absen',
                'url' => route('attendance.index')
            ]
        ]);
    }

    /**
     * Menampilkan data absen sesuai user login
     */

    public function indexUser(Request $request){
        if($request->ajax()){
            $userId = auth()->id();
            return Attendance::DataTable($userId);
        }

        return view('attendance.index',[
            'title' => 'Absen',
            'description' => 'Ini adalah page untuk mengelola data absen',
            'breadcrumbs' => [
                'title' => 'Absen',
                'url' => route('attendance.index')
            ]
        ]);
    }

    // Check-in
    public function checkIn(Request $request)
    {
        DB::beginTransaction();
        try {
            $attendance = Attendance::checkIn(Auth::user()->id);
            DB::commit();

            if($attendance->wasRecentlyCreated) {
                return Response::success([
                    'message' => 'Berhasil Check In, Selamat Bekerja!',
                    'attendance' => $attendance,
                ]);
            }else{
                return Response::invalid(['message' => 'Anda sudah Login!']);
            }
        } catch (\Throwable $e) {
            DB::rollBack();

            return Response::error($e);
        }
    }

    // check-out
    public function checkOut(Request $request)
    {
        Validations::attendance($request);

        DB::beginTransaction();
        try {
            $attendance = Attendance::checkOut($request->attendance_id);
            DB::commit();

            if(isset($attendance['error'])) {
                return Response::invalid([
                    'message' => 'Maaf, anda sedang tidak Check In!',
                ]);
            }

            return Response::success([
                'message' => 'Berhasil Check Out, Terimakasih atas kerja kerasnya!',
                'attendance' => $attendance
            ]);

        } catch (\Throwable $e) {
            DB::rollBack();

            return Response::error($e);
        }
    }

    // pause
    public function pause(Request $request)
    {

        Validations::attendance($request);

        DB::beginTransaction();
        try {
            $result = Attendance::pause($request->attendance_id);

            if(isset($result['error'])) {
                DB::rollBack();
                return Response::invalid([
                        'message' => 'Anda sedang tidak login atau sudah terpause',
                ]);
            }

            DB::commit();

            return Response::save([
                'message' => 'Berhasil Pause, jangan lupa balik lagi yaaa!',
                'attendance' => $result
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // resume
    public function resume(Request $request)
    {
        Validations::attendance($request);

        DB::beginTransaction();
        try {
            $att = Attendance::resumeAtt($request->attendance_id);

            if(isset($att['error'])) {
                return Response::invalid([
                    'message' => 'Anda sedang tidak mengPause!'
                ]);
            }

            DB::commit();

            return Response::success([
                'message' => 'Berhasil melanjutkan, semangat!',
                'resume' => $att
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Attendance $attendance)
    {
        //
    }
}
