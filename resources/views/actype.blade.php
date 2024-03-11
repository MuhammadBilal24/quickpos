<title>Account Type - QuickPos</title>
@include('layout.header')
<link rel="stylesheet" href="{{ asset('assets2/bundles/datatables/datatables.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets2/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets2/css/components.css') }}">
<style>
    .input1{
        border:1px solid black;
    }
</style>
<!-- partial -->
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="">Account Type 
                            <div class="d-flex d-grid justify-content-end" style="margin-top:-25px;">
                                <button type="button" id="modalbtn" style="color:white;"
                                    class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal">Add Account-Type</button>
                            </div>
                        </h4>
                        <div class="table-responsive">
                            <table class="table table-hover" id="tableExport" style="width:100%;">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Account Type</th>
                                        {{-- <th>Actions</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($actypeData as $value)
                                        <tr>
                                            <td>{{ $value->id }}</td>
                                            <td>{{ $value->actype }}</td>
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
                    <h5 class="modal-title" id="exampleModalLabel">Add New Account-Type</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="form-group" id="actype_form">
                        @csrf
                        <label for="">Account Type</label>
                        <input type="text" class="form-control" style="border:1px solid black;" name="actype"
                            id="actype">
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" style="color:white"
                                id="savebtn">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Modal End -->

<script>
    $(document).ready(function()
    {
        $('#actype_form').submit(function(e){
            e.preventDefault();
            var form = $(this).serialize();
            $.ajax({
                url:'/insert/accountType',
                method:'post',
                data:form,
                dataType:'json',
                success: function(res)
                {
                    // console.log(res);
                    if(res)
                    {
                        swal({
                            icon:'success',
                            title:'Added',
                            text:'Account Type Added',
                            timer:1500,
                        }).then(()=>{
                            location.reload();
                        })
                    }
                    else
                    {
                        swal({
                            title:'Try Again',
                        });
                    }
                }
            })
        })
    })
    </script>       
