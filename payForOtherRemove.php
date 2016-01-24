<?php
/**
 * Created by PhpStorm.
 * User: lahiru
 * Date: 1/2/2016
 * Time: 3:01 PM
 */
require_once 'core/init.php';
$_SESSION['p4o']=0;
$_SESSION['payeeName']=null;
$_SESSION['payeeID']=null;
$_SESSION['o_indexNumber'] = null;
Redirect::to('payforme.php');
//have to updade payee details before redirect