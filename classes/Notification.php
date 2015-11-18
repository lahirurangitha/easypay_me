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

    public function getRepeatStudent(){
        //$field = (is_numeric($user)) ? 'id' : 'username';
        $data = $this->_Ndb->getID('users', array('year' , '=' , 1))->results();

        return $data;
    }

    public function getBatch($year){
        //$field = (is_numeric($user)) ? 'id' : 'username';
        $data = $this->_Ndb->getID('users', array('year' , '=' , $year))->results();

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

    public function checkWithUser($userID, $notifyID){
        $data1 = $this->_Ndb->query('SELECT * FROM user_notification WHERE uID = ? AND nID = ?',array($userID, $notifyID));
//        $data2 = $this->_Ndb->get('user_notification', array('nID' , '=' , $notifyID))->count();
        if($data1){
            return false;
        }
        return true;
    }

    public function sendNotification($notif,$userID,$myNotifyID,$send_date ) {
        if($notif->checkWithUser($userID, $myNotifyID)){
            $notif->assignBatch(array(
                'nID' => $myNotifyID,
                'uID' => $userID,
                'send_date' => $send_date
            ));
            //continue;
        } else {
            $tmpUser = new User();
            $tmpUser->find($userID);
            echo "<div class='alert alert-danger'>This notification has been already send to " . $tmpUser->data()->username . "</div>";
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

    public function outNotifications($uID){
        return $this->_Ndb->get('user_notification',array('uID','=',$uID))->results();

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