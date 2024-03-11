<title>Products - QuickPos</title>
@include('layout.header')
<link rel="stylesheet" href="{{ asset('assets2/bundles/datatables/datatables.min.css') }}">
<link rel="stylesheet"
    href="{{ asset('assets2/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets2/css/components.css') }}">
<style>
    .input1 {
        border: 0.1px solid rgb(138, 138, 138);
    }
</style>
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="">Products
                            <div class="d-flex d-grid justify-content-end" style="margin-top:-25px;">
                                <button type="button" class="btn btn-primary text-light" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal" id="addbtn">
                                    Add Product
                                </button>
                            </div>
                            {{-- <div class="float-right" id="users-alert"></div> --}}
                        </h4>
                        <div class="table-responsive">
                            <table class="table table-hover" id="tableExport" style="width:100%;">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Code</th>
                                        <th>Barcode</th>
                                        <th></th>
                                        <th>Product Name</th>
                                        <th>Category</th>
                                        <th class="text-center">C.Price</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($productData as $value)
                                        <tr>
                                            <td>{{ $value->id }}</td>
                                            <td>{{ $value->pcode }}</td>
                                            <td>{{ $value->pcode }}</td>
                                            <td><img src="storage/imgs/1709199356.png" alt="image" /></td>
                                            <td>{{ $value->pname }}</td>
                                            <td>{{ $value->category }}</td>
                                            <td class="text-center">{{ $value->rprice }}</td>
                                            <td class="text-center"><button class="btn btn-primary detailsbtn"
                                                    data-id="{{ $value->id }}"><i
                                                        class="mdi mdi-file-document-box text-light"></i></button></td>
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
    @include('layout.footer')

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen-xxl-down">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel2">Add New Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-5 text-center">
                            <img src="{{ asset('storage/imgs/1709199356.png') }}" alt="image" width="230px" />
                            <div><br>
                                <label for="Picture">Choose a Product Picture</label>
                                <input type="file" id="picture" name="picture" class="form-control rounded-pill">
                            </div>
                        </div>
                        <div class="col-lg-6" style="border-left:1px solid black"><br>
                            <form action="" class="form-group" id="product_form">
                                @csrf
                                <input type="text" name="id" id="id">
                                <div class="row py-1">
                                    <div class="col-lg">
                                        <label for="name">Product Code</label>
                                        <input class="form-control input1" type="text" name="pcode"
                                            autocomplete="off" id="pcode">
                                    </div>
                                    <div class="col-lg">
                                        <label for="">Barcode</label>
                                        <input class="form-control input1" type="text" name="barcode"
                                            autocomplete="off" id="barcode">
                                    </div>
                                </div>
                                <div class="row py-1">
                                    <div class="col-lg">
                                        <label for="name">Product Name</label>
                                        <input class="form-control input1" type="text" name="pname"
                                            autocomplete="off" id="pname" required>
                                    </div>
                                    <div class="col-lg">
                                        <label for="">Category</label>
                                        <select name="category" id="category" class="form-control"
                                            style="border: 0.1px solid rgb(138, 138, 138); color:black; padding:15px">
                                            <option value="">Select a Category</option>
                                            @foreach ($categoryData as $value)
                                                <option value="{{ $value->id }}">{{ $value->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row py-1">
                                    <div class="col-lg">
                                        <label for="">C Price</label>
                                        <input class="form-control input1" type="text" name="cprice"
                                            autocomplete="off" id="cprice" required>
                                    </div>
                                    <div class="col-lg">
                                        <label for="">Retail Price</label>
                                        <input class="form-control input1" type="text" name="rprice"
                                            autocomplete="off" id="rprice" required>
                                    </div>
                                    <div class="col-lg">
                                        <label for="">W Price</label>
                                        <input class="form-control input1" type="text" name="wprice"
                                            autocomplete="off" id="wprice">
                                    </div>
                                    <div class="col-lg">
                                        <label for="">Discount</label>
                                        <input class="form-control input1" type="text" name="discount"
                                            autocomplete="off" id="discount">
                                    </div>
                                </div>
                                <br>
                                <div class="d-flex d-grid justify-content-end">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>&nbsp;
                                    <button type="submit" class="btn btn-primary text-light" id="savebtn">Save
                                        Product</button>
                                    <button type="button" class="btn btn-success text-light" id="updatebtn">Update
                                        Product</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $('#addbtn').click(function(){
            $('#product_form')[0].reset();
            $('#product_form').submit(function(e) {
            e.preventDefault();
            var form = $(this).serialize()
            $.ajax({
                url: '/product/insert',
                method: 'post',
                data: form,
                dataType: 'json',
                success: function(res) {
                    if (res.status == 200) {
                        swal({
                            icon: 'success',
                            title: 'Product Added',
                            text: 'New product details added successfully',
                            timer: 1000,
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        swal({
                            icon: 'error',
                            title: 'Try Again',
                            timer: 1000,
                        }).then(() => {
                            location.reload();
                        });
                    }
                }
            })
        })
        })
        // Product Details/Edit
        $(document).ready(function() {
            $('#savebtn').show();
            $('#updatebtn').hide();
            $('.detailsbtn').click(function() {
                var id = $(this).data('id');
                // alert(id);
                $('#exampleModal').modal('show');
                $('#exampleModalLabel2').text('Edit Product');
                $('#savebtn').hide();
                $('#updatebtn').show();
                $.ajax({
                    url: '/product/getEdit',
                    method: 'get',
                    data: {
                        id: id
                    },
                    dataType: 'json',
                    success: function(res) {
                        $('#id').val(res.id);
                        $('#pcode').val(res.pcode);
                        $('#barcode').val(res.barcode);
                        $('#pname').val(res.pname);
                        $('#category').val(res.category);
                        $('#rprice').val(res.rprice);
                        $('#cprice').val(res.cprice);
                        $('#wprice').val(res.wprice);
                        $('#discount').val(res.discount);
                    }
                })
            })
        })
        // Update product
        $('#updatebtn').click(function(){
        $('#product_form').submit(function(){
            var id = $('#id').val();
            alert(id); 
        })

        })
    </script>
