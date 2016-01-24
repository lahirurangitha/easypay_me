<?php
/**
 * Created by PhpStorm.
 * User: lahiru
 * Date: 10/16/2015
 * Time: 12:51 PM
 */

require_once 'core/init.php';

if(!$_SESSION['isLoggedIn']==true){
    Redirect::to('login.php');
}
if($_SESSION['admin']==false){
    Redirect::to('dashboard_student.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Admin | Dashboard</title>
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
    <div class="container col-sm-9">
        <br>
<?php
$searchUser = Input::get('username');
$u_user = new user();
$u_user->find($searchUser);
$u_userID = $u_user->data()->id;

?>
        <!--            -->
        <?php
        if(Input::exists()){
            if(Token::check(Input::get('token'))){
                $validate = new Validate();
                $validation = $validate->check($_POST, array(
                    'username' => array(
                        'required' => true,
                        'min' => 2,
                        'max' => 50
                    ),
                    'indexNumber' => array(
//                'required' => true,
                        'regexIndexNumber' => 'indexNumber',
                        'min' => 8
                    ),
                    'fname' => array(
                        'required' => true,
                        'regexString' => 'fname',
                        'min' => 2,
                        'max' => 20
                    ),
                    'lname' => array(
                        'required' => true,
                        'regexString' => 'lname',
                        'min' => 2,
                        'max' => 20
                    ),
                    'email' => array(
                        'required' => true,
                        'regexEmail' => 'email',
                        'min' => 2,
                        'max' => 100
                    ),
                    'nic' => array(
                        'required' => true,
                        'regexNic' => 'nic',
                        'min' => 10
                    ),
                    'dob' => array(
                        'required' => true,
                    ),
                    'year' => array(
                        'required' => true,
                        'regexInt' => 'year',
                        'min' => 1
                    )
                ));

                if($validation->passed()){
                    $tdb = DB::getInstance();
                    $tdb->query('UPDATE users SET username = ?,indexNumber = ?,fname = ?,lname = ?,email = ?, phone = ?,nic = ?,dob = ?,year = ?,active = ? WHERE id = ?',array());


                            $username = Input::get('username');
                            $indexNumber = Input::get('indexNumber');
                            $fname = Input::get('fname');
                            $lname = Input::get('lname');
                            $email = Input::get('email');
                            $nic = Input::get('nic');
                            $dob = Input::get('dob');
                            $year = Input::get('year');

//                Session::flash('home', 'Your details have been updated.');
//                Redirect::to('index.php');
                        echo "<script>alert('Your details updated successfully.');window.location.href='admin_updateUser.php?username=$searchUser'</script>";

                } else {
                    $str = "";
                    foreach ($validation->errors() as $error) {
                        $str .= $error;
                        $str .= '\n';
                    }
                    echo '<script type="text/javascript">alert("' . $str . '")</script>';
                }
            }
        }
        ?>
        <!--            -->
        <div class="jumbotron col-sm-8">
            <div id="updateForm">
                <form action="" method="post" xmlns="http://www.w3.org/1999/html">
                    <h3><strong>Update User <?php echo $searchUser?></strong></h3>
                    <div class="gap">
                        <label>Username</label>
                        <input class="form-control" type="text" name="username"  value="<?php echo escape($u_user->data()->username); ?>">
                    </div>
                    <div class="gap">
                        <label>Index Number</label>
                        <input class="form-control" type="number" name="indexNumber" value="<?php echo escape($u_user->data()->indexNumber); ?>">
                    </div>
                    <div class="gap">
                        <label>First Name</label>
                        <input class="form-control" type="text" name="fname" value="<?php echo escape($u_user->data()->fname); ?>">
                    </div>
                    <div class="gap">
                        <label>Last Name</label>
                        <input class="form-control" type="text" name="lname" value="<?php echo escape($u_user->data()->lname); ?>">
                    </div>
                    <div class="gap">
                        <label>E-mail</label>
                        <input class="form-control" type="email" name="email" value="<?php echo escape($u_user->data()->email); ?>">
                    </div>
                    <div class="gap">
                        <label>NIC</label>
                        <input class="form-control" type="text" name="nic" value="<?php echo escape($u_user->data()->nic);?>">
                    </div>
                    <div class="gap">
                        <label>Date of birth</label>
                        <input class="form-control" type=date name="dob" value="<?php echo escape($u_user->data()->dob);?>">
                    </div>
                    <div class="gap">
                        <label>Academic Year</label>
                        <input class="form-control" type="number" name="year" value="<?php echo escape($u_user->data()->year);?>">
                    </div>
                    <input class="btn btn-default" id="submit" type="submit" value="Update" onclick="return confirm('Are you sure?');">
                    <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
                </form>
                <br>
                <div class="inline">
                    <div class="col-sm-6">
                        <a href=""><strong>Change Password >></strong></a>
                    </div>
                    <div class="col-sm-6">
                        <a href=""><strong>Change Mobile Number >></strong></a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<?php
include "footer.php";
?>
</body>
</html>