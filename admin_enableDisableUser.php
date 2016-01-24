<?php
/**
 * Created by PhpStorm.
 * User: lahiru
 * Date: 10/14/2015
 * Time: 8:13 PM
 */

require_once 'core/init.php';
$user  = new User();
if(!$user->isLoggedIn()){Redirect::to('index.php');}
if(!$user->hasPermission('admin')){Redirect::to('index.php');}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Account Manager | Page</title>
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
    <div class="container col-sm-9">
        <br>
        <div id="appTable" class="container col-sm-12 ">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3><strong>Users</strong></h3>
                </div>
                <div class="panel-body">
                    <div class="pre-scrollable">
                        <table class="table table-striped table-bordered table-hover">

                            <?php
                            //                        $appDet = DB::getInstance()->get('repeat_exam',array('adminStatus','=',0));
                            $userDet = DB::getInstance()->query('SELECT * FROM users',array());
                            if(!$userDet->count()){
                                echo '<div class="alert alert-info">No accounts disabled</div>';
                            }else{
                            ?>
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Username</th>
                                <th>Index Number</th>
<!--                                <th>First Name</th>-->
<!--                                <th>Last Name</th>-->
<!--                                <th>Email</th>-->
<!--                                <th>Mobile Number</th>-->
<!--                                <th>NIC</th>-->
<!--                                <th>Date of Birth</th>-->
<!--                                <th>Year</th>-->
                                <th>User Type</th>
                                <th>Active / Deactivated</th>
                                <th>Settings</th>

                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $counter = 0;
                            foreach($userDet->results() as $t){
                                //                                                           print_r($t);
                                //                                                           echo'<br>';
                                $counter+=1;
                                $id = $t->id;
                                echo"<tr>";
                                echo "<td>".$counter."</td>";
                                echo "<td>".$t->username."</td>";
                                echo "<td>".$t->indexNumber."</td>";
//                                echo "<td>".$t->fname."</td>";
//                                echo "<td>".$t->lname."</td>";
//                                echo "<td>".$t->email."</td>";
//                                echo "<td>".$t->phone."</td>";
//                                echo "<td>".$t->nic."</td>";
//                                echo "<td>".$t->dob."</td>";
//                                echo "<td>".$t->year."</td>";
//                                echo "<td>".$t->group."</td>";
                                if($t->group == 1){
                                    echo "<td>Student</td>";
                                }elseif($t->group == 2){
                                    echo "<td>Administrator</td>";
                                }elseif($t->group == 3){
                                    echo "<td>Coordinator</td>";
                                }

                                if($t->active == 1){
                                    echo "<td>Active</td>";
                                }else{
                                    echo "<td>Deactivated</td>";
                                }


                                if($t->username == $user->data()->username){
                                    echo "<td>-</td>";
                                }elseif($t->active == 1){
                                    echo "<td><a onclick='return confirm(\"You are deactivating this account. Are you sure?\")' href='admin_enableDisableUserStatusUpdater.php?username=$t->username&active=$t->active'>Deactivate</a></td>";
                                }else{
                                    echo "<td><a onclick='return confirm(\"You are activating this account. Are you sure?\")' href='admin_enableDisableUserStatusUpdater.php?username=$t->username&active=$t->active'>Activate</a></td>";
                                }
                                echo "</tr>";
                            }
                            }?>
                            </tbody>
                        </table>
                    </div>
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