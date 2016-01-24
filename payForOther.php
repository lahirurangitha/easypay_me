<?php
/**
 * Created by PhpStorm.
 * User: lahiru
 * Date: 9/19/2015
 * Time: 8:07 PM
 */

require_once 'core/init.php';

$user = new User();
if(!$user->isLoggedIn()){
    Redirect::to('index.php');
}

if(Input::exists()){
    if(Token::check(Input::get('token'))) {
        $validate = new Validate();
        $validation = $validate->check($_POST, array(
                'username' => array(
                    'required' => true
                )
            )
        );
        if($validation->passed()){
            //Redirect::to('payForOtherSuccess.php');

            ////Checking if username exists or not////
            $userId = $user->data()->id;
            $username = Input::get('username');
            if(!$username== null){
                $user = new User();
                if($user->find($username)){
//                    echo 'User exists<br>';
//                    echo $user->data()->username;
                    //getting other person's userId
                    $opUserId = $user->data()->id;
                    $opUserName = $user->data()->username;
                    $opUserIndexNumber = $user->data()->indexNumber;
                    //echo '<br>'.$opUserId;
                    $_SESSION['payeeID'] = $opUserId;
                    $_SESSION['p4o']=1;
                    $_SESSION['payeeName'] = $opUserName;
                    $_SESSION['o_indexNumber'] = $opUserIndexNumber;
                    //get other person's name
//                    $name2 = $user->data()->regNumber;
//                    $_SESSION['name2'] = $name2;
                    Redirect::to('payforme.php');

//                    $tempdb = DB::getInstance();
//                    if($tempdb->insert('transaction',array('payerID'=>$userId,'payeeID'=>$opUserId))){
//                        echo 'userId insertion to transaction table completed.' ;
//                    }else{
//                        echo 'userId insertion to transaction table failed.' ;
//                    }

                }else{
                    echo'<script type="text/javascript">alert("Username does not exists");</script>';
                    //Redirect::to('payForOther.php');
                }
            }
            //echo 'checking completed<br>';

        } else {
            $str = "";
            foreach ($validation->errors() as $error) {
                $str .= $error;
                $str .= '\n';
            }
            echo '<script type="text/javascript">alert("' . $str . '")</script>';
        }
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Payment | Page</title>
    <?php include 'headerScript.php'?>
</head>
<body>
<div>
    <?php
    include "header.php";
    ?>
</div>

<div class="backgroundImg container-fluid">
    <?php
    include "studentSidebar.php";
    ?>
    <br>
    <div class="jumbotron col-sm-6 col-sm-offset-1">
        <h4><strong>Please enter the other person's username</strong></h4>
        <form action="" method="post" class="form-horizontal">
            <div class="gap">
                <input class="form-control" type="text" name="username" placeholder="Username" <?php echo Input::get('username')?>>
            </div>
            <div>
                <input type="hidden" name="token" value="<?php echo Token::generate(); ?>" >
                <input class="btn btn-default" type="submit" value="Submit">
            </div>
        </form>
        <button class="btn btn-primary btn-xs col-sm-2" style="float: right" onclick="window.location.href='payforme.php'"><< Back</button>
    </div>

</div>
<?php
include "footer.php";
?>

</body>
</html>