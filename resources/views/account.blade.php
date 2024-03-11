<title>Accounts - QuickPos</title>
@include('layout.header')
<link rel="stylesheet" href="{{ asset('assets2/bundles/datatables/datatables.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets2/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets2/css/components.css') }}">
<style>
    .input1{
        border: 0.1px solid rgb(138, 138, 138);
    }
</style>
<!-- partial -->
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="">Accounts
                            <div class="d-flex d-grid justify-content-end" style="margin-top:-25px;">
                                <button type="button" id="modalbtn" style="color:white;"
                                    class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal" onclick="setNow()">Add Account</i>
                                </button>
                            </div>
                        </h4>
                        <div class="table-responsive">
                            <table class="table table-hover" id="tableExport" style="width:100%;">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Date</th>
                                        <th>Ac-Name</th>
                                        <th class=" text-center">Ac-Type</th>
                                        <th class=" text-center">Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($accountData as $value)
                                        <tr>
                                            <td>{{ $value->id }}</td>
                                            <td>{{ $value->date }}</td>
                                            <td class="">{{ $value->acname }}</td>
                                            <td class=" text-center">
                                                <div class="badge bg-secondary rounded">{{ $value->actype }}</div>
                                            </td>
                                            <td class=" text-center">
                                                @if ($value->status == 1 )
                                                    <div class="badge bg-success text-light rounded">Active</div>    
                                                @else
                                                    <div class="badge bg-danger text-light  rounded">Deactive</div>    
                                                @endif
                                            </td>
                                            <td><a href="/account-details/{{ $value->id }}"><button class="btn btn-primary"><i class="mdi mdi-file-document-box text-light"></i></button></a></td>
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
                    <h5 class="modal-title" id="exampleModalLabel">Add New Account</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="form-group" id="account_form">
                        @csrf
                        <label for="">Date<span class="text-success"> Auto Set</span></label>
                        <input type="text" id="datetimeInput" name="date" id="date" class="form-control input1" readonly>
                        <label for="">Account Name</label>
                        <input type="text" name="acname" id="acname" class="form-control input1" required>
                        <label for="">Ac-Type</label>
                        <select name="actype" id="actype" class="form-control" style="border:1px solid black" required>
                            <option value="" selected disabled>Select an Account Type</option>
                            @foreach ($actypeData as $value)
                            <option value="{{ $value->id }}">{{ $value->actype }}</option>
                            @endforeach
                        </select>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" style="color:white"
                                >Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Modal End -->

       
<script>
     function setNow() {
            var now = new Date();
            // Format date
            var dd = String(now.getDate()).padStart(2, '0');
            var mm = String(now.getMonth() + 1).padStart(2, '0'); // January is 0!
            var yyyy = now.getFullYear();
            var date = yyyy + '-' + mm + '-' + dd;
            // Format time
            var hours = String(now.getHours()).padStart(2, '0');
            var minutes = String(now.getMinutes()).padStart(2, '0');
            var time = hours + ' : ' + minutes;
            // Combine date and time
            var datetime = date + ' Time ' + time;
            document.getElementById('datetimeInput').value = datetime;
        }
        $(document).ready(function(){
            $('#account_form').submit(function(e){
                e.preventDefault();
                $.ajax({
                    url:'/insert/account',
                    method:'post',
                    data:$(this).serialize(),
                    dataType:'json',
                    success:function(res)
                    {
                        if(res.status==200)
                        {
                            swal({
                                icon:'success',
                                title:'Added',
                                text:'New Account Successfully Added',
                                timer:1000,
                            }).then(()=>{
                                location.reload();
                                $('#account_form').trigger();
                            })
                        }
                        else
                        {
                            swal({
                                icon:'error',
                                title:'Try Again',
                            }).then(()=>{
                                location.reload();
                            });
                        }
                    }
                })
            })
        })
</script>