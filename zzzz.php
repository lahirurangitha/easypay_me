<?php
/**
 * Created by PhpStorm.
 * User: lahiru
 * Date: 1/10/2016
 * Time: 4:44 PM
 */
require_once 'core/init.php';
$myfile = fopen("Files/courseList", "r") or die("Unable to open file!");
while(!feof($myfile)) {
    $line = fgets($myfile);
    $arr = explode(' ',trim($line),2);
    echo "$arr[0]<br>";
//    $tdb =DB::getInstance()->insert2('subjects',array('sub_code'=>$arr[0],'sub_name'=>$arr[1],'credits'=>2));
}
fclose($myfile);