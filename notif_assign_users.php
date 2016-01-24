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
        <script type="text/javascript">

        </script>
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
<div class="container col-sm-9">
    <div class="pre-scrollable" style="max-height: 200px">
<?php
$user = new User();
$notification = new Notification();
$send_date = date("d/m/y h:i:s");
if(!$user->isLoggedIn()){Redirect::to('index.php');}
//check for admin
if (!$user->hasPermission('admin')) {Redirect::to('index.php');}
$myNotifyID = $_GET['id'];
$_SESSION['notfID'] = $myNotifyID;
$oldID = $notification->getLastNotificationID();
$newID = $oldID+1;

if(isset($_POST['Submit-batch'])){
    $Syear = Input::get('Nyear');
//    print_r($Syear);
    foreach((array)$Syear as $y){
        $dataSt = $notification->getBatch($y);
        foreach((array)$dataSt as $d){
            $userID = $d->id;
            //$newID=$newID+1;
            $notification->insertUN(array(
                    'nID'=> $myNotifyID,
                    'uID' => $userID,
                    'send_date' => $send_date
                )
            );
        }
    }
}

//code for repeat exam student part
if(Input::get('Submit-repeat-all-student')){
    if(Input::exists()){
        $dataSet = $notification->getRepeatStudent();
//    print_r($dataSet);
        foreach((array)$dataSet as $d){
            $index = $d->index_no;
            $userObjet = $notification->getUserID($index);
            foreach((array)$userObjet as $uo){
                $userID = $uo->id;
                $newID=$newID+1;
//            echo $userID."<br />";
              $notification->insertUN(array(
                    'nID'=> $myNotifyID,
                    'uID' => $userID,
                    'send_date' => $send_date
                )
            );
        }
    }
}
}

if(isset($_GET['user'])){
    $userID = $_GET['user'];
    $notification->insertUN(array(
            'nID'=> $myNotifyID,
            'uID' => $userID,
            'send_date' => $send_date
        )
    );
}

?>
    </div>
    <br>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3><strong>Assign Users</strong></h3>
        </div>
        <div class="panel-body">
            <div class="col-sm-4">
                <form name="batch" action="" method="post">
                    <h4><strong>Select Year Wise</strong></h4>
                    <input type="checkbox" name="Nyear[]" value="1" /> First Years <br>
                    <input type="checkbox" name="Nyear[]" value="2" /> Second Years <br>
                    <input type="checkbox" name="Nyear[]" value="3" /> Third Years <br>
                    <input type="checkbox" name="Nyear[]" value="4" /> Fourth Years <br>
                    <input type = "hidden" name="token_batch" value="<?php echo Token::generate(); ?>">
                    <input class="btn btn-default" type="submit" name="Submit-batch" value="Submit" />
                </form>
            </div>
            <div class="container col-sm-4">
                <form name="repeat-all-student" action="" method="post">
                    <h4><strong>All Repeat Students</strong></h4>
                    <input type="checkbox" name="repStu" value="<? echo escape('1')?>" />All repeat students<br>
                    <input type = "hidden" name="token_repeat-all" value="<?php echo Token::generate(); ?>">
                    <input class="btn btn-default" type="submit" name="Submit-repeat-all-student" value="Submit" />
                </form>
            </div>
            <div class="container col-sm-4">
                <form name="selected-student" action="" method="post">
                    <h4><strong>Select Specific Student</strong></h4>
                    <div>
                        <div>
                            <input class="form-control" type="text" id="search" placeholder="Enter username to search" autocomplete="off" name="search" value="<?php echo Input::get('search')?>" onkeyup="autoSuggest('result','search_for_notification.php');"  />
                            <div class="pre-scrollable" style="max-height: 200px">
                                <ul id="result" class="nav" ></ul>
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
</div>
</div>

<?php
include "footer.php";
?>

</body>
</html>