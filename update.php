 <?php
/**
 * Created by PhpStorm.
 * User: Lasith Niroshan
 * Date: 5/23/2015
 * Time: 1:44 PM
 */

require_once 'core/init.php';
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
     <br>
     <div class="jumbotron col-lg-5 col-lg-offset-3">
         <?php

//checking if the user already logged in
$user = new User();
if(!$user->isLoggedIn()){
    Redirect::to('index.php');
}

if(Input::exists()){
    if(Token::check(Input::get('token'))){
        $validate = new Validate();
        $validation = $validate->check($_POST, array(
           'username' => array(
                'required' => true,
                'min' => 2,
                'max' => 50
           ),
           'regNumber' => array(
                'required' => true,
                'regexRegistrationNumber' => 'regNumber',
                'min' => 9
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
            try{
                $user->update(array(
                    'username' => Input::get('username'),
                    'regNumber' => Input::get('regNumber'),
                    'fname' => Input::get('fname'),
                    'lname' => Input::get('lname'),
//                    'phone' => Input::get('phone'),
                    'email' => Input::get('email'),
                    'nic' => Input::get('nic'),
                    'dob' => Input::get('dob'),
                    'year' => Input::get('year')
                ));
                Session::flash('home', 'Your details have been updated.');
                Redirect::to('index.php');
            } catch(Exception $err) {
                die($err->getMessage());
            }
        } else {
            foreach ($validation->errors() as $er) {
//                echo $er, '<br />';
                ?>
                <script type="text/javascript"> alert(" Sorry, Update failed. <?php echo $er ,'<br />';?>")</script>
 <?php
            }
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
                 <div class="gap">
                     <label>Registration Number</label>
                     <input class="form-control" type="string" name="regNumber" value="<?php echo escape($user->data()->regNumber); ?>">
                 </div>
                 <div class="gap">
                     <label>First Name</label>
                     <input class="form-control" type="string" name="fname" value="<?php echo escape($user->data()->fname); ?>">
                 </div>

                 <div class="gap">
                     <label>Last Name</label>
                     <input class="form-control" type="string" name="lname" value="<?php echo escape($user->data()->lname); ?>">
                 </div>

                 <div class="gap">
                     <label>E-mail</label>
                     <input class="form-control" type="email" name="email" value="<?php echo escape($user->data()->email); ?>">
                 </div>

                 <div class="gap">
                     <label>NIC</label>
                     <input class="form-control" type="string" name="nic" value="<?php echo escape($user->data()->nic);?>">
                 </div>

                 <div class="gap">
                     <label>Date of birth</label>
                     <input class="form-control" type=date name="dob" value="<?php echo escape($user->data()->dob);?>">
                 </div>

                 <div class="gap">
                     <label>Academic Year</label>
                     <input class="form-control" type="string" name="year" value="<?php echo escape($user->data()->year);?>">
                 </div>

                 <input class="btn btn-default" id="submit" type="submit" value="Update">

                 <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
             </form>
         </div>
     </div>
 </div>
         <?php
         include "footer.php";
         ?>

 </body>
 </html>