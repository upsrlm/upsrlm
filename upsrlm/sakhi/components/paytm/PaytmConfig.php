<?php

namespace sakhi\components\paytm;


use yii;

class PaytmConfig extends \yii\base\Component
{

    // public $PAYTM_ENVIRONMENT = "PROD";    // For Production /LIVE
    public $PAYTM_ENVIRONMENT = "TEST";    // For Staging / TEST
    public $PAYTM_MERCHANT_KEY;
    public $PAYTM_MERCHANT_MID;
    public $PAYTM_MERCHANT_WEBSITE;
    public $PAYTM_CHANNEL_ID;
    public $PAYTM_INDUSTRY_TYPE_ID;
    public $PAYTM_CALLBACK_URL;
    public $PAYTM_STATUS_QUERY_NEW_URL;
    public $PAYTM_TXN_URL;

    public function run()
    {
        // For LIVE
        if ($this->PAYTM_ENVIRONMENT == 'PROD') {
            //===================================================
            //	For Production or LIVE Credentials
            //===================================================
            $this->PAYTM_STATUS_QUERY_NEW_URL = 'https://securegw.paytm.in/merchant-status/getTxnStatus';
            $this->PAYTM_TXN_URL = 'https://securegw.paytm.in/theia/processTransaction';

            //Change this constant's value with Merchant key received from Paytm.
            $this->PAYTM_MERCHANT_MID         = "Trilin49001348393960";
            $this->PAYTM_MERCHANT_KEY         = "NMjWvdGTsgfB8kTm";

            $this->PAYTM_CHANNEL_ID     = "WEB";
            $this->PAYTM_INDUSTRY_TYPE_ID = "";
            $this->PAYTM_MERCHANT_WEBSITE = "";
            $this->PAYTM_CALLBACK_URL     = "";
        } else {
            //===================================================
            //	For Staging or TEST Credentials
            //===================================================
            $this->PAYTM_STATUS_QUERY_NEW_URL = 'https://securegw-stage.paytm.in/merchant-status/getTxnStatus';
            $this->PAYTM_TXN_URL = 'https://securegw-stage.paytm.in/theia/processTransaction';

            //Change this constant's value with Merchant key received from Paytm.
            $this->PAYTM_MERCHANT_MID         = "Trilin49001348393960";
            $this->PAYTM_MERCHANT_KEY         = "NMjWvdGTsgfB8kTm";

            $this->PAYTM_CHANNEL_ID         = "WEB";
            $this->PAYTM_INDUSTRY_TYPE_ID = "Retail";
            $this->PAYTM_MERCHANT_WEBSITE = "WEBSTAGING";
            $base_path = \yii\helpers\Url::home(true);

            $this->PAYTM_CALLBACK_URL     = $base_path . "site/paymentresponse";
        }
    }
}
