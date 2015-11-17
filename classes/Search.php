<?php
/**
 * Created by PhpStorm.
 * User: lahiru
 * Date: 11/14/2015
 * Time: 11:25 PM
 */

class Search {
    private $_tdb,
        $_results;

    public function __construct(){
        $this->_tdb = DB::getInstance();
    }

    public function userTable($field,$value){
        $this->_tdb->get('users',array($field,));
    }

}



//
//if(isset($_POST['searchVal'])){
//    $searchUser = $_POST['searchVal'];
//    $userDet = DB::getInstance();
//    if($searchUser!=null){
//        $userDet->get('users',array('username','LIKE',"%$searchUser%"));
//    }
//    if(!$userDet->count()){
//        $output = 'No match found<br>';
//        echo $output;
//    }else{
//        foreach($userDet->results() as $res){
//            $output = $res->username;
////            echo "$output<br>";
//            echo "<li><a href='admin_searchUserResults.php?searchUser=$output'>$output</a></li>";
//        }
//    }
//
//}