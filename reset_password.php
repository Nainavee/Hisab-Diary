<?php
include('conn.php');
$password_err="";
if(isset($_GET['token'])){
if(isset($_POST['save']) && $_POST['save']='Save'){
   
        $pass=trim($_POST['password']);
    $cp=trim($_POST['confirmpassword']);
    if(empty($pass) || empty($cp)){
        $password_err="Password should not be empty";
    }
    elseif(strlen(trim($_POST['password']))<4){
        $password_err="Password must be aleast 4 character long";
    }
    elseif(strlen(trim($_POST['password']))>10){
        $password_err="Password must not be more than 10 character long";
    }
    else{
        if($pass==$cp){
            $id=$_GET['token'];
            $hash=password_hash($pass,PASSWORD_DEFAULT);
            $sql="UPDATE people set password='$hash' where id=$id ";
            $result=mysqli_query($conn,$sql);
            if($result){
                $_SESSION['msg']="Password reset Successfully!";
                header('Location: login.php');
            }
            else{
               $_SESSION['passmsg']="Your Password is not reset";
               header('location: reset_password.php');
            }
        }
        else{
            $password_err="Passwords doesn't match";
        }
    }
    }
   
}
else{
    header('location: start.html');
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reset Password</title>

    <!-- Font Icon -->
    <link rel="stylesheet" href="form/fonts/material-icon/css/material-design-iconic-font.min.css">

    <link rel="shortcut icon" href="icons/favicon.ico" type="image/x-icon">
    <!-- Main css -->
    <link rel="stylesheet" href="form/css/style.css">
    <style>
    .container{
        display: flex;
        justify-content:space-evenly;
    }
    #p{
        padding-bottom:25px; 
        
    }
    .err{
        color:red;
    }
    #save{
        text-align:center;
    }
    #title{
        font-size: 20px;
    }
   
    </style>
    
</head>
<body>
    <div class="main">
<!-- Sing in  Form -->
<section class="sign-in">
    <div class="container">
        <div class="signin-content">
           

            <div class="signin-form">
                <h2 id="title">Reset Password</h2>
                <p id='p'>Change your password here</p>
                <form method="POST" class="register-form" id="login-form">
                  <?php echo "<h4 class='err'>".$password_err."</h4>"; ?> 
                  <?php
                    if(isset($_SESSION['passmsg'])){
                        echo "<h4 class='err'>".$_SESSION['passmsg']."</h4>";  
                    }
                  ?>
                <div class="form-group">
                        <label for="your_pass"><i class="zmdi zmdi-lock"></i></label>
                        <input type="password" name="password" id="your_pass" placeholder="Password" required/>
                    </div>
                    <div class="form-group">
                        <label for="your_pass"><i class="zmdi zmdi-lock"></i></label>
                        <input type="password" name="confirmpassword" id="confirm_pass" placeholder="Confirm Password" required/>
                    </div>
                    <div class="form-group form-button">
                        <input type="submit" name="save" id="save" class="form-submit" value="Save"/>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

</div>
</body>
</html>