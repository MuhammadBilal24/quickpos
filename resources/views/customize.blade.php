<title>Customize - QuickPos</title>
@include('layout.header')
<style>
    .input1 {
        border: 1px solid black;
    }
</style>
<!-- partial -->

<div class="main-panel">
    <?php $data = DB::table('users')->where('id', session('loggedInUser'))->first(); ?>
    @if ($data->user_type == 1)
        <div class="content-wrapper">
            <div class="row">
                <div class="col-lg-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="">Customization
                                <p class="text-danger">Changes apply on Managers and Employees Dashboard.</p>
                                <div class=" d-flex justify-content-end ">
                                    <button type="button" class="btn btn-primary btn-sm text-light" style="margin-top:-10px;"
                                        data-bs-toggle="modal" data-bs-target="#exampleModal">
                                        Add Function</button>
                                </div>
                            </h4>
                            <div class="table-responsive">
                                <table class="table table-hover" id="table" style="width:100%;">
                                    <thead style="background: rgb(221, 221, 221)">
                                        <tr>
                                            {{-- <th>#</th> --}}
                                            <th>Title</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($customizeData as $value)
                                            <tr>
                                                {{-- <td>{{ $value->id }}</td> --}}
                                                <td class="text-dark"><strong>{{ $value->title }}</strong></td>
                                                <td class="text-center">
                                                    @if ($value->value)
                                                        <span class="badge bg-info">Show</span>
                                                    @else
                                                        <span class="badge bg-danger">Hide</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    <button data-id="{{ $value->id }}" id="editbtn"
                                                        data-bs-toggle="modal" data-bs-target="#exampleModal2"
                                                        class="btn btn-success text-light btn-sm editbtn"><i
                                                            class="mdi mdi-grease-pencil"></i>
                                                    </button>
                                                </td>
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
    @else
        <div class="alert alert-danger">This Page is Blocked For Managers and Employees.</div>
    @endif

    @include('layout.footer')

    <!-- Add Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">Add New Funtion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" class="form-group" id="customize_form">
                        @csrf
                        <label for="">Title</label>
                        <input type="text" id="title" name="title" class="form-control input1" required><br>
                        <label for="" class="">Status</label>
                        <div class="form-switch">
                            <input class="form-check-input" name="value" type="checkbox" data-bs-toggle="toggle"
                                data-on="1" data-off="0" data-on-style="success" data-off-style="danger"
                                id="valuecheck" value="0" />
                            <input type="text" name="" id="value" value="0" hidden>
                            <label for=""> Hide / Show</label>
                        </div>
                        <br>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary text-light" id="savebtn">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- Edit Modal --}}
    <div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Function</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="/update/customize" method="post" class="form-group" id="customize_Editform">
                        @csrf
                        <input type="text" name="id" id="cid" hidden>
                        <label for="">Title</label>
                        <input type="text" id="titleEdit" name="title" class="form-control input1"
                            readonly><br>
                        <label for="value">Status</label>
                        <div class="form-switch">
                            <input class="form-check-input" name="value" type="checkbox" data-bs-toggle="toggle"
                                data-on="1" data-off="0" data-on-style="success" data-off-style="danger"
                                id="valueEdit" value="" />
                            <input type="text" name="value" id="value2" value="" hidden>
                            <label for=""> Hide / Show</label>
                        </div>
                        <br>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success text-light" id="updatebtn">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            if ($('#valuecheck').prop('checked')) {
                $('#value').val('1');
                $('#valuecheck').val('1');
            } else {
                $('#value').val('0');
                // $('#valuecheck').val('0');
            }
            $('#valuecheck').change(function() {
                if ($(this).prop('checked')) {
                    $('#value').val('1');
                    $('#valuecheck').val('1');
                } else {
                    $('#value').val('0');
                }
            })
        })
        // Insert
        $('#customize_form').submit(function(e) {
            e.preventDefault();
            $.ajax({
                url: 'customize/Insert',
                method: 'post',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(res) {
                    if (res) {
                        swal({
                            icon: 'success',
                            title: 'Added',
                            timer: 1000,
                        }).then(() => {
                            location.reload();
                        })
                    } else {
                        swal({
                            title: 'Try Again',
                        }).then(() => {
                            location.reload();
                        })
                    }
                }
            })
        })
        // Edit modal get Data 
        $(document).on('click', '.editbtn', function() {
            var id = $(this).data('id');
            $.get('customize/Edit/' + id, function(res) {
                $('#cid').val(res.id);
                $('#titleEdit').val(res.title);
                $('#valueEdit').val(res.value);
                if (res.value == 1) {
                    $('#value2').val('1');
                    $('#valueEdit').val('1');
                    $('#valueEdit').prop('checked', $('#valueEdit').val() == 1).change();
                } else {
                    $('#value2').val('0');
                    $('#valueEdit').show();
                    $('#valueEdit').prop('', $('#valueEdit').val() == 0).change();
                }
            });
            $('#valueEdit').change(function() {
                if ($(this).prop('checked')) {
                    $('#value2').val('1');
                    $('#valueEdit').val('1');
                } else {
                    $('#value2').val('0');
                }
            })
        })
        // Update Customize Modal
        $('#updatebtn').click(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var id = $('#cid').val();
            var titleEdit = $('#titleEdit').val();
            var valueEdit = $('#valueEdit').val();
            $.ajax({
                type: "post",
                url: "{{ route('customize.update') }}",
                data: {
                    id: id,
                    titleEdit: titleEdit,
                    valueEdit: valueEdit,
                },
                success: function(response) {
                    console.log(response);
                }
            });
        })
    </script>
