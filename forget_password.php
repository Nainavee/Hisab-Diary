<?php
include('conn.php');
use PHPMailer\PHPMailer\PHPMailer;
        use PHPMailer\PHPMailer\Exception;
$err="";
if(isset($_POST['send']) && $_POST['send']=='Send Mail'){
    $email=trim($_POST['email']);
    $query="SELECT * from people where email='$email'";
    $result=mysqli_query($conn,$query);
    $count=mysqli_num_rows($result);
    if($count){
        $userdata=mysqli_fetch_array($result);
        $name=ucwords($userdata['name']);
        $id=$userdata['id'];
        $sub='Recover Password';
        $body="Hi, $name."."\n\n"." Click here to reset your Password,"."\n\n"."http://localhost/Hisab%20Diary/reset_password.php?token=$id."."\n\n"." From: Nainavee Shah";
        require $_SERVER['DOCUMENT_ROOT'] . '/Hisab diary/PHPMailer-master/PHPMailer-master/src/Exception.php';
        require $_SERVER['DOCUMENT_ROOT'] . '/Hisab diary/PHPMailer-master/PHPMailer-master/src/PHPMailer.php';
        require $_SERVER['DOCUMENT_ROOT'] . '/Hisab diary/PHPMailer-master/PHPMailer-master/src/SMTP.php';

            $mail = new PHPMailer;
            $mail->isSMTP(); 
            $mail->SMTPDebug = 2; // 0 = off (for production use) - 1 = client messages - 2 = client and server messages
            $mail->Host = "smtp.gmail.com"; // use $mail->Host = gethostbyname('smtp.gmail.com'); // if your network does not support SMTP over IPv6
            $mail->Port = 587; // TLS only
            $mail->SMTPSecure = 'tls'; // ssl is deprecated
            $mail->SMTPAuth = true;
            $mail->Username = ''; // email
            $mail->Password = ''; // password
            $mail->setFrom('from email', 'from name'); // From email and name
            $mail->addAddress("$email", "$name"); // to email and name
            $mail->Subject = 'Recover Password';
            $mail->msgHTML("$body"); //$mail->msgHTML(file_get_contents('contents.html'), __DIR__); //Read an HTML message body from an external file, convert referenced images to embedded,
            $mail->AltBody = 'HTML messaging not supported'; // If html emails is not supported by the receiver, show this body
            // $mail->addAttachment('images/phpmailer_mini.png'); //Attach an image file
            $mail->SMTPOptions = array(
                    'ssl' => array(
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                        'allow_self_signed' => true
                    )
                );
            if(!$mail->send()){
                    echo "Mailer Error: " . $mail->ErrorInfo;
            }else{
                    $_SESSION['msg']='Check your email to reset password';
                    header('location: login.php');
            }
    }
    else{
        $err="Email doesn't exists";
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Forgot Password</title>

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
        color:green;
        padding-bottom:25px; 
        
    }
    #title{
        font-size:30px;
    }
    #err{
        color:red;
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
                <h3 id="title">Recover Password</h3>
                <p id='p'>You'll get a link to recover password on this email address.</p>
                <form method="POST" class="register-form" id="login-form">
                   
                    <div class="form-group">
                        <label for="your_name"><i class="zmdi zmdi-account material-icons-name"></i></label>
                        <input type="email" name="email" id="email" placeholder="Your Email" required/>
                    </div>
                    <p id='err'><?php echo"$err";?></p>
                    <div class="form-group form-button">
                        <input type="submit" name="send" id="send" class="form-submit" value="Send Mail"/>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

</div>
</body>
</html>