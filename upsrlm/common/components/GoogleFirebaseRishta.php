<?php

namespace common\components;

use Yii;

/**
 * @author Habibur Rahman <rahman.kld@gmail.com>
 */
define('FIREBASE_API_KEY', '');

class GoogleFirebaseRishta {

    public $url = "https://fcm.googleapis.com/fcm/send";
    public $image = "https://www.upsrlm.org/images/upg-logo.png";
    public $notification_model;
    public $user_data_url;
    public $external_url;
    public $acknowledgement_url;
    public $base_url;

    // sending push message to single user by firebase reg id
    public function __construct($notification_model) {
        $this->base_url = \Yii::$app->params['app_url']['sakhi'] . '/rest';
        $this->notification_model = $notification_model;
        if ($this->notification_model->visible == 0) {
            $this->user_data_url = $this->base_url . '/app?notificationid=' . $this->notification_model->id;
        }
        if ($this->notification_model->visible == 1) {
            if ($this->notification_model->acknowledge == 1) {
                $this->acknowledgement_url = $this->base_url . '/notificationacknowledgementurl?notificationid=' . $this->notification_model->id;
            }
            if ($this->notification_model->external_url) {
                $this->external_url = $this->notification_model->external_url;
            }
        }
    }

    public function getPush() {
        $res = array();
        $res['message_id'] = $this->notification_model->id;
        $res['title'] = $this->notification_model->message_title;
        $res['message'] = $this->notification_model->message;
        $res['visible'] = $this->notification_model->visible;
        $res['acknowledgement_url'] = $this->acknowledgement_url;
        $res['external_url'] = $this->external_url;
        $res['user_data_url'] = $this->user_data_url;
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