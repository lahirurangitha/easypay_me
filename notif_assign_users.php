<?php
/**
 * Created by PhpStorm.
 * User: lasith-niro
 * Date: 18/10/15
 * Time: 14:25
 */
require_once 'core/init.php';
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <title>Notification | Page</title>
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
?>
    <br>
<div class="container col-lg-9">
<?php
$user = new User();
$notif = new Notification();
$send_date = date("d/m/y h:i:s");
if(!$user->isLoggedIn()){
    Redirect::to('index.php');
}
$myNotifyID = $_SESSION['dID'];
//check for admin
if (!$user->hasPermission('admin')) {
    Redirect::to('index.php');
}
if(Input::get('Submit-batch')) {
    if(Input::exists()){
        $Syear = Input::get('Nyear');
        //print_r($Syear);
        foreach($Syear as $y){
            $dataSt = $notif->getBatch($y);
            //print_r($Syear);
//            print_r($dataSt);
            foreach($dataSt as $d){
                $userid = $d->id;
                //$notif->sendNotification($notif,$userid,$myNotifyID);
                if(!$notif->checkWithUser($d->id, $myNotifyID)){
                    $notif->assignBatch(array(
                        'nID' => $myNotifyID,
                        'uID' => $userid ,
                        'send_date' => $send_date
                    ));
                } else {
                    $tmpUser = new User();
                    $tmpUser->find($d->id);
                    echo "<div class='alert alert-warning'>This notification has been already send to $tmpUser->data()->username</div>";
//                    continue;
                }
            }
        }
    }
}

if(isset($_GET['user'])){
    $searchUserID = $_GET['user'];
    if(!$notif->checkWithUser($searchUserID, $myNotifyID)){
        $notif->assignBatch(array(
            'nID' => $myNotifyID,
            'uID' => $searchUserID,
            'send_date' => $send_date
        ));
    } else {
        $tmpUser = new User();
        $tmpUser->find($searchUserID);
        echo "<div class='alert alert-warning'>This notification has been already send to $tmpUser->data()->username </div>";
//                    continue;
    }
}

if(Input::get('Submit-repeat-all-student')){
    if(Input::exists()){
        $dataSt = $notif->getRepeatStudent();
        foreach($dataSt as $d){
            $userid = $d->id;
            //$notif->sendNotification($notif,$userid,$myNotifyID);
            if(!$notif->checkWithUser($d->id, $myNotifyID)){
                $notif->assignBatch(array(
                    'nID' => $myNotifyID,
                    'uID' => $userid,
                    'send_date' => $send_date
                ));
            } else {
                $tmpUser = new User();
                $tmpUser->find($d->id);
                echo "<div class='alert alert-warning''>This notification has been already send to $tmpUser->data()->username </div>";
//                    continue;
            }
        }
    }
}


?>
    <div class="container col-lg-12">
        <label for="text1">Send to<br></label>
    </div>
<div class="container col-lg-3">
    <form name="batch" action="" method="post">
        <h4> Year wise </h4>
        <li><input type="checkbox" name="Nyear[]" value="<? echo escape('1')?>" /> First Years <br></li>
        <li><input type="checkbox" name="Nyear[]" value="<? echo escape('2')?>" /> Second Years <br></li>
        <li><input type="checkbox" name="Nyear[]" value="<? echo escape('3')?>" /> Third Years <br></li>
        <li><input type="checkbox" name="Nyear[]" value="<? echo escape('4')?>" /> Fourth Years <br></li>
        <input type = "hidden" name="token_batch" value="<?php echo Token::generate(); ?>">
        <input class="btn btn-default" type="submit" name="Submit-batch" value="Submit" />
    </form>
</div>

    <div class="container col-lg-3">
        <form name="repeat-all-student" action="" method="post">
            <h4>All repeat students: </h4>
            <li><input type="checkbox" name="repStu" value="<? echo escape('1')?>" />All repeat students<br></li>
            <input type = "hidden" name="token_repeat-all" value="<?php echo Token::generate(); ?>">
            <input class="btn btn-default" type="submit" name="Submit-repeat-all-student" value="Submit" />
        </form>
    </div>
    <div class="container col-lg-4 ">
    <form name="selected-student" action="" method="post">
        <h4>Selected student</h4>
        <div>
            <div>
                <input class="form-control" type="text" id="search" placeholder="Enter username to search" autocomplete="off" name="search" value="<?php echo Input::get('search')?>" onkeyup="autoSuggest('result','search_for_notification.php');"  />
                <div>
                    <ul id="result" class="nav navbar" ></ul>
                </div>
            </div>
            <div>
                <?php
                if(isset($msg)){
                    echo "<div class='alert alert-danger'>$msg</div>";
                }
                ?>
            </div>
        </div>
        <input type = "hidden" name="token_selected_student" value="<?php echo Token::generate(); ?>">
    </form>
    </div>
    </div>
</div>

<?php
if(isset($_POST['user'])){
    $item = $_POST['user'];
    $notif->sendNotification($notif,$item,$myNotifyID,$send_date);
}

include "footer.php";
?>

</body>
</html>