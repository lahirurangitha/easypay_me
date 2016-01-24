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
        <h3><strong>UCSC Registration</strong></h3>
        <?php
        //payfor other person check
        if(isset($_SESSION['p4o']) && $_SESSION['p4o']==1){
            echo "<div class='text text-info'><strong>You are paying for ".$_SESSION['payeeName'].". </strong><button class='btn btn-default btn-xs'><a href='payForOtherRemove.php' title='Click here to remove other person.'>I have changed my mind</a></button></div> ";
        }

        ?>

        <div class="gap">
        <span class="redColor"><strong>* This will not available for undergraduates who already registered with UCSC.</strong></span>
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
    echo "<div class='alert alert-danger'>Payment is closed.</div>";
}else {
    if($user->data()->year == 1){
//        echo "You have {$dayLimit} days for this payment." . '<br />';
        echo "<div class='text text-info'>* You have {$dayLimit} days for this payment.</div>";
        $prefix = 'easypayID_';
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
        echo "<div class='text text-info'>* Your nic number is $uNIC .</div>";
        $uRegID = $user->data()->indexNumber;
        if(!$uRegID){
//            echo "You have not submitted your registration number." . '<br />';
            echo "<div class='alert alert-danger'>* You have not submitted your registration number.</div>";
        } else {
//            echo "Your registration number is " . $uRegID . '<br />';
            echo "<div class='text text-info'>* Your registration number is $uRegID.</div>";
        }
//        echo "You pay for {$regYear}." . '<br />';
        echo "<div class='text text-info'>* You are paying for {$regYear}.</div>";
//        echo "You have to pay Rs.2500 for register." . '<br />';
        $myfile = fopen("Files/data_UCSCregistration", "r") or die("Unable to open file!");
        while(!feof($myfile)) {
            $line = fgets($myfile);
        $arr = explode(' ',trim($line));
        }
        fclose($myfile);
        echo "<div class='text text-info'>* You have to pay Rs.$arr[0] for register.</div>";
        //$_SESSION['nic'] = $uNIC;
        //$_SESSION['reg'] = $uRegID;

        $en_transactionID = $tra->decodeEasyID($transactionID);
        $tra->createUCSCRegistration(array(
            'transactionID' => $en_transactionID,
            'regYear' => $regYear,
            'paymentStatus' => 0
        ))

    ?>



        <form action="https://ipg.dialog.lk/ezCashIPGExtranet/servlet_sentinal" method="post" target="_blank">
            <br>
            <input class="btn btn-default btn-lg" type="submit" value="Pay via eZcash">
            <input type="hidden" value='<?php echo $Invoice; ?>' name="merchantInvoice">
            <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
        </form>



    <?php
    } else {
//        echo "You cannot make this payment.";
        echo "<div class='alert alert-danger'>You cannot make this payment.</div>";
    }
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