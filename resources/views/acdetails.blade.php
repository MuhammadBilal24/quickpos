<title>Account Details - QuickPos</title>
@include('layout.header')
<style>
    .input1 {
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
                        <h4 class="">Account Details
                            <?php $checkingStatus = db::table('account')
                                ->where('id', $accountDetails[0]->id)
                                ->first(); ?>
                            @if ($checkingStatus->status == 1)
                                <div class="d-flex d-grid justify-content-end" style="margin-top:-25px;">
                                    <button type="button" id="deactivebtn" style="color:white;"
                                        class="btn btn-danger btn-sm">Deactivate
                                    </button>
                                </div>
                                {{-- <h6 class="text-success">Active</h6> --}}
                            @else
                                <div class="d-flex d-grid justify-content-end" style="margin-top:-25px;">
                                    <button type="button" id="activebtn" style="color:white;"
                                        class="btn btn-primary btn-sm">Activate this Account
                                    </button>
                                </div>
                                <h6 class="text-danger">Account is deactivated.</h6>
                            @endif
                        </h4>
                        @if (session('success'))
                            <div id="successAlert" class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        <div class="row">
                            <div class="col-lg-12">
                                <form class="form-group" action="/accountDetailsUpdate/{{ $accountDetails[0]->id }}"
                                    method="post" id="accountDetails_form">
                                    @csrf
                                    <input type="text" id="id" name="id" hidden
                                        value="{{ $accountDetails[0]->id }}">
                                    <div class="row py-2">
                                        <div class="col-lg">
                                            <label for="name">Date</label>
                                            <input class="form-control input1" type="text" name="date"
                                                id="date" value="{{ $accountDetails[0]->date }}" readonly>
                                        </div>
                                        <div class="col-lg">
                                            <label for="">Account Name</label>
                                            <input class="form-control input1" type="text" name="acname"
                                                id="acname" value="{{ $accountDetails[0]->acname }}" readonly>
                                        </div>
                                        <div class="col-lg">
                                            <label for="">Account Type</label>
                                            <input class="form-control input1" type="text" name="actype"
                                                id="actype" value="{{ $accountDetails[0]->actype }}" readonly>
                                        </div>
                                    </div>
                                    <div class="row py-2">
                                        <div class="col-lg">
                                            <label for="">C-NIC / National Identity Card Number</label>
                                            <input class="form-control input1" type="text" name="cnic"
                                                id="cnicInput" value="{{ $accountDetails[0]->cnic }}">

                                        </div>
                                        <div class="col-lg">
                                            <label for="">Address</label>
                                            <input class="form-control input1" type="text" name="address"
                                                id="address" value="{{ $accountDetails[0]->address }}">
                                        </div>
                                        <div class="col-lg">
                                            <label for="">City</label>
                                            <select name="city" id="city" class="form-control"
                                                style=" padding: 15px; border: 0.1px solid rgb(138, 138, 138); color:black">
                                                <option value="" disabled>Select a city</option>
                                                @foreach ($cityData as $value)
                                                    <option value="{{ $value->city }}"
                                                        {{ $value->city == $accountDetails[0]->city ? 'Selected' : '' }}>
                                                        {{ $value->city }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row py-2">
                                        <div class="col-lg">
                                            <label for="">Phone Number / Cell</label>
                                            <input class="form-control input1" type="text" name="phone"
                                                id="phone" value="{{ $accountDetails[0]->phone }}">
                                        </div>
                                        <div class="col-lg">
                                            <label for="">Account Code</label>
                                            <input class="form-control input1" type="number" name="acode"
                                                id="acode" value="{{ $accountDetails[0]->acode }}" readonly>
                                        </div>
                                        <div class="col-lg">
                                            <label for="">Status</label>
                                            @if ($accountDetails[0]->status == 1)
                                                <input class="bg bg-primary text-light form-control" type="text"
                                                    name="status" id="status" value="Active" readonly>
                                            @else
                                                <input class="bg bg-danger text-light form-control" type="text"
                                                    name="status" id="status" value="Deactive" readonly>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row py-2">
                                        <div class="col-lg">
                                        </div>
                                        <div class="col-lg-6 d-flex justify-content-end">
                                            <a href="/account"><button type="button"
                                                    class="btn btn-secondary">Back</button></a> &nbsp;
                                            <?php $checkingStatus = db::table('account')
                                                ->where('id', $accountDetails[0]->id)
                                                ->first(); ?>
                                            @if ($checkingStatus->status == 1)
                                                <button type="submit" class="btn btn-success" id="updatebtn"
                                                    style="color:white">Update
                                                    Account</button>
                                            @else
                                            @endif
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
    <!-- content-wrapper ends -->
    @include('layout.footer')
    <script>
        // Cnic Dashes pattern
        $(document).ready(function() {
            $('#cnicInput').on('input', function() {
                let inputValue = $(this).val().replace(/\D/g, ''); // Remove non-numeric characters
                let formattedValue = formatCNIC(inputValue);
                $(this).val(formattedValue);
            });

            function formatCNIC(value) {
                if (value.length >= 5 && value.length < 13) {
                    return value.slice(0, 5) + '-' + value.slice(5);
                } else if (value.length >= 13 && value.length < 21) {
                    return value.slice(0, 5) + '-' + value.slice(5, 12) + '-' + value.slice(12);
                } else {
                    return value;
                }
            }
        })
        // Success Alert
        $(document).ready(function() {
            if ($('#successAlert').length) {
                setTimeout(function() {
                    $('#successAlert').fadeOut('slow', function() {});
                }, 1000);
            }
        });
        // Deactivate
        $('#deactivebtn').click(function(e) {
            var id = $('#id').val();
            $.ajax({
                url: '/deactive/' + id,
                method: 'post',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                dataType: 'json',
                success: function(res) {
                    if (res.status == 200) {
                        swal({
                            icon: 'success',
                            title: 'Deactivated',
                            text: 'This account is deactive now',
                            timer: 1000,
                        }).then(() => {
                            location.reload();
                        })
                    } else {
                        swal({
                            icon: 'error',
                            title: 'Try Again',
                            // text:'This account is Activate now',
                            timer: 1000,
                        }).then(() => {
                            location.reload();
                        })
                    }
                }
            })
        })
        // Activate
        $('#activebtn').click(function(e) {
            var id = $('#id').val();
            $.ajax({
                url: '/active/' + id,
                method: 'post',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                dataType: 'json',
                success: function(res) {
                    if (res.status == 200) {
                        swal({
                            icon: 'success',
                            title: 'Activated',
                            text: 'This account is Activate now',
                            timer: 1000,
                        }).then(() => {
                            location.reload();
                        })
                    } else {
                        swal({
                            icon: 'error',
                            title: 'Try Again',
                            // text:'This account is Activate now',
                            timer: 1000,
                        }).then(() => {
                            location.reload();
                        })
                    }
                }
            })
        })
    </script>
