<?php
/**
 * Created by PhpStorm.
 * User: lasith-niro
 * Date: 28/09/15
 * Time: 22:27
 */
require_once 'core/init.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Payment | Page</title>
    <?php include 'headerScript.php'?>
</head>

<body>
<div>
    <?php
    include "header.php";
    ?>
</div>
<div class="backgroundImg container-fluid">
    <?php
    include "studentSidebar.php";
    ?>
    <br>
    <div id="HomeForm" class="jumbotron col-sm-6 col-sm-offset-1">
<!--      pay for other person check  -->
        <?php
        if(!isset($_SESSION['p4o']) || $_SESSION['p4o']==0){
            echo "<div style='float: right'><a href='payForOther.php' onclick=\"return confirm('Are you sure?')\">Pay For Other >></a></div>";
        }
        if(isset($_SESSION['p4o']) && $_SESSION['p4o']==1){
            echo "<div class='text text-info'><strong>You are paying for ".$_SESSION['payeeName'].". </strong><button class='btn btn-default btn-xs'><a href='payForOtherRemove.php' title='Click here to remove other person.'>I have changed my mind</a></button></div> ";
        }
        ?>
<!--        /payfor other person check-->
        <h3><strong>Payment Options</strong></h3>
        <div class="gap">
            <ul>
                <li><a  href="p_UCSCregistration.php">Register to UCSC</a></li>
                <li><a href="p_newAcaYear.php">Register for new Academic year</a></li>
                <li><a href="p_repeatExamForm.php">Pay Repeat Exam Fees</a></li>
            </ul>
        </div>
        <button class="btn btn-primary btn-xs col-sm-4" style="float: right" onclick="window.location.href='index.php'"><< Back to Dashboard</button>
    </div>
</div>



<?php
include "footer.php";
?>

</body>
</html>