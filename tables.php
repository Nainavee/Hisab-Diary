<?php
include('conn.php');
$succ_msg="";
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!==true){
    header("location: start.html");
}
$name=$_SESSION['name'];
$_SESSION['table_name']=str_replace(" ","_","$name");
$table_name=$_SESSION['table_name'];
if(isset($_GET['id']) && $_GET['id']!=""){
    $sql="DELETE from $table_name where id=".$_GET['id'];
    $result=mysqli_query($conn,$sql);
    $succ_msg="Record deleted successfully!!";
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>Hisab Page</title>
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round|Open+Sans">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="form/css/tables.css">
<link rel="shortcut icon" href="icons/favicon.ico" type="image/x-icon">
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<!-- <script src="tables.js"></script> -->
<style>

.add_input{
    width: 100%;
    box-sizing: border-box;
}
.table-wrapper {
    width: 100%;
    margin: 0px;
    background: #fff;
    padding: 20px;	
    box-shadow: 0 1px 1px rgba(0,0,0,.05);
}
  #add_new:link,#add_new, #add_new:visited{
    background-color:rgb(255, 222, 228);
    text-decoration:none;
    color:black;
    display:inline-block;
    padding:14px 25px;
    border-radius:20px;
}
#add_new:hover{
    background-color:rgb(255, 207, 215);
    text-decoration:none;
    color:black;
    display:inline-block;
    padding:14px 25px;
    border-radius:20px;
    cursor:pointer;
}
.d{
    width:25%;
}
.n{
    width: 30%;
}
#add_new[disabled] {
  opacity: .4;
  cursor: default !important;
  pointer-events: none;
}



@media (max-width:768px) {
    #logout{
      position: relative;
      bottom: auto;
      margin-left: 15px;
    }
  }
#top-title{
    padding-right: 250px;
    text-size-adjust: 80%;
}
</style>
<script>

function myFunction() {
  // Declare variables
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("search");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");

  // Loop through all table rows, and hide those who don't match the search query
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[0];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }
  }
}
function myFunction1() {
  // Declare variables
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("search1");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");

  // Loop through all table rows, and hide those who don't match the search query
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[1];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }
  }
}
$(document).ready(function(){
    var html="<tr>";
    html+="<td><input class='add_input' type='date' name='date' id='date' placeholder='Date' value='<?php echo date('Y-m-d'); ?>' required /></td> ";
    html+="<td><input class='add_input' type='text' name='item-name' id='name' placeholder='Item Name' required /></td>";
    html+="<td><input class='add_input' type='text' name='qty' id='qty' placeholder='Quantity' required /></td>";
    html+="<td><input class='add_input' type='text' name='price' id='price' placeholder='Price' required /></td>";
    html+="<td><button onclick='done_item()' id='done' name='done' style=' background-color: white; border:none;' />";
    html+="<i class='fa fa-check' style='font-size:18px;color:green'></i></button>&nbsp";
    html+="<a  onclick='remove_item()' class='delete' id='remove'><i class='material-icons'>&#xE872;</i></a></td></tr>";
    $('#add_new').click(function(){
    console.log();
    $('#myTable').append(html);
    $('#add_new').attr('disabled',true);
    console.log();
    }); 
    
    
});
function remove_item(){
      
  $('#add_new').attr('disabled',false);
      console.log();
      $('#remove').closest('tr').remove();
}
function done_item(){
  $('#myform1').attr('action', "submit_item.php");
    document.getElementById('myform1').submit();
    $('#add_new').attr('disabled',false);
    console.log();
}
function edit_item(eid){
  $('#add_new').attr('disabled',true);
  var date=document.getElementById("d"+eid);
  var name=document.getElementById("n"+eid);
  var qty=document.getElementById("q"+eid);
  var price=document.getElementById("p"+eid);
  var icon=document.getElementById("a"+eid);

  var date_data=date.innerHTML;
  var name_data=name.innerHTML;
  var qty_data=qty.innerHTML;
  var price_data=price.innerHTML;
  
  date.innerHTML="<input class='add_input' type='date' name='date' id='d"+eid+"' placeholder='Date' value='"+date_data+"' required />";
  name.innerHTML="<input class='add_input' type='text' name='item-name' id='n"+eid+"' placeholder='Item Name' value='"+name_data+"'required />";
  qty.innerHTML="<input class='add_input' type='text' name='qty' id='q"+eid+"' placeholder='Quantity'value='"+qty_data+"' required /></td>";
  price.innerHTML="<input class='add_input' type='text' name='price' id='p"+eid+"' placeholder='Price'value='"+price_data+"' required />";
  icon.innerHTML="<button onclick='save_edited_item("+eid+")' id='save' name='done' style=' background-color: white; border:none;' /><i class='fa fa-check' style='font-size:18px;color:green'></i></button>&nbsp<a  href='tables.php?id="+eid+"' class='delete' id='remove'><i class='material-icons'>&#xE872;</i></a>";
}
function save_edited_item(eid){
  $('#myform1').attr('action', "save_edited_item.php?id="+eid);
  $('form#myForm1').submit(); 
    $('#add_new').attr('disabled',false);
}
</script>

</head>
<body>
<div class="container-lg">
    <div class="table-responsive">
      <div class="top-bar">
    <h3 id="top-welcome">Welcome,&nbsp<h3 id="top-title"> <?php echo"".ucwords($name);?>!</h3></h3>
        <a id="logout" href="logout.php"><i class="fa fa-sign-out"></i> Log Out</a>
        <br/><br/><br/></div><div class="table-wrapper" style="position:relative;">
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-4"><h2>Hisab <b>Details</b></h2></div>
                    <div class="col-sm-5">
                    <form  action="">
      <input type="text" placeholder="Search By Date.." name="search" id="search" onkeyup="myFunction()">
      <button type="submit" class="search-button"><i class="fa fa-search"></i></button>
    </form>
                    <form  action="">
      <input type="text" placeholder="Search By Name.." name="search" id="search1" onkeyup="myFunction1()">
      <button type="submit" class="search-button"><i class="fa fa-search"></i></button>
    </form></div>
                    <div class="col-sm-3">
                   
                    <a id="add_new"  ><i class="fa fa-plus"></i> Add new</a>
</div>
                </div>
            </div>
            <?php if(isset($succ_msg)&& $succ_msg!=""){
							?>
							<div class="text-success">
                            <?php 
                            $succ_msg=""; ?>
							</div>
							<?php
						}
						?>
            
           <form method='POST' id='myform1' action=''>  
           <div class="toscroll" >      
            <table class="table table-bordered" id="myTable">
                <thead>
                    <tr>
                    <th class="d">Date</th>
                        <th class="n">Item Name</th>
                        <th class="iq">Item Qty.</th>
                        <th class="ip">Item Price(Rs.)</th>
                        <th class="a">Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                
                $val = mysqli_query($conn,"select * from $table_name");
                       if($val == FALSE)
                        {
                                $sql="CREATE table $table_name (id INT(11) AUTO_INCREMENT PRIMARY KEY,date Date,item_name VARCHAR(100),item_qty VARCHAR(20),item_price int(11))";
                                if(mysqli_query($conn,$sql)){
                                    $sql="SELECT * from $table_name";
                                    $result=mysqli_query($conn,$sql);
                                }
                        }
                        
                                $sql="SELECT * from $table_name";
                                $result=mysqli_query($conn,$sql);

                        
                       
                while($row=mysqli_fetch_assoc($result)){

                ?>
                    <tr>
                        <td id="d<?php echo ''.$row['id'];?>" ><?php echo"".$row['date'] ?></td>
                        <td id="n<?php echo ''.$row['id'];?>" ><?php echo"".$row['item_name'] ?></td>
                        <td id="q<?php echo ''.$row['id'];?>" ><?php echo"".$row['item_qty'] ?></td>
                        <td id="p<?php echo ''.$row['id'];?>" ><?php echo"".$row['item_price'] ?></td>
                        <td id="a<?php echo ''.$row['id'];?>">
                        <a class="edit"  title="Edit" onclick="edit_item(<?php echo ''.$row['id'];?>);" data-toggle="tooltip"><i class="material-icons">&#xE254;</i></a>
                            <a class="delete" title="Delete" href="tables.php?id=<?php echo $row['id'];?>" data-toggle="tooltip"><i class="material-icons">&#xE872;</i></a>
                        </td>
                    </tr>
                    <?php }?>     
                </tbody>
            </table></div></form>
        </div>
    </div>
</div>     
</body>
</html>