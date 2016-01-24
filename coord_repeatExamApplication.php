<?php
/**
 * Created by PhpStorm.
 * User: lahiru
 * Date: 11/14/2015
 * Time: 6:52 PM
 */
require_once 'core/init.php';

$user  = new User();
if(!$user->isLoggedIn()){Redirect::to('index.php');}
if(!$user->hasPermission('coord')){Redirect::to('index.php');}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Repeat Exam Applications | page</title>
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
    if($_SESSION['admin']){
        include "adminSidebar.php";
    }elseif($_SESSION['coord']){
        include "coordinatorSidebar.php";
    }
    ?>
    <div class="container col-sm-9">
    <br>
        <div id="appTable" class="container col-sm-12 ">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3><strong>Repeat Exam Applications</strong></h3>
                </div>
                <div class="panel-body">
                <div class="pre-scrollable">
                    <table class="table table-striped table-bordered table-hover">

                        <?php
//                        $appDet = DB::getInstance()->get('repeat_exam',array('adminStatus','=',0));
                        $appDet = DB::getInstance()->query('SELECT * FROM repeat_exam WHERE adminStatus = 0 AND paymentStatus = 1',array());
                        if(!$appDet->count()){
                        echo '<div class="alert alert-info">No applications found</div>';
                        }else{
                        ?>
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Index Number</th>
                            <th>Subject Code</th>
                            <th>Subject Name</th>
                            <th>Assignment status</th>
                            <th>Accept/Reject</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $counter = 0;
                        foreach($appDet->results() as $t){
    //                                                           print_r($t);
    //                                                           echo'<br>';
                            $counter+=1;
                            $id = $t->id;
                            $username = $t->username;
                            echo"<tr>";
                            echo "<td>".$counter."</td>";
                            echo "<td>".$t->indexNumber."</td>";
                            echo "<td>".$t->subjectCode."</td>";
                            echo "<td>".$t->subjectName."</td>";
                            echo "<td>".$t->AssignmentComplete."</td>";
    //                        echo "<td><button><a>".$t->adminStatus."</a></button></td>";
//                            echo "<td><a href='coord_repeatExamStatusUpdater.php?id=".$id."&accept=true' onclick='return confirm(\"You are accepting this application. Are you sure?\");'><button class='btn btn-primary'>Accept</button></a> <a href='coord_repeatExamStatusUpdater.php?id=".$id."&reject=true' onclick='return confirm(\"You are rejecting this application. Are you sure?\");'><button class='btn btn-danger'>Reject</button></a></td>";
                            echo "<td><a href='coord_repeatExamStatusUpdater.php?username=" .$username."&subCode=$t->subjectCode&subName=$t->subjectName&id=".$id."&accept=true' onclick='return confirm(\"You are accepting this application. Are you sure?\");'><button class='btn btn-primary'>Accept</button></a> <a href='coord_repeatExamStatusUpdater.php?username=" .$username."&subCode=$t->subjectCode&subName=$t->subjectName&id=".$id."&reject=true' onclick='return confirm(\"You are rejecting this application. Are you sure?\");'><button class='btn btn-danger'>Reject</button></a></td>";
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