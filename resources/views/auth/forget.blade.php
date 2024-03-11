@extends('layout.app')
@section('title', 'Forget Password')

@section('content')
<div class="container-fluid">
    <div class="row d-flex justify-content-center align-items-center min-vh-100">
        <div class="col-lg-4">
            <div class="card shadow">
                <div class="card-header">
                    <h4>Forget Password</h4>
                </div>
                <div class="card-body p-5">
                    <div id="forget_alert"></div>
                    <form  id="forget_form">
                        @csrf
                        <div class="mb-3 text-secondary">
                            Enter your e-mail address and we will send you a link to reset your password.
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control rounded-0" id="email" name="email" placeholder="E-mail">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="mb-3 d-grid">
                            <input type="submit" value="Reset Password" class="btn btn-dark rounded-0"
                             id="forget_btn">
                        </div>
                        <div class="text-center text-secondary">
                            <div>Back to <a href="/" class="text-decoration-none">Login</a></div>
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
            $('#forget_form').submit(function(e){
                e.preventDefault();
                $('#forget_btn').val("Please Wait...");
                $.ajax({
                    url:'{{ route('forget.password') }}',
                    method:'post',
                    data:$(this).serialize(),
                    dataType:'json',
                    success: function(res)
                    {
                        if(res.status == 400)
                        {
                            showError('email'. res.messages.email);
                            $('#forget_btn').val("Reset Password");
                        }
                        else if (res.status == 200)
                        {
                            $('#forget_alert').html(showMessage('success',res.messages));
                            removeValidationClasses('#forget_form');
                            $("#forget_btn").val("Reset Password")
                            $("#forget_form")[0].reset();
                        }
                        else
                        {
                            $('#forget_alert').html(showMessage('danger',res.messages));
                            $("#forget_btn").val("Reset Password")
                        }
                    }
                })
            })
        })
    </script>
@endsection
    