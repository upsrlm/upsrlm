<?php

namespace common\components;

use Yii;

class AirPhone extends \yii\base\Component {

    /**
     * Access Token
     */
    private $_token;

    /**
     * Virtual Private Number
     */
    private $_vn_number;

    /**
     * Agent Mobile Number
     */
    private $_agent_number;

    /**
     * Caller Mobile Number
     */
    private $_caller_number;

    /**
     * Service User ID
     */
    private $_service_user_id;

    /**
     * Dial a Call api url
     */
    private $_dial_call_api_url;

    /**
     * CTC Call API Url
     */
    private $_ctc_api_url;

    /**
     * Agent Add API Url
     */
    private $_agent_add_api_url;

    /**
     * Agent Detail api url
     */
    private $_agent_detail_api_url;

    /**
     * Agent Active\Inactive API Url
     */
    private $_agent_update_api_url;
    private $_agent_update_ivr_staus_api_url;
    public function init() {
        $this->_token = Yii::$app->params['airphone_api_ctc_token'];
        $this->_vn_number = Yii::$app->params['airphone_api_ctc_vnm'];
        $this->_service_user_id = Yii::$app->params['airphone_api_ctc_service_user_id'];
        $this->_ctc_api_url = Yii::$app->params['airphone_api_ctc_url'];
        $this->_dial_call_api_url = 'https://airphone.in/api/dial-call';
        $this->_agent_add_api_url = 'https://airphone.in/api/add-c2c-agent';
        $this->_agent_update_api_url = 'https://airphone.in/api/update-c2c-agent';
        $this->_agent_detail_api_url = 'https://airphone.in/api/get-agent-status';
        $this->_agent_update_ivr_staus_api_url = 'https://airphone.in/api/ivr-agent';
    }

    /**
     * Add Agent
     */
    public function addAgent($name) {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->_agent_add_api_url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => array(
                'virtual_number' => $this->_vn_number,
                'auth_token' => $this->_token,
                'mobile' => $this->_agent_number,
                'name' => $name,
                'status' => 'Inactive'
            ),
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache"
            ),
        ));

        $result = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        return json_decode($result, true);
    }

    /**
     * Get Agent Detail
     */
    public function agentDetail() {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->_agent_detail_api_url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => array(
                'virtual_number' => $this->_vn_number,
                'auth_token' => $this->_token,
                'mobile' => $this->_agent_number,
            ),
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache"
            ),
        ));

        $result = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        return json_decode($result, true);
    }

    /**
     * Update Agent Status
     */
    public function updateAgentStatus($status) {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->_agent_update_api_url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => array(
                'virtual_number' => $this->_vn_number,
                'auth_token' => $this->_token,
                'mobile' => $this->_agent_number,
                'status' => $status
            ),
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache"
            ),
        ));

        $result = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        return json_decode($result, true);
    }

    public function updateIvrAgentStatus($status) {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->_agent_update_api_url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => array(
                'virtual_number' => $this->_vn_number,
                'auth_token' => $this->_token,
                'agent' => $this->_agent_number,
                'ivr_status' => $status
            ),
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache"
            ),
        ));

        $result = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        return json_decode($result, true);
    }
    public function updateIvrAgentStatus($status) {
        // echo $this->_agent_update_ivr_staus_api_url;
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->_agent_update_ivr_staus_api_url,
            CURLOPT_RETURNTRANSFER => true,
//            CURLOPT_ENCODING => "",
//            CURLOPT_MAXREDIRS => 10,
//            CURLOPT_TIMEOUT => 30,
//            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_VERBOSE => true,
            CURLOPT_POSTFIELDS => array(
                'agent' => $this->_agent_number,
                'virtual_number' => $this->_vn_number,
                'auth_token' => $this->_token,
                'ivr_status' => $status
            ),
            CURLOPT_HTTPHEADER => array(
                "Content-Type: multipart/form-data",
                "Content-Type: application/json",
            ),
        ));

        $result = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        return json_decode($result, true);
    }
    /**
     * Dial Status
     */
    public function dialCall() {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->_dial_call_api_url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => array(
                'vn_number' => $this->_vn_number,
                'token' => $this->_token,
                'agent' => $this->_agent_number,
                'caller' => $this->_caller_number
            ),
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache"
            ),
        ));

        $result = curl_exec($curl);
        $err = curl_error($curl);
        print_r($err);
        curl_close($curl);
        return json_decode($result, true);
    }

    /**
     * Set Agent Mobile Number
     *
     * @param [type] $value
     * @return void
     */
    public function setAgentNumber($value) {
        $this->_agent_number = $value;
        return $this;
    }

    /**
     * Set Caller Mobile Number
     *
     * @param [type] $value
     * @return void
     */
    public function setCallerNumber($value) {
        $this->_caller_number = $value;
        return $this;
    }
}
