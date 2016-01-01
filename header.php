<?php
/**
 * Created by PhpStorm.
 * User: lahiru
 * Date: 10/28/2015
 * Time: 10:41 AM
 */

require_once 'core/init.php';
?>


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
            if(!isset($_SESSION['isLoggedIn'])|| $_SESSION['isLoggedIn']==false){
                ?>
                <div style="float: right">
                    <form action="homePage.php" method="POST" class="form-inline gap">
                        <div class="form-group">
                            <input class="form-control" required id="username" type="text" name="username" autocomplete="off" placeholder="Username"/>
                        </div>
                        <div class="form-group">
                            <input class="form-control" required id="password" type="password" name="password" autocomplete="off" placeholder="Enter password" size="25" maxlength="20"/>
                        </div>
                        <input class="btn btn-primary" type="submit" value="Sign in" name="inlinesubmit"/>
                    </form>
                </div>
            <?php
            }
            ?>
            <!--           /inline form -->
            <ul class="nav navbar-nav">
                <?php
                if(!isset($_SESSION['isLoggedIn'])|| $_SESSION['isLoggedIn']==false){
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
                ?>
                <li>
                    <a href="dashboard_student.php">DASHBOARD</a>
                </li>
                <li>
                    <a href="about.php">ABOUT</a>
                </li>
                <li>
                    <a href="contact.php">CONTACT</a>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span>  LOGOUT</a></li>
            </ul>
<!--            <button style="float: right">-->
<!--                <a href="logout.php" class="btn navbar-btn">LOGOUT</a>-->
<!--            </button>-->
            <?php
            }
            ?>
        </div>
    </div>
</nav>

