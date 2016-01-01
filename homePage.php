<?php
require_once 'core/init.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Home | Page</title>
    <?php include 'headerScript.php'?>
</head>

<body>

<?php
    include 'header.php';
//<---- inlineform login  ---->
if(isset($_POST['inlinesubmit'])) {
    $validate = new Validate();
    $validation = $validate->check($_POST, array(
        'username' => array(
            'required' => true
        ),
        'password' => array(
            'required' => true
        ),
    ));
    if($validation->passed()){
        $user = new User();
        $remember = (Input::get('remember') === 'on') ? true : false;
//            $pass = Input::get('password');
        $login = $user->login(Input::get('username'), Input::get('password'), $remember);
        if($login){
            //setting session variables...
            $_SESSION['isLoggedIn'] = true;
            $_SESSION['fname'] = escape($user->data()->fname);
            $_SESSION['lname'] = escape($user->data()->lname);
            $_SESSION['userid'] = $user->data()->id;
            if ($user->hasPermission('admin')) {
                $_SESSION['admin']=true;
                $_SESSION['student']=false;
                Redirect::to('dashboard_admin.php');
            }
            else{
                $_SESSION['student']=true;
                $_SESSION['admin']=false;
                Redirect::to('dashboard_student.php');
            }
        } else {
            echo '<script type="text/javascript"> alert("Sorry, Invalid Username or Password. Please try again.")</script>';

//                echo '<p> Sorry, Logging failed. </p>';
//                echo Hash::make($pass, $user->data()->salt);
        }
    } else {
        foreach ($validation->errors() as $er) {
            echo $er, '<\ br>';
        }
    }

}
//<---- /inlineform--->
?>

<div class="container-fluid backgroundImg">
    <div class="container-fluid">
    <br>
    <div class="col-xs-offset-5">
        <img src="images/ucsc.png" height="110px" >
    </div>
    <div class="col-xs-offset-3">
        <img src="images/logo.png" height="150px" >
    </div>
    <div class="container col-xs-offset-4">
        <h2><strong>Online Payment System</strong></h2>
    </div>

</div>
</div>
<?php
include "footer.php";
?>

</body>
</html>