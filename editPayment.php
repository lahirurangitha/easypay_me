<?php
/**
 * Created by PhpStorm.
 * User: lasith-niro
 * Date: 16/10/15
 * Time: 19:51
 */
require_once 'core/init.php';

?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <title>Update Payment | Page</title>
        <?php include 'headerScript.php'?>
    </head>
<body>
<div id="wrapper">
    <?php
    include "header.php";
    ?>
</div>
<div class="backgroundImg container-fluid">


<?php
include "adminSidebar.php";

$user = new User();
if(!$user->isLoggedIn()){
    Redirect::to('index.php');
}
//check for admin
if ($user->hasPermission('admin')) {
?>
    <br>
    <div class="jumbotron col-sm-5 col-sm-offset-1">
        <h3><strong>Update Payment Details</strong></h3>
        <div class="gap">
            <ul>
                <li><a href="edit_UCSCregistration.php">Register to UCSC</a></li>
                <li><a href="edit_newAcaYear.php">Register for new academic year</a></li>
                <li><a href="edit_repeatExam.php">Repeat exam payment</a></li>
            </ul>
        </div>

</div>

<?php
} else {
    Redirect::to('index.php');
}
?>
</div>
<?php
include "footer.php";
?>

</body>
</html>