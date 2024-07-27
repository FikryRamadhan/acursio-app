<!DOCTYPE html>
<!-- Coding By CodingNepal - youtube.com/codingnepal -->
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <title>Animated Login Form | CodingNepal</title>

    {{-- My Css --}}
    <link rel="stylesheet" href="{{ asset('css/login/style.css') }}">

    {{-- SweetAlert --}}
    <link rel="stylesheet" href="{{ asset('assets/extensions/sweetalert2/sweetalert2.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/extensions/sweetalert2/sweetalert2.min.css') }}">
</head>

<body>
    <div class="center">
        <h1>Login</h1>
        <form method="post" id="loginForm">
            @csrf
            @method('POST')
            <div class="txt_field">
                <input type="email" name="email" value="{{ old('email') }}" id="email" autofocus>
                <span></span>
                <label>Email</label>
            </div>
            <div class="txt_field">
                <input type="password" name="password" value="{{ old('password') }}" id="password">
                <span></span>
                <label>Password</label>
            </div>
            <div class="pass">Forgot Password?</div>
            <input type="submit" value="Login">
        </form>
    </div>

    {{-- Jquery --}}
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>

    {{-- SweetAlert --}}
    <script src="{{ asset('assets/extensions/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('assets/extensions/sweetalert2/sweetalert2.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('#loginForm').on('submit', function(e) {
                e.preventDefault();

                $.ajax({
                    url: '{{ url('/authLogin') }}',
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        if (response.status === 'success') {
                            Swal.fire({
                                title: 'Success!',
                                text: response.message,
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then(function() {
                                window.location.href =
                                    '/dashboard'; // Redirect setelah sukses
                            });
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            var errors = xhr.responseJSON.errors;
                            var errorMessages = '';
                            $.each(errors, function(key, value) {
                                errorMessages += value[0] + '<br>';
                            });

                            Swal.fire({
                                title: 'Tidak boleh ada yang kosong!',
                                html: errorMessages,
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        } else if (xhr.status === 401) {
                            Swal.fire({
                                title: 'Login Gagal!',
                                text: xhr.responseJSON.message,
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        } else {
                            Swal.fire({
                                title: 'Error!',
                                text: 'An unexpected error occurred.',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    }
                });
            });
        });
    </script>

</body>

</html>
