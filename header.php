<?php
/**
 * Created by PhpStorm.
 * User: lahiru
 * Date: 10/28/2015
 * Time: 10:41 AM
 */
require_once 'core/init.php';
ob_start();
$user = new user();
?>


<!--nav-->
<div id="navbars">
    <nav class="navbar navbar-default" style="margin: 0px;">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a href="homePage.php"><img id="img" src="images/logo.png" width="150px" ></a>
            </div>
            <div class="collapse navbar-collapse"  id="navbar-1" >
                <!--          inline form  -->
                <?php
                if(!$user->isLoggedIn()){
                    ?>
                    <div style="float: right">
                        <form action="homePage.php" method="POST" class="form-inline">
                            <div class="form-group">
                                <input class="form-control" required id="username" type="text" name="username" autocomplete="off" placeholder="Username"/>
                            </div>
                            <div class="form-group">
                                <input class="form-control" required id="password" type="password" name="password" autocomplete="off" placeholder="Enter password" size="25" maxlength="20"/>
                            </div>
                            <input class="btn btn-primary" type="submit" value="Sign in" name="inlinesubmit"/>
                            <div class="">
                                <input type="checkbox"  name="remember"/> Remember me
                                <a href="forgetpass.php" title="To recover your password, click here" >Forgot password?</a>
                            </div>
                        </form>
                    </div>
                <?php
                }
                ?>
                <!--           /inline form -->
                <ul class="nav navbar-nav">
                    <?php
                    if(!$user->isLoggedIn()){
                        ?>
                        <li>
                            <a href="login.php">LOGIN</a>
                        </li>
                        <li>
                            <a href="register.php">REGISTER</a>
                        </li>
                        <li>
                            <a href="about.php">ABOUT</a>
                        </li>
                        <li>
                            <a href="contact.php">CONTACT</a>
                        </li>
                    <?php
                    }else{
                        if($_SESSION['admin'] == true){
                            ?>
                            <li>
                                <a href="dashboard_admin.php">DASHBOARD</a>
                            </li>
                        <?php
                        } elseif($user->hasPermission('coord')){
                            ?>
                            <li>
                                <a href="dashboard_coord.php">DASHBOARD</a>
                            </li>
                        <?php
                        }else{
                            ?>
                            <li>
                                <a href="dashboard_student.php">DASHBOARD</a>
                            </li>
                        <?php
                        }
                    ?>
                    <li>
                        <a href="about.php">ABOUT</a>
                    </li>
                    <li>
                        <a href="contact.php">CONTACT</a>
                    </li>
                </ul>
            <!--                button logout-->
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span>  LOGOUT</a></li>
                </ul>
                <!--                -->
            <?php
            $user12 = new user();
            $user_id = $user12->data()->id;
            $userNotificationDet = DB::getInstance();
            $userNotificationDet->query('SELECT * FROM notification n, user_notification un WHERE un.uID = ? and n.nID = un.nID ORDER BY n.nID DESC',array($user_id));
            $count1 = $userNotificationDet->count();
            $resultSet1 = $userNotificationDet->results();
            $userRepeatExamNotifDet = DB::getInstance();
            $userRepeatExamNotifDet->query('SELECT * FROM repeatExam_notification WHERE uID = ?',array($user_id));
            $count2 = $userRepeatExamNotifDet->count();
            $resultSet2 = $userRepeatExamNotifDet->results();
            $count = $count1 + $count2;
            ?>
                <ul class="nav navbar-nav navbar-right" title="Notifications">
                    <div class="col-sm-2">
                        <li>
                            <a id="dLabel" role="button" data-toggle="dropdown" data-target="#" href="/page.html">
                                <?php
                                if($count>0){
                                    ?>
                                    <i class="label label-danger col-sm-offset-5"><?php echo $count;?></i>
                                <?php
                                }else{
                                    ?>
                                    <i class="label label-info col-sm-offset-5"><?php echo $count;?></i>
                                <?php
                                }
                                ?>
                                <!--                        <span class="glyphicon glyphicon-bell"> NOTIFICATIONS</span>-->
                        <span class="glyphicon glyphicon-bell">


                        </span>
                            </a>
                            <ul class="dropdown-menu notifications navbar-default pre-scrollable" role="menu" aria-labelledby="dLabel" style="max-height: 300px;">
                                <div class="col-sm-12 ">
                                    <?php

                                    if($count1>0){
                                        foreach($resultSet1 as $n1 ){
                                            echo "<div class=''><p><strong>$n1->topic</strong></p><p>$n1->detail</p></div>";
                                        }
                                    }

                                    if($count2>0){
                                        foreach($resultSet2 as $n2 ){
                                            echo "<div class=''><p><strong>$n2->topic</strong></p><p>$n2->description</p></div>";
                                        }
                                    }
                                    if($count==0){
                                        echo 'No Notifications';
                                    }

                                    ?>
                                </div>
                            </ul>
                        </li>
                    </div>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="index.php"><span class="glyphicon glyphicon-user"></span> <?php echo $user->data()->username?></a></li>
                </ul>
            <?php
            }
            ?>
            </div>
        </div>
    </nav>
</div>
<!--nav-->

