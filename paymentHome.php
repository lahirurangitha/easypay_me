
<?php
require_once 'core/init.php';

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <title>Payment | Page</title>
    <?php include 'headerScript.php'?>
</head>

<body>
<div id="mainWrapper">
    <?php
    include "header.php";
    ?>
    <div class="backgroundImg container-fluid">
        <?php
        include "studentSidebar.php";
        ?>
        <br>
        <div id="HomeForm" class="jumbotron col-sm-5 col-sm-offset-1">
            <h3><strong>To whom do you want to pay?</strong></h3>
            <div id="fonts" >
                <a href="payforme.php"> Pay for me <br></a>
                <br>
                <a href="payForOther.php"> Pay for other person </a>
            </div>
        </div>
    </div>

</div>


<?php
include "footer.php";
?>

</body>
</html>