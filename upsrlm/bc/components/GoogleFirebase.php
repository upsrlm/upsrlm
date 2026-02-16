<?php

namespace bc\components;

use Yii;
use bc\models\NotificationLog;
use bc\models\NotificationTemplate;
use bc\models\NotificationLogFirebaseDetail;

/**
 * @author Habibur Rahman <rahman.kld@gmail.com>
 */
define('FIREBASE_API_KEY', 'AAAAG6PvD9A:APA91bECHYkcROQN0LWGoUH9gl5ZYIRbhKUZgzJ8KgzNF-_335OhYeiVHUcmcjT98cvBJHGGASBXDtjrGwxRIULwW2MT9ZK-sNK1q2Og_Nojfc6YCNQLvvpUBoZDG-UDtf1U_CHMMr3c');

class GoogleFirebase {

    public $url = "https://fcm.googleapis.com/fcm/send";
    public $image = "https://www.upsrlm.org/images/upg-logo.png";

    /**
     * @var \app\models\Notification
     */
    public $notification_model;

    // sending push message to single user by firebase reg id
    public function __construct($notification_model) {
        $this->notification_model = $notification_model;
    }

    public function getPush() {
        $res = array();
        $res['title'] = $this->notification_model->message_title;
        $res['message'] = $this->notification_model->message;
        $res['message_id'] = $this->notification_model->detail_id;
        $res['log_id'] = $this->notification_model->id;
        $res['type'] = $this->notification_model->notification_type;
        $res['sub_type'] = $this->notification_model->notification_sub_type;
        $res['visible'] = $this->notification_model->visible;
        $res['acknowledge'] = $this->notification_model->acknowledge;
        $res['genrated_on'] = $this->notification_model->genrated_on;


        return $res;
    }

    public function send($to) {
        $fields = array(
            'to' => $to,
            'data' => $this->getPush(),
        );
        return $this->sendPushNotification($fields);
    }

    // Sending message to a topic by topic name
    public function sendToTopic($to, $message) {
        $fields = array(
            'to' => '/topics/' . $to,
            'data' => $message,
        );
        return $this->sendPushNotification($fields);
    }

    // sending push message to multiple users by firebase registration ids
    public function sendMultiple($registration_ids, $message) {
        $fields = array(
            'to' => $registration_ids,
            'data' => $message,
        );

        return $this->sendPushNotification($fields);
    }

    // function makes curl request to firebase servers
    private function sendPushNotification($fields) {
//        try {
        $headers = array(
            'Authorization: key=' . FIREBASE_API_KEY,
            'Content-Type: application/json'
        );
        // Open connection
        $ch = curl_init();
        // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $this->url);

        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

        // Execute post
        $result = curl_exec($ch);
        if ($result === FALSE) {
            //die('Curl failed: ' . curl_error($ch));
        }
        curl_close($ch);

        return $result;
//        } catch (\Exception $ex) {
//            print_r($ex->getMessage());
//        }
    }

}

?>