@extends('layout.app')
@section('title', 'Profile')

@section('content')
    <div class="container">
        <div class="row my-5">
            <div class="col-lg-12">
                <div class="card shadow">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4>Profile</h4>
                        <a href="{{ route('dashboard') }}" class="btn btn-dark">Dashboard</a>
                    </div>
                    <div class="card-body py-5">
                        <div id="profile_alert"></div>
                        <div class="row">
                            <div class="col-lg-4 px-5 text-center" style="border-right: 1px solid black">
                                @if ($userInfo->picture)
                                    <img src="storage/imgs/{{ $userInfo->picture }}" id="image_preview"
                                        class="image-fluid rounded-circle img-thumbnail" width=200>
                                @else
                                    <img src="{{ asset('imgs/userlogo.png') }}" id="image_preview"
                                        class="image-fluid rounded-circle img-thumbnail" width=200>
                                @endif
                                <div>
                                    <label for="Picture">Choose a Profile Picture</label>
                                    <input type="file" id="picture" name="picture" class="form-control rounded-pill">
                                </div>
                            </div>
                            <input type="hidden" name="user_id" id="user_id" value="{{ $userInfo->id }}">
                            <div class="col-lg-8 px-5">
                                <form action="" method="" id="profile_form">
                                    @csrf
                                    <input type="hidden" name="user_id" id="user_id" value="{{ $userInfo->id }}">
                                    <div class="my-2">
                                        <label for="">Full Name</label>
                                        <input type="text" name="name" id="name" class="form-control rounded-0"
                                            value="{{ $userInfo->name }}">
                                    </div>
                                    <div class="my-2">
                                        <label for="">E-Mail</label>
                                        <input type="email" name="email" id="email" class="form-control rounded-0"
                                            value="{{ $userInfo->email }}">
                                    </div>
                                    <div class="row">
                                        <div class="col-lg">
                                            <label for="">Gender</label>
                                            <select name="gender" id="gender" class="form-select rounded-0">
                                                <option value="" selected disabled>Select</option>
                                                <option value="Male" {{ $userInfo->gender == 'Male' ? 'Selected' : '' }}>
                                                    Male</option>
                                                <option value="Female"
                                                    {{ $userInfo->gender == 'Female' ? 'Selected' : '' }}>Female</option>
                                            </select>
                                        </div>
                                        <div class="col-lg">
                                            <label for="dob">Date of Birth</label>
                                            <input type="date" id="dob" name="dob" value="{{ $userInfo->dob }}"
                                                class="form-control rounded-0">
                                        </div>
                                    </div>
                                    <div class="row my-2">
                                        <div class="col-lg">
                                            <label for="dob">Phone</label>
                                            <input type="text" id="phone" name="phone" value="{{ $userInfo->phone }}"
                                            class="form-control rounded-0">
                                        </div>
                                        <div class="col-lg">
                                            <label for="">User-Type</label>
                                            <select name="user_type" id="user_type" class="form-select rounded-0 btn btn-dark" disabled>
                                                <option value="" selected disabled >Select Your Status</option>
                                                <option value="1" {{ $userInfo->user_type == '1' ? 'Selected' : '' }}>Master Admin</option>
                                                <option value="2" {{ $userInfo->user_type == '2' ? 'Selected' : '' }}>Manager</option>
                                                <option value="3" {{ $userInfo->user_type == '3' ? 'Selected' : '' }}>Employee</option>
                                            </select>
                                            <label for="" class="d-flex justify-content-end text-danger">Unable to change </label>
                                        </div>
                                    </div>
                                    <div class="" style="margin-top:10px" >
                                        <div class="d-flex d-grid justify-content-end ">
                                            <a href="/dashboard"><button type="button" class="rounded-0 float-end btn btn-secondary">Back</button></a> &nbsp;
                                            <input type="submit" value="Update Profile" class="btn btn-success rounded-0 float-end" id="profile_btn">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(function() {
            // Profile Image Update Ajax 
            $('#picture').change(function(e) {
                const file = e.target.files[0];
                let url = window.URL.createObjectURL(file);
                $('#image_preview').attr('src', url);
                let fd = new FormData();
                fd.append('picture', file);
                fd.append('user_id', $("#user_id").val());
                fd.append('_token', '{{ csrf_token() }}')
                $.ajax({
                    url: '{{ route('profile.image') }}',
                    method: 'post',
                    data: fd,
                    cache: false,
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    success: function(res) {
                        if (res.status == 200) {
                            const successMessage = showMessage('success', res.messages);
                            $('#profile_alert').html(successMessage);
                            setTimeout(() => {
                                $('#profile_alert')
                                    .empty();
                            }, 2000);
                            // $('#profile_alert').html(showMessage('success', res.messages));
                            $('#picture').val();
                        }
                    }

                })
            });
            // End Profile Image Update Ajax 

            // Profile Details Update
            $('#profile_form').submit(function(e) {
                e.preventDefault();
                let eid = $('#user_id').val();
                $('#profile_btn').val("Updating...")
                $.ajax({
                    url: '{{ route('profile.update') }}',
                    method: 'POST',
                    data: $(this).serialize() + `&id=${eid}`,
                    dataType: 'json',
                    success: function(res) {
                        if (res.status == 200) {
                            const successMessage = showMessage('success', res.messages);
                            $('#profile_alert').html(successMessage);
                            setTimeout(() => {
                                $('#profile_alert')
                            .empty();
                            }, 1000);
                            // $('#profile_alert').html(showMessage('success',res.messages));
                            $('#profile_btn').val("Update Profile")
                        }
                    }
                })
            })
            // End Profile Details Update            
        });
    </script>
@endsection
