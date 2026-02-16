<?php

namespace bc\components;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\ForbiddenHttpException;
use common\models\User;
use common\models\master\MasterRole;
use common\components\Appcheck;
use common\models\WebApplication;

class App extends \yii\base\Component {

    public $check;
    public $request;
    public $request_url;

    public function init() {
        $this->request = explode('?', Yii::$app->request->url);
        $this->request_url = rtrim($this->request[0], '/');
//        print_r($this->request_url);exit;
        $this->check = new Appcheck();
        $this->check->current_app = Yii::$app->params['current_app'];
        $this->check->access();
        if (isset(Yii::$app->user->identity)) {
            if (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_SMMU])) {
                if (in_array(Yii::$app->user->identity->id, [20543])) {
                    Yii::$app->user->identity->role = MasterRole::ROLE_SPM_FINANCE;
                }
            }
//            if (Yii::$app->user->identity->master_partner_bank_id == '6') {
//                Yii::$app->user->logout();
//                return Yii::$app->getResponse()->redirect(Yii::$app->params['app_url']['www']);
//                exit;
//            }
            if (!in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_BANK_DISTRICT_UNIT, MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL, MasterRole::ROLE_CORPORATE_BCS])) {
//                return Yii::$app->getResponse()->redirect(Yii::$app->params['app_url']['www']);
//                exit;
            }
            if (Yii::$app->user->identity->application == null) {
                return Yii::$app->getResponse()->redirect(Yii::$app->params['app_url']['www']);
                exit;
            }
            if (!in_array(WebApplication::WEB_APP_BC_ID, ArrayHelper::getColumn(Yii::$app->user->identity->application, 'web_application_id'))) {
                return Yii::$app->getResponse()->redirect(Yii::$app->params['app_url']['www'] . '/dashboard');
                exit;
            }
            if (Yii::$app->user->identity->profile_status == \common\models\base\GenralModel::STATUS_INACTIVE) {

                return Yii::$app->getResponse()->redirect(Yii::$app->params['app_url']['hr'] . '/profile/update');
                exit;
            }
            if (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_SPM_FI_MF, MasterRole::ROLE_SPM_FINANCE, MasterRole::ROLE_DC_NRLM, MasterRole::ROLE_CDO, MasterRole::ROLE_MD, MasterRole::ROLE_RSETIS_STATE_UNIT, MasterRole::ROLE_RSETIS_DISTRICT_UNIT, MasterRole::ROLE_RSETIS_NODAL_BANK, MasterRole::ROLE_UPSRLM_RSETI_ANCHOR, MasterRole::ROLE_BANK_DISTRICT_UNIT, MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL])) {
                if ($this->request_url == '') {
//                    return Yii::$app->getResponse()->redirect(Yii::$app->params['app_url']['bc'] . '/report/cumulative/pendencyd');
//                     exit;
                }
//                Yii::$app->setHomeUrl(Url::to(['/report/cumulative/pendencyd']));
//                $routeArray[''] = '/report/cumulative/pendencyd';
//                $routeArray['/'] = '/report/cumulative/pendencyd';  
//                Yii::$app->urlManager->addRules($routeArray);
            }
        }
        parent::init();
    }
}
