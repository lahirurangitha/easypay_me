<?php
/**
 * Created by PhpStorm.
 * User: lasith-niro
 * Date: 16/10/15
 * Time: 20:00
 */

require_once 'core/init.php';
require 'Files/accessFile.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Update Admission Details | Page</title>
    <?php include 'headerScript.php'?>
</head>
<body>
<?php
include "header.php";
?>
<div class="backgroundImg container-fluid">
<?php include 'adminSidebar.php'?>
    <br>
    <div class="jumbotron col-sm-5 col-sm-offset-1">
        <?php

        $user = new User();
        $fObject = new accessFile();
        if(!$user->isLoggedIn()){
            Redirect::to('index.php');
        }
        //check for admin
        if ($user->hasPermission('admin')) {
        $inFile = $fObject->read('Files/admissionActivate');
        $inDate1 = $inFile[0];
        $inDate2 = $inFile[1];


        if(Input::exists()){
            if(Token::check(Input::get('token'))) {
                $newDate= Input::get('date1');
                $newAmount=Input::get('date2');

                $outData = $newDate . " " . $newAmount;
                $fObject->write('Files/admissionActivate', $outData);
                Redirect::to('edit_admissionActivation.php'); //refresh the page

            }
        }
        ?>
        <h3><strong>Update Admission Details</strong></h3>
        <form action="" method="post">
            <div class="gap">
                <label>Starting Date</label>
                <input class="form-control" type="date" name="date1" id="date1" value="<?php echo($inDate1)?>">
            </div>

            <div class="gap">
                <label>Closing Date</label>
                <input class="form-control" type="date" name="date2" id="date2" value="<?php echo($inDate2)?>" >
            </div>

            <input class="btn btn-default" type="submit" value="Save">
            <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
        </form>
    </div>
</div>
<?php
} else {
    Redirect::to('index.php');
}
include "footer.php";
?>

</body>
</html>
