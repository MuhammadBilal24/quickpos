<title>Users - QuickPos</title>
@include('layout.header')
<link rel="stylesheet" href="{{ asset('assets2/bundles/datatables/datatables.min.css') }}">
<link rel="stylesheet"
    href="{{ asset('assets2/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets2/css/components.css') }}">

<!-- partial -->
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="">Users
                            <div class="float-right" id="users-alert"></div>
                        </h4>
                        <div class="table-responsive">
                            <table class="table table-hover text-center" id="tableExport" style="width:100%;">
                                <thead style="background: rgb(221, 221, 221)">
                                    <tr>
                                        <th>ID</th>
                                        <th></th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($usersData as $value)
                                        @if($value->user_type != 1) <!-- skin master User data-->
                                            <tr>
                                                <td>{{ $value->id }}</td>
                                                <td class="py-1">
                                                    @if ($value->picture)
                                                        <img src="storage/imgs/{{ $value->picture }}" alt="image" />
                                                    @else
                                                        <img src="storage/imgs/1709199356.png" alt="image" />
                                                    @endif
                                                </td>
                                                <td>{{ $value->name }}</td>
                                                <td>{{ $value->email }}</td>
                                                <td>
                                                    {{-- <a href="/users-delete/{{ $value->id }}"></a> --}}
                                                    @if ($LogginUser->id != $value->id)
                                                        <!-- this condition is hiding delete button of active user-->
                                                        <button type="button"
                                                            class="btn btn-danger btn-sm user-delete-Id-class"
                                                            data-id="{{ $value->id }}">
                                                            <i class="mdi mdi-delete-forever" style="color:white"></i>
                                                        </button>
                                                        <a href="/user-details/{{ $value->id }}"
                                                            class="btn btn-primary btn-sm">
                                                            <i class="mdi mdi-file-document-box" style="color:white;"></i></a>
                                                    @else
                                                        <h6 class="btn btn-success" style="color:white">Active</h6>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
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
                                        timer:1500,
                                    }).then(()=>{
                                        location.reload();
                                    })
                                }
                            }
                        })
                    }
                })
            });
        })
    </script>
