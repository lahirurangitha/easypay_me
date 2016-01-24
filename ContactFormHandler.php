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

<?php
if(isset($_POST['Contact_submit'])){
    $contactName = $_POST["name"];
    $contactEmail = $_POST["email"];
    $contactMessage = $_POST["message"];
    $servername = "localhost";
    $username = "root";
    $password = "";
    try {
        $conn = new PDO("mysql:host=$servername;dbname=easypay_db",$username,$password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//    echo "Connected successfully";
        $stmt = $conn->prepare("INSERT INTO mycontacts(
			ContactName,
			ContactEmail,
			contactMessage,
			ContactDateCreated
			)
			VALUES(
			'$contactName',
			'$contactEmail',
			'$contactMessage',
			NOW()
			)");
        if($stmt->execute()){
            echo "<script>alert('Your message was submitted.');window.location.href='contact.php'</script>";
        }
    }
    catch(PDOException $e)
    {
        echo "<script>alert('Connection failed.); </script>" ;
    }

    $conn = null;
}else{
    echo "<script>alert('Please fill the contact form and submit.');window.location.href='contact.php'</script>";
}

?>
</div>
<?php
include "footer.php";
?>
</body>
</html>



