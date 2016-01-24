<?php
/**
 * Created by PhpStorm.
 * User: Anjana
 * Date: 11/14/2015
 * Time: 7:58 PM
 */
$conn = mysqli_connect('localhost', 'root','','educationdept_db');
if(!$conn){
    die("Connectionssss faild: ". mysqli_connect_error());
}
?>