<?php
/**
 * Created by PhpStorm.
 * User: Lasith Niroshan
 * Date: 5/23/2015
 * Time: 1:43 PM
 */
require_once 'core/init.php';

//$_SESSION['uname'] = Input::get('username');
if(Session::exists('home')){
    echo '<p>' . Session::flash('home') . '</p>';
}
//checking if the user already logged in
$user = new User();
if($user->isLoggedIn()){
    Redirect::to('dashboard_student.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login | page</title>
    <?php include 'headerScript.php'?>
</head>

<body>
<div>
    <?php
    include "header.php";
    ?>
</div>
<div class="container-fluid backgroundImg">
<div class="container-fluid">
    <br>
    <?php
if(Input::exists()){
    if(Token::check(Input::get('token'))) {
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
                echo '<script type="text/javascript"> alert(" Sorry, Logging failed. ")</script>';

//                echo '<p> Sorry, Logging failed. </p>';
//                echo Hash::make($pass, $user->data()->salt);
            }
        } else {
            foreach ($validation->errors() as $er) {
                echo $er, '<\ br>';
            }
        }
    }
}

?>


    <div id="loginForm" class="jumbotron col-lg-4 col-lg-offset-4 ">
        <img class="col-lg-offset-4" src="images/ucsc.png" height="100px">
        <form action="login.php" method="POST" class="form-horizontal">
            <div>
                <h3 id="signin"><strong>Sign in</strong></h3>
            </div>

            <div class="gap">
                <label>Username</label><br>
                <input class="form-control" required id="username" type="text" name="username" autocomplete="off" placeholder="Enter username" size="25" maxlength="20"/>
            </div>
            <div class="gap">
                <label>Password</label><br>
                <input class="form-control" required id="password" type="password" name="password" autocomplete="off" placeholder="Enter password" size="25" maxlength="20"/>
            </div>
            <div id="remember" class="gap">
                <input type="checkbox"  name="remember"/> Remember me
            </div>

            <div class="gap">
                <input class="btn btn-primary col-lg-12"  id="loginButton" type="submit" value="Sign in" name="signin"/>
            </div>
            <div id="forgotPassword" class="gap">  <a href="forgetpass.php" title="To recover your password, click here " >Forgot password?</a></div>

            <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
        </form>
        <hr>
        <div class="gap">
            <a href="register.php"><button class="btn btn-default col-lg-12" id="signupButton">Sign up</button></a>
        </div>


    </div>
</div>
    </div>

<?php
include "footer.php";
?>

</body>
</html>