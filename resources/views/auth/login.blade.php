@extends('layout.app')
@section('title', 'Login')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
@section('content')
    <div class="container-fluid">
        <div class="row d-flex justify-content-center align-items-center min-vh-100">
            <div class="col-lg-4">
                <div class="card shadow">
                    <div class="card-header">
                        <h4>Login</h4>
                    </div>
                    <div class="card-body p-5">
                        <div id="login_alert"></div>
                        <form action="" method="post" id="login_form">
                            @csrf
                            <div class="mb-3">
                                <input type="email" class="form-control rounded-0" id="email" name="email"
                                    placeholder="E-mail">
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="mb-3">
                                <input type="password" id="myInput" class="form-control rounded-0" id="password"
                                    name="password" placeholder="Password">
                                <div class="invalid-feedback"></div>
                            </div>
                            <input type="checkbox" onclick="myFunction()"> Show Password
                            <div class="mb-3 d-flex justify-content-end">
                                <a href="/forget" class="text-decoration-none">Forget Password?</a>
                            </div>
                            <div class="mb-3 d-grid">
                                <input type="submit" value="Login" class="btn btn-dark rounded-0" id="login_btn">
                            </div>
                            <div class="text-center text-secondary">
                                <div>Don't Have an Account <a href="/register" class="text-decoration-none">Register Now</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('script')
    <script>
        $(function() {
            $('#login_form').submit(function(e) {
                e.preventDefault();
                $('#login_btn').val("Please Wait...");
                $.ajax({
                    url: '{{ route('auth.login') }}',
                    method: 'post',
                    data: $(this).serialize(),
                    dataType: 'json',
                    success: function(res) {
                        // console.log(res);
                        if (res.status == 400) {
                            showError('email', res.messages.email);
                            showError('password', res.messages.password);
                            $('#login_btn').val('Login');
                        } else if (res.status == 401) {
                            $('#login_alert').html(showMessage('danger', res.messages));
                            $('#login_btn').val('Login');
                        } else {
                            if (res.status == 200 && res.messages == 'success') {
                                window.location = '{{ route('dashboard') }}';
                            }
                        }
                    }
                })
            })
        })
        // show Password
        function myFunction() {
            var x = document.getElementById("myInput");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }
    </script>
@endsection
