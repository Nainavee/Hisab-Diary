<?php

include('conn.php');

$name=$_SESSION['name'];
$_SESSION['table_name']=str_replace(" ","_","$name");
$table_name=$_SESSION['table_name'];

if(isset($_POST) && !empty($_POST)){
    $date=$_POST['date'];
    $item_name=$_POST['item-name'];
    $item_qty=$_POST['qty'];
    $item_price=$_POST['price'];
    $sql="UPDATE $table_name SET date='$date',item_name='$item_name',item_qty='$item_qty',item_price='$item_price' WHERE id=".$_GET['id'];
    $query=mysqli_query($conn,$sql);
    if($query){
    header("location: tables.php");
    exit;
}
    else{
        echo "error";
    }
}

?>