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
        <form method="post" action="{{ route('authLogin') }}">
            @csrf
            @method('POST')
            <div class="txt_field">
                <input type="email" name="email" value="{{ old('email') }}"
                    @error('email') placeholder="{{ $message }}"@enderror autofocus>
                <span></span>
                <label>Email</label>
            </div>
            <div class="txt_field">
                <input type="password" name="password" value="{{ old('password') }}"
                    @error('password') placeholder="{{ $message }}"@enderror>
                <span></span>
                <label>Password</label>
            </div>
            <div class="pass">Forgot Password?</div>
            <input type="submit" value="Login">
        </form>
    </div>

    {{-- SweetAlert --}}
    <script src="{{ asset('assets/extensions/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('assets/extensions/sweetalert2/sweetalert2.js') }}"></script>

    {{-- Error Login --}}
    @session('error')
        <script>
            Swal.fire({
                icon: "error",
                title: "Gagal Login",
                text: "Email dan password yang anda masukan tidak sesuai!",
                footer: 'Silahkan Login kembali'
            });
        </script>
    @endsession
</body>

</html>
