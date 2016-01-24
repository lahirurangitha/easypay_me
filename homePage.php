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
        if($login && $user->data()->active==1){
            //activate status check
//                Your Account is deactivated. Please contact system administrator.
            //setting session variables...
            $_SESSION['isLoggedIn'] = true;
            $_SESSION['fname'] = escape($user->data()->fname);
            $_SESSION['lname'] = escape($user->data()->lname);
            $_SESSION['userid'] = $user->data()->id;
//                $_SESSION['msgs'] = array(); //to store error msgs
            if ($user->hasPermission('admin')) {
                $_SESSION['admin']=true;
                $_SESSION['coord']=false;
                $_SESSION['student']=false;
                Redirect::to('dashboard_admin.php');
            }elseif($user->hasPermission('coord')){
                $_SESSION['admin']=false;
                $_SESSION['coord']=true;
                $_SESSION['student']=false;
                Redirect::to('dashboard_coord.php');
            } else{
                $_SESSION['student']=true;
                $_SESSION['admin']=false;
                $_SESSION['coord']=false;
                Redirect::to('dashboard_student.php');
            }
        }elseif($login && $user->data()->active==0){
            echo '<script type="text/javascript"> alert("Sorry, Your Account is deactivated. Please contact system administrator.")</script>';
            $user->logout();
        } else {
            echo '<script type="text/javascript"> alert("Sorry, Invalid Username or Password. Please try again.")</script>';

//                echo '<p> Sorry, Logging failed. </p>';
//                echo Hash::make($pass, $user->data()->salt);
        }
    } else {
        $str = "";
        foreach ($validation->errors() as $error) {
            $str .= $error;
            $str .= '\n';
        }
        echo '<script type="text/javascript">alert("' . $str . '")</script>';
    }

}
//<---- /inlineform--->
?>

<div class="container-fluid backgroundImg">
    <div class="container">
    <br>
    <div class="col-sm-offset-5">
        <img src="images/ucsc.png" height="110px" >
    </div>
    <div class="col-sm-offset-3">
        <img src="images/logo.png" height="150px" >
    </div>
    <div class="col-sm-offset-4">
        <h2><strong>Online Payment System</strong></h2>
    </div>

    </div>
</div>
<?php
include "footer.php";
?>

</body>
</html>