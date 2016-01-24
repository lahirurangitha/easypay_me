<?php
/**
 * Created by PhpStorm.
 * User: lasith-niro
 * Date: 13/09/15
 * Time: 23:29
 */
/*
     ######    ##     ####    #   #  #####     ##     #   #   ####   #
     #        #  #   #         # #   #    #   #  #     # #   #       #
     #####   #    #   ####      #    #    #  #    #     #     ####   #
     #       ######       #     #    #####   ######     #         #  #
     #       #    #  #    #     #    #       #    #     #    #    #  #
     ######  #    #   ####      #    #       #    #     #     ####   ######
*/

require_once 'core/init.php';
require 'payment/encrypt.php';
require 'Files/accessFile.php';
?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <title>Payment | Page</title>
        <?php include 'headerScript.php'?>
    </head>
<body>

<?php
include "header.php";
?>
<div class="backgroundImg container-fluid">
    <?php
    include "studentSidebar.php";
    ?>
    <br>
    <div class="jumbotron col-sm-6 col-sm-offset-1">
        <h3><strong>Repeat Exam Payment</strong></h3>
<?php

//echo "The 2 digit representation of current month with leading zero is: " . date("m") . '<br />';

$encryptObject = new encrypt();
$tra = new Transaction();
$fileObject = new accessFile();
$dataArray = $fileObject->read('Files/data_repeatExam');
$urlArray = $fileObject->read_newLine('Files/URLs');
$user = new User();

$oneAmount = $dataArray[0];
$time = $_SESSION['num'];

$amount= $oneAmount * $time;

//echo $amount;
if(!$user->isLoggedIn()) {
    Redirect::to('index.php');
}

$date1 = strtotime($dataArray[1]);
$date2 = time();
$dayLimit = $date1-$date2;
$dayLimit = floor($dayLimit/(60*60*24));

if($dayLimit<0){
//    echo "payment is closed!";
    echo "<div class='alert alert-danger'>Payment is closed.</div>";
}else {
//    echo "You have {$dayLimit} days for this payment." . '<br />';
    echo "<div class='text text-info'>* You have {$dayLimit} days for this payment.</div>";
//    echo "You have to pay Rs.20.00 to this payment.";
$myfile = fopen("Files/data_repeatExam", "r") or die("Unable to open file!");
while(!feof($myfile)) {
    $line = fgets($myfile);
    $arr = explode(' ',trim($line));
}
fclose($myfile);
$sb = $_SESSION['num'];
$amt = floatval($sb*$arr[0]);
    echo "<div class='text text-info'>* You have applyed for $sb subject(s). Total amount is Rs.$amt.00.</div>";
    $prefix = 'easypayID_';
    $lastID = (integer)$tra->lastID();
    $newID = $lastID + 1;
    $transactionID = $tra->encodeEasyID($prefix, $newID);
    //$transactionID = $_SESSION['deID'];
//    echo $transactionID . '<br />';

    $merchantCode = 'TESTMERCHANT';
    $transactionAmount = $amount;
    $returnURL = $urlArray[0];
    $Invoice = $encryptObject->encode($merchantCode, $transactionID, $transactionAmount, $returnURL);

    $tra->createTEMP(array(
        'userID' => $user->data()->id
    ));



    //$_SESSION['uID'] = $uID;
    //$_SESSION['reg'] = $uRegID;
    $_SESSION['type'] = 3;
    ?>

    <form action="https://ipg.dialog.lk/ezCashIPGExtranet/servlet_sentinal" method="post" target="_blank">
        <br>
        <input class="btn btn-default btn-lg" type="submit" value="Pay via eZcash">
        <input type="hidden" value='<?php echo $Invoice; ?>' name="merchantInvoice">
        <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
    </form>
    </div>
</div>
<?php
}

        include "footer.php";
        ?>

</body>
</html>