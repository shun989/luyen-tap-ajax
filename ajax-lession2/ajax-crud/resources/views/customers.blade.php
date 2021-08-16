<!doctype html>
<html lang="en">
<head>
    <title>Laravel 8 CRUD</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css"/>
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <style>
    table.dataTable thead .sorting:after, table.dataTable thead .sorting_asc:after, table.dataTable thead .sorting_desc:after, table.dataTable thead .sorting_asc_disabled:after, table.dataTable thead .sorting_desc_disabled:after {
        right: 0.5em;
        content: "\2193";
        margin-right: 5px;
    }
</style>

<body>
<div class="container">
    <div class="row">
        <div class="col-md-12 mt-3">
            <h1>Customers List</h1>
            <a href="javascript:void(0)" class="btn btn-success mb-1" id="createNewCustomer" style="float:right">Add</a>
            <table class="table table-bordered data-table">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Full Name</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Email</th>
                    <th>Note</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="ajaxModel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalHeading"></h5>
            </div>
            <div class="modal-body">
                <form id="customerForm" name="customerForm" class="form-horizontal">
                    <input type="hidden" id="customer_id" name="customer_id">
                    <div class="form-group">
                        <label for="">Full Name</label>
                        <input type="text" id="fullName" class="form-control" name="fullName" value="" required>
                    </div>
                    <div class="form-group">
                        <label for="">Phone</label>
                        <input type="text" id="phone" class="form-control" name="phone" value="" required>
                    </div>
                    <div class="form-group">
                        <label for="">Address</label>
                        <input type="text" id="address" class="form-control" name="address" value="" required>
                    </div>
                    <div class="form-group">
                        <label for="">Email</label>
                        <input type="text" id="email" class="form-control" name="email" value="" required>
                    </div>
                    <div class="form-group">
                        <label for="">Note</label>
                        <input type="text" id="note" class="form-control" name="note" value="" required>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>

<script class="text/javascript">
    $(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var table = $('.data-table').DataTable({
            processing: true,
            serverSile: true,
            ajax: "{{ route('customers.index') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'fullName', name: 'fullName'},
                {data: 'phone', name: 'phone'},
                {data: 'address', name: 'address'},
                {data: 'email', name: 'email'},
                {data: 'note', name: 'note'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
        $("#createNewCustomer").click(function () {
            $('#saveBtn').val("create-customer");
            $('#customer_id').val('');
            $('#customerForm').trigger('reset');
            $('#modalHeading').html("Add new customer");
            $('#ajaxModel').modal('show');
        });
        $('body').on('click', '.editCustomer', function () {
            var customer_id = $(this).data('id');
            $.get("{{route('customers.index')}}" + '/' + customer_id + '/edit', function (data) {
                $('#modalHeading').html("Edit Customer");
                $('#saveBtn').val("edit-customer");
                $('#ajaxModel').modal('show');
                $('#customer_id').val(data.id);
                $('#fullName').val(data.fullName);
                $('#phone').val(data.phone);
                $('#address').val(data.address);
                $('#email').val(data.email);
                $('#note').val(data.note);
            })
        });
        $('#saveBtn').click(function (e) {
            e.preventDefault();
            $(this).html('Save');

            $.ajax({
                data: $('#customerForm').serialize(),
                url: "{{ route('customers.store') }}",
                type: "POST",
                dataType: 'json',

                success: function (data) {
                    alert('Saved Successfully!');
                    $('#customerForm').trigger('reset');
                    $('#ajaxModel').modal('hide');
                    table.draw();
                },
                error: function (data) {
                    console.log('Error:', data);
                    $('#saveBtn').html('Save');
                }
            });
        });
        $('body').on('click', '.deleteCustomer', function () {
            var customer_id = $(this).data('id');
            confirm("Are you sure want to delete?");

            $.ajax({
                type: "DELETE",
                url: "{{ route('customers.store') }}" + "/" + customer_id,
                success: function (data) {
                    alert('Delete Successfully!');
                    table.draw();
                },
                error: function (data) {
                    console.log('Error:', data);
                }
            })
        });

    });

</script>
</body>
</html>
