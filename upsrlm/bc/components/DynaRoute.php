<?php

namespace bc\components;

use Yii;
use yii\base\BootstrapInterface;
use common\models\master\MasterRole;

class DynaRoute implements BootstrapInterface {

    public function bootstrap($app) {
        $routeArray = [];
        if (isset(Yii::$app->user->identity)) {
            if (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_SPM_FI_MF, MasterRole::ROLE_SPM_FINANCE, MasterRole::ROLE_DC_NRLM, MasterRole::ROLE_CDO, MasterRole::ROLE_MD, MasterRole::ROLE_MSC, MasterRole::ROLE_RSETIS_STATE_UNIT, MasterRole::ROLE_RSETIS_DISTRICT_UNIT, MasterRole::ROLE_RSETIS_NODAL_BANK, MasterRole::ROLE_UPSRLM_RSETI_ANCHOR, MasterRole::ROLE_BANK_DISTRICT_UNIT, MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL,MasterRole::ROLE_CORPORATE_BCS])) {
                $routeArray[''] = 'report/cumulative/pendencyd';
                $routeArray['/'] = 'report/cumulative/pendencyd';
            } else {
                $routeArray[''] = 'report/dashboard';
                $routeArray['/'] = 'report/dashboard';
            }
            $app->urlManager->addRules($routeArray); // Append new rules to original rules
        } else {
            $routeArray[''] = 'report/dashboard';
            $routeArray['/'] = 'report/dashboard';
            $app->urlManager->addRules($routeArray);
        }
    }

}
