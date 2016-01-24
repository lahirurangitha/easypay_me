<?php

require_once 'core/init.php';?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Contact | Page</title>
    <?php include 'headerScript.php'?>
</head>
<body>

<?php
include "header.php";
?>
<div class="backgroundImg container-fluid">
<div class="container">
    <br>
    <div class="jumbotron col-sm-6">
        <h3><strong>Contact Form</strong></h3>
    <form class="form-horizontal" id="contact_form" action="ContactFormHandler.php" method="POST" enctype="multipart/form-data">

        <label for="name">Name:</label>
        <div class="gap">
            <input required id="name" class="form-control" name="name" type="text" value="" size="30" />
        </div>

        <label for="email">Email:</label>
        <div class="gap">
            <input required id="email" class="form-control" name="email" type="email" value="" size="30" />
        </div>

        <label for="message">Message:</label>
        <div class="gap">
            <textarea required id="message" class="form-control" name="message" rows="7" cols="30"></textarea>
        </div>
        <input class="btn btn-primary" id="submit_button" name="Contact_submit" type="submit" value="Send" />
    </form>
    </div>

<div class="jumbotron col-sm-5 col-sm-offset-1">
    <div class="jb-text">
        <h3><div class="label label-primary">Contact Us </div></h3>
    <h3><strong>Easy Pay</strong></h3>
	<h4>UCSC Building Complex</h4>
    <h4>35, Reid Avenue, Colombo 07, Sri Lanka.</h4>
    <h4>Contact Easypay: 0112581245</h4>
    <h4>Email: easypaysl2@gmail.com</h4>
    </div>
</div>
</div>
</div>
<?php
include "footer.php";
?>
</body>
</html>