<title>Expenses - QuickPos</title>
@include('layout.header')
<link rel="stylesheet" href="{{ asset('assets2/bundles/datatables/datatables.min.css') }}">
<link rel="stylesheet"
    href="{{ asset('assets2/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets2/css/components.css') }}">
<style>
    .inputexp {
        border: 1px solid grey;
        color: black;
    }
</style>
<!-- partial -->
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="">Expenses
                            {{-- <h3 class="">Total Expense: {{ $total_Expense[0]->total_sum }}</h3> --}}
                            <div class="float-right" id="expense_alert" style="color:#5cb85c;"></div>
                            <div class="float-right" id="expense_danger" style="color:#d9534f;"></div>
                            <div class="d-flex justify-content-end">
                                <button id="openbtn" class="bt-sm btn btn-primary" style="color:white">All
                                    Expenses</button>
                                <button id="closebtn" class="bt-sm btn btn-dark" style="color:white">Hide</button>
                            </div>
                            {{-- {{ $total_Expense[0]->total_sum }} --}}
                        </h4>
                        <div id="addexpenseform">
                            <h6>Add New Expense</h6>
                            <form action="" method="" id="expense_form">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-3">
                                        <label for="" class="py-1">Date</label>
                                        <input class="form-control inputexp" type="date"
                                            name="date" id="date" required style=" padding: 12.5px;"></div>
                                    <div class="col-lg-3">
                                        <label for="" class="py-1">Account</label>
                                        <select name="account" id="account" class="form-control"  style=" padding: 14.5px; border: 0.1px solid rgb(138, 138, 138); color:black">
                                            <option value="" disabled selected>Choose an Account</option>
                                            @foreach ($accountData as $value)
                                            <option value="{{ $value->id }}">{{ $value->acname }} | {{ $value->actype }}</option> 
                                            @endforeach
                                        </select></div>
                                    <div class="col-lg-3">
                                        <label for="" class="py-1">Amount</label>
                                        <input class="form-control inputexp" type="number"
                                            placeholder="Expense Amount" name="amount" id="amount" required></div>
                                    <div class="col-lg-3">
                                        <label for="" class="py-1">Details</label>
                                        <input class="form-control inputexp" type="text"
                                            placeholder="Expense Detail" name="description" id="description" required>
                                    </div>
                                </div>&nbsp;
                                <div class="justify-content-end d-flex d-grid"><button type="submit" id="expense_btn"
                                        class="btn btn-success btn-sm" style="color:white">Add Expense</button></div>
                            </form>
                        </div>
                        <div class="table-responsive" id="tableExpense">
                            <table class="table table-hover" id="tableExport" style="width:100%;">
                                <thead>
                                    <tr>
                                        {{-- <th>#</th> --}}
                                        <th>Date</th>
                                        <th>Account</th>
                                        <th>Amount</th>
                                        <th>Details</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($expenseData as $value)
                                        @if ($value->deleted_expenses == 0)
                                            <tr>
                                                {{-- <td>{{ $value->id }}</td> --}}
                                                <td>{{ $value->date }}</td>
                                                <td>{{ $value->account }} | {{ $value->actype }}</td>
                                                <td>{{ $value->amount }} /-</td>
                                                <td>{{ $value->description }}</td>
                                                <td class="text-center"><a href="/expencedeleted/{{ $value->id }}"
                                                        class="btn btn-danger" id="deleteExp">
                                                        <i class="mdi mdi-delete-forever" style="color:white;"></i></a>
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
        $(function() {
            $('#tableExpense').hide();
            $('#closebtn').hide();
            $('#openbtn').click(function() {
                $('#addexpenseform').hide();
                $('#tableExpense').show();
                $('#openbtn').hide();
                $('#closebtn').show();
            })
            $('#closebtn').click(function() {
                $('#addexpenseform').show();
                $('#tableExpense').hide();
                $('#closebtn').hide();
                $('#openbtn').show();
            })
            // Store Expense
            $('#expense_form').submit(function(e) {
                $('#expense_btn').text('Please Wait...');
                e.preventDefault();
                $.ajax({
                    url: '{{ route('store.expense') }}',
                    method: 'post',
                    data: $(this).serialize(),
                    dataType: 'json',
                    success: function(res) {
                        // $('#tableExpense').html(data);
                        if (res.status == 200) {
                            swal({
                                icon:'success',
                                title:'Expense Added',
                                text:'New expense added successfully',
                                timer:1000
                            }).then(()=>{
                                // $('#tableExpense').clear().draw()
                                $('#expense_form')[0].reset();
                            })
                            // $('#expense_alert').html('Expense Added').fadeOut(10000);
                            // $('#expense_btn').text('Add Expense');
                            
                        } else {
                            $('#expense_danger').html('Try Again').fadeout(10000);
                            $('#expense_btn').text('Add Expense');
                        }
                    }
                })
            })
        })
        $('#deleteExp').click(function() {
            $('#expense_danger').html('Expense Deleted').fadeOut(10000);
        })
    </script>
