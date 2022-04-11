
<?php 
include('conn.php');
if(isset($_SESSION["name"])){
    header('Location: tables.php');
    exit;
}

$name=$password="";
$name_err=$password_err="";
if(isset($_POST['signin']) && $_POST['signin']=="Log in"){
        $name=strtolower(trim($_POST['name']));
        $sql="SELECT id from people where name='$name'";
        $stmt=mysqli_query($conn,$sql);
        if( !$stmt || mysqli_num_rows($stmt)==0){
            $name_err="User Name doesn't exist";
        }
        else{
            
                $password=trim($_POST['password']);
                $sql="SELECT id,password from people where name='$name'";
                $stmt=mysqli_query($conn,$sql);
                if( !$stmt ){
                   // echo("Error description: " . mysqli_error($conn));
                 }
                 else{
                    $row = mysqli_fetch_assoc($stmt);
                    if(password_verify($password,$row['password']))
                    {
                        $_SESSION["name"] = $name;
                        $_SESSION["id"] = $row['id'];
                        $_SESSION["loggedin"] = true;
                     header('Location: tables.php');
                     exit;
                    
                    }
                     else{
                         $password_err="Wrong password";
                     }
                 }
            
        }
       
    
   

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>

    <!-- Font Icon -->
    <link rel="stylesheet" href="form/fonts/material-icon/css/material-design-iconic-font.min.css">
<link rel="shortcut icon" href="icons/favicon.ico" type="image/x-icon">
    <!-- Main css -->
    <link rel="stylesheet" href="form/css/style.css">
    <style>
        .err{
            color: red;
            
        } 
    #signup:link{
        color:pink;
    }
    #signup:visited{
        color:pink;
    }
    #signup:hover{
        color:magenta;
    }
    #forgetpassword{
        text-decoration:none;
    }
    #forgetpassword:link {
    color: rgb(4, 0, 255);
  }

  #forgetpassword:visited {
    color: rgb(4, 0, 255);
  }
  #forgetpassword:hover {
    color: rgb(136, 135, 245);
  }
  .info{
      color:green;
  }
    </style>
</head>
<body>
    <div class="main">
<!-- Sing in  Form -->
<section class="sign-in">
    <div class="container">
        <div class="signin-content">
            <div class="signin-image">
                <figure><img src="images\coins.jpg" alt="Log in image" style="margin-top: 70px;"></figure>
            </div>

            <div class="signin-form">
                <h2 class="form-title">Log In</h2>
                <form method="POST" class="register-form" id="login-form">
                    <?php echo "<h4 class='err'>".$name_err."</h4>"; ?>
                    <?php 
                    
                    if(isset($_SESSION['msg'])){
                        
                        echo "<h4 class='info'>".$_SESSION['msg']."</h4>";
                        
                        }
                        
                        ?>
                    <div class="form-group">
                        <label for="your_name"><i class="zmdi zmdi-account material-icons-name"></i></label>
                        <input type="text" name="name" id="your_name" placeholder="Your Name" required/>
                    </div>
                    <?php echo "<h4 class='err'>".$password_err."</h4>"; ?>
                    <div class="form-group">
                        <label for="your_pass"><i class="zmdi zmdi-lock"></i></label>
                        <input type="password" name="password" id="your_pass" placeholder="Password" required/>
                    </div>
                    <a id='forgetpassword' href="forget_password.php"> Forgot password?</a>

                    <div class="form-group form-button">
                        <input type="submit" name="signin" id="signin" class="form-submit" value="Log in"/>
                    </div>
                    <p> Not yet a member?&nbsp&nbsp <a id='signup' href="sign_up.php"> Sign Up</a></p>
                </form>
            </div>
        </div>
    </div>
</section>

</div>
</body>
</html>
