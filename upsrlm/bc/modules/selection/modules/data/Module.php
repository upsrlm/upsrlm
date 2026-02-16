<?php

namespace bc\modules\selection\modules\data;

use Yii;
use common\models\master\MasterRole;

/**
 * data module definition class
 */
class Module extends \yii\base\Module {

    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'bc\modules\selection\modules\data\controllers';

    /**
     * {@inheritdoc}
     */
    public function init() {
        parent::init();
        if(isset(Yii::$app->user->identity)){
        if (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_DM, MasterRole::ROLE_MD, MasterRole::ROLE_DIVISIONAL_COMMISSIONER, MasterRole::ROLE_RSETIS_STATE_UNIT, MasterRole::ROLE_RSETIS_DISTRICT_UNIT, MasterRole::ROLE_BANK_DISTRICT_UNIT])) {

            return Yii::$app->getResponse()->redirect(Yii::$app->params['app_url']['bc'] . '/selection/preselected');
            exit;
        }
        }
        // custom initialization code goes here
    }

}
