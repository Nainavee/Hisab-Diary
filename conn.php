<?php
session_start();
$host="localhost";
$uname="";
$pwd="";
$db="hisab diary";
$conn = mysqli_connect($host,$uname,$pwd,$db);

if(!$conn){
    die("Connection failed: ".mysqli_connect_error());
}
//echo "connected successfully";
?>