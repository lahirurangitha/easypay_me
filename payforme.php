<?php
/**
 * Created by PhpStorm.
 * User: lasith-niro
 * Date: 28/09/15
 * Time: 22:27
 */
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
    <br>
    <div id="HomeForm" class="jumbotron col-lg-6 col-lg-offset-3">
        <h3>Select your Payment</h3>
        <div>
            <a  href="p_UCSCregistration.php">Register to UCSC</a>
            <br><br>
            <a href="p_newAcaYear.php">Register for new Academic year</a>
            <br><br>
            <a href="p_repeatExamForm.php">Pay Repeat Exam Fees</a>
        </div>
    </div>
</div>


<?php
include "footer.php";
?>

</body>
</html>