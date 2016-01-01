<?php
/**
 * Created by PhpStorm.
 * User: lasith-niro
 * Date: 13/09/15
 * Time: 23:28
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
<?php

$encryptObject = new encrypt();
$tra = new Transaction();
$fileObject = new accessFile();
$dataArray = $fileObject->read('Files/data_UCSCregistration');
$urlArray = $fileObject->read_newLine('Files/URLs');
$user = new User();

$amount = $dataArray[0];
if(!$user->isLoggedIn()){
    Redirect::to('index.php');
}

$date1 = strtotime($dataArray[1]);
$date2 = time();
$dayLimit = $date1-$date2;
$dayLimit = floor($dayLimit/(60*60*24));

if($dayLimit<0){
//    echo "payment is closed!";
    echo "<div class='alert alert-danger'>Payment is closed</div>";
}else {
    if($user->data()->year == 1){
//        echo "You have {$dayLimit} days for this payment." . '<br />';
        echo "<div class='alert alert-info'>You have {$dayLimit} days for this payment</div>";
        $prefix = 'easyID_';
        $lastID = (integer)$tra->lastID();
        $newID = $lastID + 1;
        $transactionID = $tra->encodeEasyID($prefix, $newID);

        $merchantCode = 'TESTMERCHANT';
        $transactionAmount = $amount;
        $returnURL = $urlArray[0];
        $Invoice = $encryptObject->encode($merchantCode, $transactionID, $transactionAmount, $returnURL);
        $tra->createTEMP(array(
            'userID' => $user->data()->id
        ));

        $uNIC = $user->data()->nic;
        $regYear = date("Y") + 1;
        $_SESSION['type'] = 1;

//        echo "Your nic number is " . $uNIC . '<br /><br />';
        echo "<div class='alert alert-info'>Your nic number is $uNIC </div>";
        $uRegID = $user->data()->regNumber;
        if(!$uRegID){
//            echo "You have not submitted your registration number." . '<br />';
            echo "<div class='alert alert-danger'>You have not submitted your registration number.</div>";
        } else {
//            echo "Your registration number is " . $uRegID . '<br />';
            echo "<div class='alert alert-info'>Your registration number is $uRegID </div>";
        }
//        echo "You pay for {$regYear}." . '<br />';
        echo "<div class='alert alert-info'>You pay for {$regYear}</div>";
//        echo "You have to pay Rs.2500 for register." . '<br />';
        echo "<div class='alert alert-info'>You have to pay Rs.2500 for register.</div>";
        //$_SESSION['nic'] = $uNIC;
        //$_SESSION['reg'] = $uRegID;

        $en_transactionID = $tra->decodeEasyID($transactionID);
        $tra->createUCSCRegistration(array(
            'transactionID' => $en_transactionID,
            'regYear' => $regYear,
            'paymentStatus' => 0
        ))

    ?>



        <form action="https://ipg.dialog.lk/ezCashIPGExtranet/servlet_sentinal" method="post">
            <input type="submit" value="Pay via eZcash">
            <input type="hidden" value='<?php echo $Invoice; ?>' name="merchantInvoice">
            <input class="btn btn-default" type="hidden" name="token" value="<?php echo Token::generate(); ?>">
        </form>



    <?php
    } else {
//        echo "You cannot make this payment.";
        echo "<div class='alert alert-danger'>You cannot make this payment.</div>";
    }
}
    ?>
    </div>
</div>
<?php
include "footer.php";
?>

</body>
</html>