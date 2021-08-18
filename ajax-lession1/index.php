<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</head>
<body>
<div class="container">
    <div class="col-md-12">
        <h3>Insert data in form</h3>
        <form id="insert_data_hoten" method="post">
            <label for="">Full Name</label>
            <input type="text" class="form-control" id="fullName" placeholder="Full Name">
            <label for="">Phone</label>
            <input type="text" class="form-control" id="phone" placeholder="Phone">
            <label for="">Address</label>
            <input type="text" class="form-control" id="address" placeholder="Address">
            <label for="">Email</label>
            <input type="text" class="form-control" id="email" placeholder="Email">
            <label for="">Note</label>
            <input type="text" class="form-control" id="note" placeholder="Note">
            <br>
            <input type="button" name="insert_data" id="button_insert" value="Insert" class="btn btn-primary">
        </form>
        <h3>Load data at ajax</h3>
        <div id="load_data">

        </div>
    </div>
</div>

<script type="text/javascript">
$(document).ready(function () {
    //load data
    function fetch_data() {
        $.ajax({
            url: "ajax_action.php",
            method: "POST",
            success:function(data){

                $('#load_data').html(data);

            }
        })
    }
    fetch_data();

    //edit data
    function edit_data(id, text, column_name){
        $.ajax({
            url: "ajax_action.php",
            method: "POST",
            data: {id: id, text: text, column_name: column_name},
            success:function(data){
                alert('Edit data success.')
                fetch_data();
            }
        });
    }
    $(document).on('blur','.fullName', function () {
        var id = $(this).data('id1');
        var text = $(this).text();
        edit_data(id, text, "fullName");
    });
    $(document).on('blur','.phone', function () {
        var id = $(this).data('id2');
        var text = $(this).text();
        edit_data(id, text, "phone");
    });
    $(document).on('blur','.address', function () {
        var id = $(this).data('id3');
        var text = $(this).text();
        edit_data(id, text, "address");
    });
    $(document).on('blur','.email', function () {
        var id = $(this).data('id4');
        var text = $(this).text();
        edit_data(id, text, "email");
    });
    $(document).on('blur','.note', function () {
        var id = $(this).data('id5');
        var text = $(this).text();
        edit_data(id, text, "note");
    });

    //delete data

    $(document).on('click','.del_data', function () {
        var rowId = $(this).data('id_delete');
        $.ajax({
            url: "ajax_action.php",
            method: "POST",
            data: {id: rowId},
            success:function(data){
                alert('Delete data success.')
                fetch_data();
            }
        });
    });

    //insert data
    $('#button_insert').on('click',function (){
        var fullName = $('#fullName').val();
        var phone = $('#phone').val();
        var address = $('#address').val();
        var email = $('#email').val();
        var note = $('#note').val();

        if (fullName == '' || phone == '' || address == '' || email == '' || note == '') {
            alert('Khong duoc de trong cac truong.');
        }else {
            $.ajax({
                url: "ajax_action.php",
                method: "POST",
                data: {fullName: fullName, phone: phone, address: address, email: email, note: note},
                success:function(data){
                    alert('Insert data success.')
                    $('#insert_data_hoten')[0].reset();
                    fetch_data();
                }
            })
        };

    });
});

</script>
</body>
</html>