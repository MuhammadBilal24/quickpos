<title>Trash - QuickPos</title>
@include('layout.header')
<link rel="stylesheet" href="{{ asset('assets2/bundles/datatables/datatables.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets2/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets2/css/components.css') }}">

<!-- partial -->
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="">Trash / Deleted Items 
                            <div class="float-right" id="trash_alert" style="color:#5cb85c;"></div> 
                            <div class="float-right" id="trash_danger" style="color:#d9534f;"></div> 
                        </h4>
                        <div class="table-responsive">
                            <table class="table table-hover text-center" id="tableExport" style="width:100%;">
                                <thead>
                                    <tr>
                                        <th>From</th>
                                        <th>Items</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($deletedExpense as $value)
                                        <tr>
                                            @if ($value->deleted_expenses==1)
                                                <td class="bg bg-info">Deleted Expense</td>
                                                <td>Date: {{ $value->date }}, Account {{ $value->account }} | {{ $value->actype }}, Amount= {{ $value->amount }}</td>    
                                                <td><a href="/expenceRestore/{{ $value->id }}" id="restoreExpenses" class="btn btn-primary" style="color:white"><i class="mdi mdi-backup-restore" style="color:white;"></i></a>
                                                    <a href="/expencePermenantDeleteExpense/{{ $value->id }}" id="deletedExpenses" class="btn btn-danger" style="color:white"><i class="mdi mdi-delete-forever" style="color:white;"></i></a>
                                            @endif
                                        </tr>
                                    @endforeach
                                    @foreach ($deletedCategory as $value)
                                        <tr>
                                            @if ($value->deleted_category == 1)
                                                <td class="bg bg-info">Deleted Catgeory</td>
                                                <td>{{ $value->name }}</td>    
                                                <td><a href="/categoryRestore/{{ $value->id }}" id="restoreCategory" class="btn btn-primary" style="color:white"><i class="mdi mdi-backup-restore" style="color:white;"></i></a>
                                                    <a href="/categoryPermenantDeleteCategory/{{ $value->id }}" id="deletedCategory" class="btn btn-danger" style="color:white"><i class="mdi mdi-delete-forever" style="color:white;"></i></a>
                                            @endif
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
<script>
    // Expenses
    $('#restoreExpenses').click(function(){
            $('#trash_alert').html('Expense Restored').fadeOut(10000);
        })
    $('#deletedExpenses').click(function(){
        $('#trash_danger').html('Permenantly Deleted').fadeOut(10000);
    })
    //Expenses End
    
    // Category
    $('#restoreCategory').click(function(){
        $('#trash_alert').html('Category Restored').fadeOut(10000);
    })
    $('#deletedCategory').click(function(){
        $('#trash_danger').html('Permenantly Deleted').fadeOut(10000);
    })
    // Category End

</script>