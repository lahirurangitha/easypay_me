<?php
/**
 * Created by PhpStorm.
 * User: lahiru
 * Date: 1/10/2016
 * Time: 10:50 AM
 */
require_once 'core/init.php';
$user  = new User();
if(!$user->isLoggedIn()){Redirect::to('index.php');}
if(!$user->hasPermission('admin')){Redirect::to('index.php');}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Repeat Exam Application | Page</title>
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
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3><strong>Rejected Repeat Exam Applications</strong></h3>
            </div>
            <div class="panel-body">
                <div class="pre-scrollable">
                    <table class="table table-striped table-bordered table-hover">

                        <?php
                        //                        $appDet = DB::getInstance()->get('repeat_exam',array('adminStatus','=',0));
                        $r_appDet = DB::getInstance()->query('SELECT * FROM repeat_exam r,repeatexam_notification n WHERE r.paymentStatus = 1 AND r.adminStatus = 2 AND r.id = n.nID ',array());
                        if(!$r_appDet->count()){
                            echo '<div class="alert alert-info">No rejected aplications found.</div>';
                        }else{
                        ?>
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Username</th>
                            <th> Subject Code</th>
                            <th>Subject Name</th>
                            <th>Edit</th>

                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $counter = 0;
                        foreach($r_appDet->results() as $t) {
                            //                                                           print_r($t);
                            //                                                           echo'<br>';
                            $counter += 1;
                            $id = $t->id;
                            echo "<tr>";
                            echo "<td>" . $counter . "</td>";
                            echo "<td>".$t->username."</td>";
                            echo "<td>".$t->subjectCode."</td>";
                            echo "<td>".$t->subjectName."</td>";
                            echo "<td><a onclick='return confirm(\"Are you sure?\")' href='admin_editRepeatExamApplication.php?username=$t->username&subjectCode=$t->subjectCode&rID=$t->id'>Edit</a></td>";

                        }
                        }
                            ?>
                        </tbody>
                    </table>
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