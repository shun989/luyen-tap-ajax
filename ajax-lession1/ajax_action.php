<?php
include("db.php");

//insert data
if (isset($_POST['fullName'])) {
    $fullName = $_POST['fullName'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $email = $_POST['email'];
    $note = $_POST['note'];
    $result = mysqli_query($con,
        "INSERT INTO customers (fullName, phone, address, email, note) VALUES ('$fullName','$phone', '$address','$email','$note')");

}

//delete data

if (isset($_POST['id'])){
    $id = $_POST['id'];
    $result = mysqli_query($con,
        "DELETE FROM customers WHERE id = '$id'");
}

//edit data

if (isset($_POST['id'])){
    $id = $_POST['id'];
    $text = $_POST['text'];
    $column_name = $_POST['column_name'];
    $result = mysqli_query($con,
    "UPDATE customers SET $column_name = '$text' WHERE id = '$id'");
}
//load data
$output = '';
$sql_select = mysqli_query($con, "SELECT * FROM customers ORDER BY id DESC");
$output .= '
  <div class="table table-responsive">
    <table class="table table-bordered">
        <tr>
        <td>Full Name</td>
        <td>Phone</td>
        <td>Address</td>
        <td>Email</td>
        <td>Note</td>
        <td>Action</td>
        </tr>
';
if (mysqli_num_rows($sql_select) > 0){
    while ($rows = mysqli_fetch_array($sql_select)){
        $output .= '
            <tr>
                <td class="fullName" data-id1='.$rows['id'].' contenteditable="">'.$rows['fullName'].'</td>
                <td class="phone" data-id2='.$rows['id'].' contenteditable="">'.$rows['phone'].'</td>
                <td class="address" data-id3='.$rows['id'].' contenteditable="">'.$rows['address'].'</td>
                <td class="email" data-id4='.$rows['id'].' contenteditable="">'.$rows['email'].'</td>
                <td class="note" data-id5='.$rows['id'].' contenteditable="">'.$rows['note'].'</td>
                <td><button data-id_delete='.$rows['id'].' class="btn btn-danger del_data" name="delete_data">Delete</button></td>
            </tr>
        ';
    }
}else{
    $output .= '
        <tr>
            <td colspan="6">No Data</td>
        </tr>
    ';
}
$output .= '
</table></div>
';
echo $output;

?>