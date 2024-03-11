<title>User Details - QuickPos</title>
@include('layout.header')

<!-- partial -->
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4>User Details</h4><br>
                        <div class="row">
                            <div class="col-lg-8" style="border-right:1px solid black">
                                <h6>
                                    @if ($userDetailsData->user_type == 2)
                                        <div class="alert alert-primary">Manager Account</div>
                                    @elseif($userDetailsData->user_type == 3)
                                        <div class="alert alert-warning">Employee Account</div>
                                    @endif
                                </h6>
                                <form action="" class="form-group">
                                     <h6 style="color:#9d202d;">This content is not editable.</h6>
                                    <div class="row">
                                        <div class="col-lg">
                                            <label for="name">Name</label>
                                            <input disabled class="form-control" type="text" name=""
                                                id="" value="{{ $userDetailsData->name }}">
                                        </div>
                                        <div class="col-lg">
                                            <label for="">Email</label>
                                            <input disabled class="form-control" type="text" name=""
                                                id="" value="{{ $userDetailsData->email }}">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg">
                                            <label for="">Gender</label>
                                            <input disabled class="form-control" type="text" name=""
                                                id="" value="{{ $userDetailsData->gender }}">
                                        </div>
                                        <div class="col-lg">
                                            <label for="">Date of Birth</label>
                                            <input disabled class="form-control" type="text" name=""
                                                id="" value="{{ $userDetailsData->dob }}">
                                        </div>
                                    </div>
                                    <label for="">Phone</label>
                                    <input type="text" disabled class="form-control"
                                        value="{{ $userDetailsData->phone }}"><br>

                                    <div class="row">
                                        <div class="col-lg">
                                            <a href="/users"><button type="button"
                                                    class="btn btn-secondary">Back</button></a>
                                        </div>
                                        <div class="col-lg-6 d-flex justify-content-end">
                                            {{-- This condtion hide delete button of active user --}}
                                            @if ($LogginUser->id != $userDetailsData->id)
                                                <button class="btn btn-danger user-delete-Id-class"
                                                    data-id="{{ $userDetailsData->id }}" style="color:white">Delete
                                                    Account</button>
                                            @endif
                                            {{-- <a href="/users"><button type="button" class="btn btn-secondary">Back</button></a> --}}
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-lg-4 text-center rounded-0">
                                @if ($userDetailsData->picture)
                                    <img src="{{ asset('storage/imgs/' . $userDetailsData->picture . '') }}" alt="image"
                                        width="300px" />
                                @else
                                    <img src="{{ asset('storage/imgs/1709199356.png') }}" alt="image"
                                        width="300px" />
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- content-wrapper ends -->
    @include('layout.footer')

    <script>
        $(document).ready(function() {
            $('.user-delete-Id-class').click(function(e) {
                e.preventDefault();
                var id = $(this).data('id');
                // alert($eid);
                swal({
                    title: 'Are you want to Delete this User ?',
                    text: "It will gone forever",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            url: '/users-delete/' + id,
                            method: 'post',
                            data: {
                                id: id,
                                _token: '{{ csrf_token() }}'
                            },
                            dataType: 'json',
                            success: function(res) {
                                if (res.status == 200) {
                                    swal({
                                        icon: "success",
                                        text: "User has been deleted!",
                                    })
                                    window.location.href = '/users';
                                }
                            }
                        })
                    }
                })
            });
        })
    </script>
