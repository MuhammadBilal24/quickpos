<title>Category - QuickPos</title>
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
                        <h4 class="">Category
                            <div class=" d-flex justify-content-end"  style="margin-top:-25px;">
                                <button type="button" class="btn btn-primary btn-sm text-light" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal">
                                    Add New Category</button>
                            </div>
                        </h4>
                        <div class="table-responsive">
                            <table class="table table-hover text-center" id="tableExport" style="width:100%;">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Categories</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($categoryData as $value)
                                        @if ($value->deleted_category != 1)
                                            <tr>
                                                <td>{{ $value->id }}</td>
                                                <td>{{ $value->name }}</td>
                                                <td><button type="button" data-id="{{ $value->id }}"
                                                        class="btn btn-danger btn-sm deletebtn">
                                                        <i class="mdi mdi-delete-forever text-light"></i></button></td>
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
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">New Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" class="form-group" id="category_form">
                        @csrf
                        <label for="">Category</label>
                        <input type="text" id="name" name="name" class="form-control input1" required>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary text-light">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- Jquery --}}
<script>
    $(document).ready(function(){
        $('#category_form').submit(function(e){
            e.preventDefault();
            $.ajax({
                url:'/category/insert',
                method:'post',
                data:$(this).serialize(),
                dataType:'json',
                success:function(res)
                {
                    if(res)
                    {
                        swal({
                            icon:'success',
                            title:'Added',
                            text:'New Category Added',
                            timer:1500,
                        })
                        .then(()=>{
                            location.reload();
                        })
                    }
                }
            })
        })
    })
    $('.deletebtn').click(function(){
        var id = $(this).data('id');
        $.ajax({
            url:'/category-deleted/'+id,
            method:'post',
            data:{id:id, _token:'{{ csrf_token() }}'},
            dataType:'json',
            success:function(res)
            {
                if(res)
                {
                    swal({
                        icon:'success',
                        title:'Deleted',
                        timer:1000,
                    }).then(()=>{
                       location.reload();
                    })
                }
            }
        })
    })
</script>