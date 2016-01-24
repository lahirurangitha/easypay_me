<?php
require_once 'core/init.php';
require_once 'PHPMailer/PHPMailerAutoload.php';
require_once 'PHPMailer/class.phpmailer.php';
require_once 'PHPMailer/class.smtp.php';
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <title>Email | Page</title>
        <?php include 'headerScript.php'?>
    </head>
<body>

    <div id="wrapper">
        <?php
        include "header.php";
        ?>
    </div>
<div class="backgroundImg container-fluid">


<?php
include "adminSidebar.php";
?>
    <br>
<div class="col-sm-9">
    <div class="jumbotron col-sm-8 col-sm-offset-1">
    <h3><strong>Reply to Emails</strong></h3>

<?php
$user = new User();
$var_value = $_GET['varname'];
if(!$user->isLoggedIn()){
    Redirect::to('index.php');
}
if(isset($_POST['email_send'])){
    $msg=$_POST['message'];
    /* CONFIGURATION */
    $crendentials = array(
        'email'     => 'easypayucsc2@gmail.com',    //Your GMail adress
        'password'  => 'easypayucsc@123'               //Your GMail password
    );

    /* SPECIFIC TO GMAIL SMTP */
    $smtp = array(

        'host' => 'smtp.gmail.com',
        'port' => 587,
        'username' => $crendentials['email'],
        'password' => $crendentials['password'],
        'secure' => 'tls' //SSL or TLS

    );

    /* TO, SUBJECT, CONTENT */
    $to         = $var_value; //The 'To' field

    $mailer = new PHPMailer();

//SMTP Configuration
    $mailer->isSMTP();
    $mailer->SMTPAuth   = true; //We need to authenticate
    $mailer->Host       = $smtp['host'];
    $mailer->Port       = $smtp['port'];
    $mailer->Username   = $smtp['username'];
    $mailer->Password   = $smtp['password'];
    $mailer->SMTPSecure = $smtp['secure'];

//Now, send mail :
//From - To :
    $mailer->From       = $crendentials['email'];
    $mailer->FromName   = 'Easy Pay'; //Optional
    $mailer->addAddress($to);  // Add a recipient

//Subject - Body :
    $mailer->Subject        = 'Regarding your inquiry';
    $mailer->Body           = $msg;
    $mailer->isHTML(true); //Mail body contains HTML tags

//Check if mail is sent :
    if(!$mailer->send()) {
        echo 'Error sending mail : ' . $mailer->ErrorInfo;
    } else {
        echo "<script>alert('Message sent !');window.location.href='email_notify.php'</script>";
    }
//    Redirect::to('email_notify.php');
}


#$contactN = $_GET["$varname"];
#echo $contactName ;
?>
<form action="" method="post" class="form-horizontal">
    <label for="email">Email:</label>
        <div class="gap">
            <input required id="email" class="form-control" name="email" type="email" value="<?php echo $var_value ?>" size="30" />
        </div>

        <label for="message">Message:</label>
        <div class="gap">
            <textarea required id="message" class="form-control" name="message" rows="7" cols="30"></textarea>
        </div>
        <input class="btn btn-primary" id="submit_button" name="email_send" type="submit" value="Send email" />
		
</form>
    </div>
</div>
</div>

<?php

include "footer.php";
?>

</body>
</html>