<?php
include('conn.php');
$name=$_SESSION['name'];
$_SESSION['table_name']=str_replace(" ","_","$name");
$table_name=$_SESSION['table_name'];
if(empty($_POST['date']) && empty($_POST['item-name']) && empty($_POST['qty']) && empty($_POST['price'])){
    echo "we haven't post request";
}elseif(isset($_POST) || !empty($_POST)){
   $date=$_POST['date'];
    $item_name=$_POST['item-name'];
    $item_qty=$_POST['qty'];
    $item_price=$_POST['price'];
    $sql="INSERT into $table_name (date,item_name,item_qty,item_price) values ('$date','$item_name','$item_qty','$item_price')";
    $result=mysqli_query($conn,$sql);
    header("location: tables.php");
}
?>