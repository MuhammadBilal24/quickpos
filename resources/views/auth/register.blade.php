@extends('layout.app')
@section('title', 'Register')

@section('content')
<div class="container-fluid">
    <div class="row d-flex justify-content-center align-items-center min-vh-100">
        <div class="col-lg-4">
            <div class="card shadow">
                <div class="card-header">
                    <h4>Register</h4>
                </div>
                <div class="card-body p-5">
                    <div id="show_success_alert"></div>
                    <form id="register_form">
                        @csrf
                        <div class="mb-3">
                            <input type="text" class="form-control rounded-0" id="name" name="name" placeholder="Full Name">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="mb-3">
                            <input type="email" class="form-control rounded-0" id="email" name="email" placeholder="E-mail">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="mb-3">
                            <input type="password" class="form-control rounded-0" id="password" name="password" placeholder="Password">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="mb-3">
                            <input type="password" class="form-control rounded-0" id="cpassword" name="cpassword" placeholder="Confirm Password">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="mb-3">
                            <select class="form-control rounded-0" id="user_type" name="user_type">
                                <option value="" selected disabled class="text-muted">Select your status</option>
                                {{-- <option value="1" {{ $userInfo->user_type == '1' ? 'Selected' : '' }}>MasterAdmin</option> --}}
                                <option value="2">Manager</option>
                                <option value="3">Employee</option>
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="mb-3 d-grid">
                            <input type="submit" value="Register" class="btn btn-dark rounded-0"
                             id="register_btn">
                        </div>
                        <div class="text-center text-secondary">
                            <div>Already Have an Account <a href="/" class="text-decoration-none">Login Here</a></div>
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
        $(function(){
            $("#register_form").submit(function(e){
                e.preventDefault();
                // alert('ok');
                $('#register_btn').val('Please Wait...');
                $.ajax({
                    url:'{{ route('auth.register')}}',
                    method:'POST',
                    data: $(this).serialize(),
                    dataType: 'json',
                    success: function(res)
                    {
                        if(res.status == 400)
                        {
                            showError('name', res.messages.name);
                            showError('email',res.messages.email);
                            showError('password',res.messages.password);
                            showError('cpassword',res.messages.cpassword);
                            showError('user_type',res.messages.user_type);
                            $('#register_btn').val('Register');
                        }
                        else if(res.status == 200)
                        {
                            const successMessage = showMessage('success', res.messages);
                            $('#show_success_alert').html(successMessage);
                            setTimeout(() => {
                                $('#show_success_alert').empty();
                            }, 2000);
                            // $('#show_success_alert').html(showMessage('success',res.messages));
                            $('#register_form')[0].reset();
                            removeValidationClasses("#register_form");
                            $('#register_btn').val('Register');
                        }
                    }
                })
            });
        })
    </script>
@endsection
    