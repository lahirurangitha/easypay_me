 <?php
/**
 * Created by PhpStorm.
 * User: Lasith Niroshan
 * Date: 5/23/2015
 * Time: 1:44 PM
 */

require_once 'core/init.php';
 $user = new User();
 if(!$user->isLoggedIn()){
     Redirect::to('index.php');
 }
 ?>
 <!DOCTYPE html>
 <html lang="en">
 <head>
     <title>Update | Page</title>
     <?php include 'headerScript.php'?>
 </head>

 <body>

 <?php
 include "header.php";
 ?>
 <div class="backgroundImg container-fluid">
     <?php
     if(isset($_SESSION['student'])&&$_SESSION['student']==true){
		include "studentSidebar.php";
	}elseif(isset($_SESSION['admin'])&&$_SESSION['admin']==true){
		include "adminSidebar.php";
	}elseif(isset($_SESSION['coord'])&&$_SESSION['coord']==true){
		include "coordinatorSidebar.php";
	}

     ?>
     <br>
     <div class="jumbotron col-sm-5 col-sm-offset-1">
         <?php

//checking if the user already logged in


if(Input::exists()){
    if(Token::check(Input::get('token'))){
        $validate = new Validate();
        if(!$_SESSION['student']){
            $validation = $validate->check($_POST, array(
                'username' => array(
                    'required' => true,
                    'min' => 2,
                    'max' => 50
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
                )
            ));
        }else{
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
        }
        if($validation->passed()){
            if(!$_SESSION['student']){
                try{
                    $user->update(array(
                        'username' => Input::get('username'),
                        'indexNumber' => 0,
                        'fname' => Input::get('fname'),
                        'lname' => Input::get('lname'),
//                    'phone' => Input::get('phone'),
                        'email' => Input::get('email'),
                        'nic' => Input::get('nic'),
                        'dob' => 0,
                        'year' => 0
                    ));
//                Session::flash('home', 'Your details have been updated.');
//                Redirect::to('index.php');
                    echo "<script>alert('Your details updated successfully.');window.location.href='update.php'</script>";
                } catch(Exception $err) {
                    die($err->getMessage());
                }
            }else{
                try{
                    $user->update(array(
                        'username' => Input::get('username'),
                        'indexNumber' => Input::get('indexNumber'),
                        'fname' => Input::get('fname'),
                        'lname' => Input::get('lname'),
//                    'phone' => Input::get('phone'),
                        'email' => Input::get('email'),
                        'nic' => Input::get('nic'),
                        'dob' => Input::get('dob'),
                        'year' => Input::get('year')
                    ));
//                Session::flash('home', 'Your details have been updated.');
//                Redirect::to('index.php');
                    echo "<script>alert('Your details updated successfully.');window.location.href='update.php'</script>";
                } catch(Exception $err) {
                    die($err->getMessage());
                }
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

}
?>

         <div id="updateForm">
             <form action="" method="post" xmlns="http://www.w3.org/1999/html">
                 <h3><strong>Update</strong></h3>
                 <div class="gap">
                     <label>Username</label>
                     <input class="form-control" type="text" name="username"  value="<?php echo escape($user->data()->username); ?>">
                 </div>
                 <?php
                 if($_SESSION['student']) {
                     ?>
                     <div class="gap">
                         <label>Index Number</label>
                         <input class="form-control" type="number" name="indexNumber"
                                value="<?php echo escape($user->data()->indexNumber); ?>">
                     </div>
                 <?php
                 }
                 ?>
                 <div class="gap">
                     <label>First Name</label>
                     <input class="form-control" type="text" name="fname" value="<?php echo escape($user->data()->fname); ?>">
                 </div>

                 <div class="gap">
                     <label>Last Name</label>
                     <input class="form-control" type="text" name="lname" value="<?php echo escape($user->data()->lname); ?>">
                 </div>

                 <div class="gap">
                     <label>E-mail</label>
                     <input class="form-control" type="email" name="email" value="<?php echo escape($user->data()->email); ?>">
                 </div>

                 <div class="gap">
                     <label>NIC</label>
                     <input class="form-control" type="text" name="nic" value="<?php echo escape($user->data()->nic);?>">
                 </div>
                 <?php
                 if($_SESSION['student']) {
                 ?>
                 <div class="gap">
                     <label>Date of birth</label>
                     <input class="form-control" type=date name="dob" value="<?php echo escape($user->data()->dob);?>">
                 </div>

                 <div class="gap">
                     <label>Academic Year</label>
                     <input class="form-control" type="number" name="year" value="<?php echo escape($user->data()->year);?>">
                 </div>
                 <?php
                 }
                 ?>

                 <input class="btn btn-default" id="submit" type="submit" value="Update">

                 <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
             </form>
             <br>
             <div class="inline">
             <div class="col-sm-6">
                 <a href="changepassword.php"><strong>Change Password >></strong></a>
             </div>
             <div class="col-sm-6">
                 <a href="changephonenumber.php"><strong>Change Mobile Number >></strong></a>
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