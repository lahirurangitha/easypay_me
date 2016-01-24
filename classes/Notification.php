<?php
/**
 * Created by PhpStorm.
 * User: lasith-niro
 * Date: 17/10/15
 * Time: 11:37
 */

class Notification {
    private $_Ndb,
            $_Ndata;

    public function __construct($Notification = null){
        $this->_Ndb = DB::getInstance();
    }

    public function createNotification($fields = array()) {
        if(!$this->_Ndb->insert('notification', $fields)){
            throw new Exception('There was a problem in connection');
        }
    }

    public function deleteNotification($id){
        if(!$this->_Ndb->delete('notification', array('nID', '=', $id))){
            throw new Exception('There was a problem in connection');
        }
    }

    public function disAllowUser($userID, $notifyID){
        if(!$this->_Ndb->query('DELETE FROM user_notification WHERE nID = ? AND uID = ?',array($notifyID,$userID))){
            throw new Exception('There was a problem in connection');
        }
    }

    public function getLastNotificationID(){
        $data = $this->_Ndb->getLast('user_notification','ss');
        return $data->count();
    }

    //develop this to with repeat database
    public function getRepeatStudent(){
        //$field = (is_numeric($user)) ? 'id' : 'username';
//        $data = $this->_Ndb->getID2('results', array('repeat_status' , '=' , 1))->results();
        $sqlLine = "SELECT index_no FROM results WHERE repeat_status = 1 GROUP BY index_no";
        $data = $this->_Ndb->query2($sqlLine)->results();
        return $data;
    }

    public function getBatch($year){
        //$field = (is_numeric($user)) ? 'id' : 'username';
        $data = $this->_Ndb->getID('users', array('year' , '=' , $year))->results();

        return $data;
    }

    public function getUserID($index){
        return $this->_Ndb->getID('users',array('indexNumber' , '=' , $index))->results();

    }

    public function getUsername($id){
        $sql = "SELECT username FROM users WHERE id = $id";
        $data = $this->_Ndb->query($sql)->results();
        return $data;
    }

    public function getUserBatch($id){
        $sql = "SELECT year FROM users WHERE id = $id";
        $data = $this->_Ndb->query($sql)->results();
        return $data;
    }

    public function getTopic($notifyid){
        $sql = "SELECT topic FROM notification WHERE nID = $notifyid";
        $data = $this->_Ndb->query($sql)->results();
        return $data;
    }

    public function assignBatch($fields=array()){
        if(!$this->_Ndb->insert('user_notification', $fields)){
            //throw new Exception('There was a problem in connection');
            //print_r($fields);
            $x = $fields['uID'];
            $tmpUser = new User();
            $tmpUser->find($x);
            echo "<div class='alert alert-danger'>This notification has been already send to " . $tmpUser->data()->username . "</div>";
        }
    }

    public function insertUN($fields){
        if(!$this->_Ndb->insert('user_notification', $fields)){
            //throw new Exception('There was a problem sending a notification.');
            $userID = $fields['uID'];
            $tmpUser = new User();
            $tmpUser->find($userID);
            echo "<div class='alert alert-danger alert-dismissible'>This notification has been already send to " . $tmpUser->data()->username . "<button type = 'button' class = 'close' data-dismiss = 'alert' aria-hidden = 'true'>
      &times;
   </button></div>";
        } else {
            $userID = $fields['uID'];
            $tmpUser = new User();
            $tmpUser->find($userID);
            echo "<div class='alert alert-success alert-dismissible'>This notification was send successfully to " . $tmpUser->data()->username . "<button type = 'button' class = 'close' data-dismiss = 'alert' aria-hidden = 'true'>
      &times;
   </button></div>";
        }
    }

    public function find($notification = null){
        if($notification){
            $field = (is_numeric($notification)) ? 'nID' : 'topic';
//            $data = $this->_db->get('users', array($field, '=', $user));
            $data = $this->_Ndb->get('notification', array($field, '=', $notification));

            if($data->count()){
                $this->_Ndata = $data->first();
                return true;
            }
        }
        return false;
    }

    public function outNotifications($nID){
        return $this->_Ndb->get('user_notification',array('nID','=',$nID))->results();

    }

    public function printNotification($notificationID){
        return $this->_Ndb->get('notification', array('nID','=',$notificationID))->results();
    }

    public function getData(){
        return $this->_Ndb->getAll('SELECT *', 'notification', 'nID');
    }

    public function data(){
        return $this->_Ndata;
    }

    public function getNotificationID(){
        return $this->_Ndata->nID;
    }
}
?>