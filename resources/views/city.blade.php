<title>Cities - QuickPos</title>
@include('layout.header')
<link rel="stylesheet" href="{{ asset('assets2/bundles/datatables/datatables.min.css') }}">
<link rel="stylesheet"
    href="{{ asset('assets2/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets2/css/components.css') }}">

<style>
    .input1 {
        border: 1px solid black;
    }
</style>
<!-- partial -->
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="">Cities
                            <div class=" d-flex justify-content-end " style="margin-top:-25px;">
                                <button type="button" class="btn btn-primary btn-sm text-light" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal">
                                    Add New City</button>
                            </div>
                        </h4>
                        <div class="table-responsive">
                            <table class="table table-hover text-center" id="tableExport" style="width:100%;">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Cities</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($cityData as $value)
                                        <tr>
                                            <td>{{ $value->id }}</td>
                                            <td>{{ $value->city }}</td>
                                            <td><button type="button" data-id="{{ $value->id }}"
                                                    class="btn btn-danger btn-sm deletebtn">
                                                    <i class="mdi mdi-delete-forever text-light"></i></button></td>
                                        </tr>
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

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">New City</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" class="form-group" id="city_form">
                        @csrf
                        <label for="">City Name</label>
                        <input type="text" id="city" name="city" class="form-control input1" required>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary text-light">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // City Insert
        $(document).ready(function() {
            $('#city_form').submit(function(e) {
                e.preventDefault();
                $.ajax({
                    url: '/city/insert',
                    method: 'post',
                    data: $(this).serialize(),
                    dataType: 'json',
                    success: function(res) {
                        if (res) {
                            swal({
                                icon: 'success',
                                title: 'Added',
                                text: 'New City Added',
                                timer: 1500,
                            })
                            location.reload();
                        } else {
                            swal({
                                title: 'Try Again',
                            })
                        }
                    }
                })
            })

            // Delete City
            $('.deletebtn').click(function() {
                var id = $(this).data('id');
                swal({
                    title: 'Are you want to Delete this City ?',
                    text: "It will Permenantly Deleted",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            url: '/city-delete/' + id,
                            method: 'post',
                            data: {
                                id: id,
                                _token: '{{ csrf_token() }}'
                            },
                            dataType: 'json',
                            success: function(res) {
                                if (res.status == 200) {
                                    swal({
                                        icon: 'success',
                                        title:'Deleted',
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
            })
        })
    </script>
