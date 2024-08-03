@extends('layouts.template')

@section('content')
<section class="row mt-2">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title d-flex flex-column align-items-center gap-3 d-md-block">
                    Absen {{ Auth::user()->name }}
                    <div class="float-end">
                        <a href=""class="btn btn-success btn-sm" id='checkIn'>Check In</a>
                        <a href=""class="btn btn-warning btn-sm" id="pause" data-id="">Pause</a>
                        <a href=""class="btn btn-primary btn-sm" id="resume" data-id="">Resum</a>
                        <a href=""class="btn btn-danger btn-sm" id="checkOut" data-id="">Check Out</a>
                    </div>
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="table1">
                        <thead>
                            <tr>
                                <th>name</th>
                                <th>date</th>
                                <th>check_in</th>
                                <th>check_out</th>
                                <th>pause</th>
                                <th>resume</th>
                                <th>total</th>
                                <th>aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>name</th>
                                <th>date</th>
                                <th>check_in</th>
                                <th>check_out</th>
                                <th>pause</th>
                                <th>resume</th>
                                <th>total</th>
                                <th>aksi</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

    </div>
</section>
@endsection

@section('script')

    <script>
        $(document).ready(function() {
            let table = $('#table1').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('attendance.index') }}',
                },
                columns: [
                    { data: 'user_name', name: 'user_name' },
                    { data: 'date', name: 'date' },
                    { data: 'check_in', name: 'check_in' },
                    { data: 'check_out', name: 'check_out' },
                    { data: 'pause', name: 'pause' },
                    { data: 'resume', name: 'resume' },
                    { data: 'total', name: 'total' },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ]
            });

            const storedAttendanceId = localStorage.getItem('attendanceId');
            if (storedAttendanceId) {
                $('#pause').data('id', storedAttendanceId).show();
                $('#resume').data('id', storedAttendanceId).show();
            }

            $('#checkIn').click(function() {
                event.preventDefault();
                confirmation(
                    'Yakin mau Check In Sekarang??',
                    () => {
                        $.ajax({
                            url: '{{ route('attendance.checkin') }}',
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                            },
                            success: function(response) {
                                $('#pause').data('id', response.attendance.id);
                                $('#resume').data('id', response.attendance.id);
                                $('#checkOut').data('id', response.attendance.id);
                                localStorage.setItem('attendanceId', response.attendance.id);
                                successNotification(response.message)
                                table.ajax.reload();
                            },
                            error: (error) => {
                                errorNotification(error.responseJSON.message)
                            }
                        })
                    },
                    () => {
                        successNotification('Baik')
                    }
                );
            })

            $('#pause').click(function() {
                event.preventDefault();

                confirmation(
                    'Apakah kamu yakin ingin mengPause jam kerja sekarang?',
                    () => {
                        const attendanceId = localStorage.getItem('attendanceId');
                        $.ajax({
                            url: '{{ route('attendance.pause') }}',
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                attendance_id: attendanceId
                            },
                            success: function(response) {
                                successNotification('Berhaisl Pause, jangan lupa login lagi yak!')
                                table.ajax.reload();
                            },
                            error: function(error) {
                                console.log(error);
                                errorNotification(error.responseJSON.message)
                            }
                        })
                    },
                    () => {

                    }
                )
            })

            $('#resume').click(() => {
                event.preventDefault()

                confirmation(
                    'Anda yakin akan melanjutkan lagi?',
                    () => {
                        const attendanceId = localStorage.getItem('attendanceId');

                        $.ajax({
                            url: '{{ route('attendance.resume') }}',
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                attendance_id: attendanceId
                            },
                            success: function(response) {
                                console.log(response);
                                successNotification(response.message)
                                table.ajax.reload();
                            },
                            error: function(error) {
                                console.log(error);
                                errorNotification(error.responseJSON.message)
                            }
                        })
                    },
                    () => {

                    }
                )
            })


            $('#checkOut').click(() => {
                event.preventDefault()

                confirmation(
                    'Sudah selesai jam ya?',
                    () => {
                        const attendanceId = localStorage.getItem('attendanceId');

                        $.ajax({
                            url: '{{ route('attendance.checkout') }}',
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                attendance_id: attendanceId,
                            },
                            success: function(response) {
                                console.log(response);
                                successNotification(response.message)
                                table.ajax.reload();
                            },
                            error: function(error) {
                                console.log(error);
                                errorNotification(error.responseJSON.message)
                            }
                        })
                    },
                    () => {

                    }
                )
            })

        });
    </script>
@endsection
