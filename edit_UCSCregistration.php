<?php
/**
 * Created by PhpStorm.
 * User: lasith-niro
 * Date: 16/10/15
 * Time: 19:59
 */

require_once 'core/init.php';
require 'Files/accessFile.php';
?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <title>Update UCSC Registration | Page</title>
        <?php include 'headerScript.php'?>
    </head>
<body>

<?php
include "header.php";
?>
<div class="backgroundImg container-fluid">
    <?php
    include "adminSidebar.php";
    ?>
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
    $inFile = $fObject->read('Files/data_UCSCregistration');
    $inAmount = $inFile[0];
    $inData = $inFile[1];


    if(Input::exists()){
        if(Token::check(Input::get('token'))) {
            $newDate= Input::get('date');
            $newAmount=Input::get('amount');

            $outData = $newAmount . " " . $newDate;
            $fObject->write('Files/data_UCSCregistration', $outData);
            Redirect::to('edit_UCSCregistration.php');
        }
    }
?>

<form action="" method="post">
    <h3><strong>Update UCSC Registration</strong></h3>
    <div class="gap">
        <label>Closing Date</label>
        <input class="form-control" type="date" name="date" id="date" value="<?php echo($inData)?>">
    </div>

    <div class="gap">
        <label>Payment Amount</label>
        <input class="form-control" type="text" name="amount" id="amount" value="<?php echo($inAmount)?>" >
    </div>

    <input class="btn btn-default" type="submit" value="Save">
    <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
</form>
        <button class="btn btn-primary btn-xs col-sm-2" style="float: right" onclick="window.location.href='editPayment.php'"><< Back</button>
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