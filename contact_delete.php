<?php
require_once 'core/init.php';
$user = new User();
if(!$user->isLoggedIn()){
    Redirect::to('index.php');
}
//check for admin
if ($user->hasPermission('admin')) {
//    $not = new Notification();
    $deleteID = $_GET['cID'];
    $delete = DB::getInstance()->query('DELETE FROM mycontacts WHERE ContactID = ?',array($deleteID));
    if($delete->count()>0){
        echo "<script>alert('Notification deleted successfully');window.location.href='email_notify.php'</script>";
    }else{
        echo "<script>alert('Deletion failed.');window.location.href='email_notify.php'</script>";
    }
//	$not->deleteContactEmail($deleteID);
//    Redirect::to('email_notify.php');
} else {
    Redirect::to('index.php');
}
