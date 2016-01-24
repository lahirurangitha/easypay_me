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
        <h3><strong>Registration For New Academic Year</strong></h3>
        <?php
        //payfor other person check
        if(isset($_SESSION['p4o']) && $_SESSION['p4o']==1){
            echo "<div class='text text-info'><strong>You are paying for ".$_SESSION['payeeName'].". </strong><button class='btn btn-default btn-xs'><a href='payForOtherRemove.php' title='Click here to remove other person.'>I have changed my mind</a></button></div> ";
        }?>
        <div class="gap">
<?php
$encryptObject = new encrypt();
$tra = new Transaction();
$fileObject = new accessFile();
$dataArray = $fileObject->read('Files/data_newAcaYear');
$urlObject = $fileObject->read_newLine('Files/URLs');
$user = new User();

$amount = $dataArray[0];

if(!$user->isLoggedIn()){
    Redirect::to('index.php');
}

$prefix = 'easypayID_';
$lastID = (integer)$tra->lastID();
$newID = $lastID + 1;
$transactionID = $tra->encodeEasyID($prefix, $newID);
//echo $transactionID . '<br />';


$merchantCode = 'TESTMERCHANT';
$transactionAmount = $amount;
$returnURL = $urlObject[0];
$Invoice = $encryptObject->encode($merchantCode, $transactionID, $transactionAmount, $returnURL);

//echo $returnURL;
$tra->createTEMP(array(
    'userID' => $user->data()->id
));

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
    $uID = $user->data()->id;
    $uRegID = $user->data()->indexNumber;

    if(!$uRegID){
//        echo "You have not submitted your registration number." . '<br />';
        echo "<div class='alert alert-danger'>* You have not submitted your registration number.</div>";
    //    echo $uRegID . '<br />';
    } else {
//        echo "Your registration number is " . $uRegID . '<br />';
        echo "<div class='text text-info'>* Your index number is $uRegID.</div>";
    }
//    echo "You have to pay Rs.600 for register." . '<br />';
    $myfile = fopen("Files/data_newAcaYear", "r") or die("Unable to open file!");
    while(!feof($myfile)) {
        $line = fgets($myfile);
        $arr = explode(' ',trim($line));
    }
    fclose($myfile);
    echo "<div class='text text-info'>* You have to pay Rs.$arr[0] for register.</div>";

    $_SESSION['type'] = 2;
    $acaYear = date("Y");
    $de_transactionID = $tra->decodeEasyID($transactionID);
    //echo $de_transactionID;
    $tra->createNewAcademicYear(array(
        'transactionID' => $de_transactionID,
        'acaYear' => $acaYear,
        'paymentStatus' => 0
    ));

    ?>
    <form action="https://ipg.dialog.lk/ezCashIPGExtranet/servlet_sentinal" method="post" target="_blank">
        <br>
        <input class="btn btn-default btn-lg" type="submit" value="Pay via eZcash">
        <input type="hidden" value='<?php echo $Invoice; ?>' name="merchantInvoice">
        <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
    </form>

<?php
}
?>
    </div>
        <button class="btn btn-primary btn-xs col-sm-2" style="float: right" onclick="window.location.href='payforme.php'"><< Back</button>
    </div>
    </div>

<?php
include "footer.php";
?>
</body>
</html>