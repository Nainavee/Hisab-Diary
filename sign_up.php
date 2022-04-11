<?php 
include('conn.php');
$name=$email=$password="";
$name_err=$email_err=$password_err="";
if(isset($_POST['signup']) && $_POST['signup']=='Sign Up'){
  
    if(empty(trim($_POST['name']))){
        $name_err="UserName cannot be empty";
    }
    
    else{
        $sql="SELECT id from people where name=?";
        $stmt= mysqli_prepare($conn,$sql);
        if($stmt){
            mysqli_stmt_bind_param($stmt,"s",$param_username);
            $param_username=strtolower(trim($_POST['name']));
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                if(mysqli_stmt_num_rows($stmt)>0){
                    $name_err="User with this name already exists";
                }
                else{
                    $name=strtolower(trim($_POST['name']));
                    $email=trim($_POST['email']);
                }
            }
            else{
                echo "Something went wrong";
            }
       
        }
        mysqli_stmt_close($stmt);}

    if (empty(trim($_POST['password']))) {
        $password_err="Password cannot be empty";
    }
    elseif(strlen(trim($_POST['password']))<4){
        $password_err="Password must be aleast 4 character long";
    }
    elseif(strlen(trim($_POST['password']))>10){
        $password_err="Password must not be more than 10 character long";
    }
        else{
        $password=password_hash(trim($_POST['password']),PASSWORD_DEFAULT);
    }
    if(empty($name_err) && empty($password_err) ){
        $sql="INSERT into people (name,email,password) values(?,?,?)";
        $stmt=mysqli_prepare($conn,$sql);
        if($stmt){
           
            mysqli_stmt_bind_param($stmt,"sss",$param_username,$param_email,$param_password);
            $param_username=$name;
            $param_email=$email;
            $param_password=$password;
            if(mysqli_stmt_execute($stmt)){
               
                header("location: start.html");
            }
            else{
                echo "Something went wrong........Cannot redirect";
            }
            mysqli_stmt_close($stmt);
        }
        else {
            echo "Prepare statement error: " . mysqli_error($conn);
        }
       
    }
mysqli_close($conn);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sign Up</title>

    <!-- Font Icon -->
    <link rel="stylesheet" href="form/fonts/material-icon/css/material-design-iconic-font.min.css">
<link rel="shortcut icon" href="icons/favicon.ico" type="image/x-icon">
    <!-- Main css -->
    <link rel="stylesheet" href="form/css/style.css">
    <style>
    .err{
        color:red;
    }
    #login:link{
        color:pink;
    }
    #login:visited{
        color:pink;
    }
    #login:hover{
        color:magenta;
    }
    </style>
</head>
<body>

    <div class="main">

        <!-- Sign up form -->
        <section class="signup">
            <div class="container">
                <div class="signup-content">
                    <div class="signup-form">
                        <h2 class="form-title">Sign up</h2>
                        <form method="POST" class="register-form" id="register-form">
                        <?php 
                            if(!empty($name_err)){
                            echo "<h4 class='err'>".$name_err."</h4>";} ?>
                            <div class="form-group">
                            
                                <label for="name"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                <input type="text" name="name" id="name" placeholder="Your Name"  required/>
                            </div>
                            <div class="form-group">
                                <label for="email"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                <input type="email" name="email" id="email" placeholder="Your Email" required/>
                            </div>
                            <?php 
                            if(!empty($password_err)){
                            echo "<h4 class='err'>".$password_err."</h4>";} ?>
                            <div class="form-group">
                                <label for="pass"><i class="zmdi zmdi-lock"></i></label>
                                <input type="password" name="password" id="password" placeholder="Password" required/>
                            </div>
                            <div class="form-group form-button">
                                <input type="submit" name="signup" id="signup" class="form-submit" value="Sign Up"/>
                            </div>
                            <p> Already a member?&nbsp&nbsp <a id='login' href="login.php"> Login</a></p>
                        </form>
                    </div>
                    <div class="signup-image">
                        <figure><img src="images\shopcart.jpg" alt="sing up image" ></figure>
                       
                    </div>
                </div>
            </div>
        </section>

</body>
</html>