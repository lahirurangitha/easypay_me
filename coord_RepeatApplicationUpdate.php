<?php
/**
 * Created by PhpStorm.
 * User: lahiru
 * Date: 1/7/2016
 * Time: 2:39 PM
 */
$user  = new User();
if(!$user->isLoggedIn()){Redirect::to('index.php');}
if(!$user->hasPermission('coord')){Redirect::to('index.php');}

echo "<td><a href='coord_RepeatApplicationUpdate.php?username=" .$username."&subCode=$t->subjectCode&subName=$t->subjectName&id=".$id."&accept=true' onclick='return confirm(\"You are accepting this application. Are you sure?\");'><button class='btn btn-primary'>Accept</button></a></td>";