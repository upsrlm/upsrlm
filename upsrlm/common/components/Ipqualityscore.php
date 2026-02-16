<?php

namespace common\components;

use Yii;

/**
 * @author Habibur Rahman <rahman.kld@gmail.com>
 */
define('API_KEY', '2OEtgbtRZtopk4N8PteNyanCCusk0w14');

class Ipqualityscore {

    public $api_key = "2OEtgbtRZtopk4N8PteNyanCCusk0w14";
    public $parameters = [
        'country' => ['IN']
    ];

    // function makes curl request to firebase servers
    public function sendGet($phone) {
        $formatted_parameters = http_build_query($this->parameters);
        $url = sprintf(
                'https://www.ipqualityscore.com/api/json/phone/%s/%s?%s',
                $this->api_key,
                $phone,
                $formatted_parameters
        );
        $timeout = 5;
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $timeout);
        $json = curl_exec($curl);
        curl_close($curl);
        $result = json_decode($json, true);
        return $result;
        if (isset($result['success']) && $result['success'] === true) {
            
        }
    }
}

?>