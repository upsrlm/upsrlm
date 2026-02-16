<?php

namespace bc\modules\selection\controllers;

use Yii;
use yii\web\Controller;
use common\models\master\MasterRole;
/**
 * Default controller for the `selection` module
 */
class DefaultController extends Controller {

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex() {
        if (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_DM, MasterRole::ROLE_MD, MasterRole::ROLE_DIVISIONAL_COMMISSIONER, MasterRole::ROLE_RSETIS_STATE_UNIT, MasterRole::ROLE_RSETIS_DISTRICT_UNIT, MasterRole::ROLE_BANK_DISTRICT_UNIT, MasterRole::ROLE_YOUNG_PROFESSIONAL])) {
            return $this->redirect(['/selection/preselected']);
        }
        //return $this->render('index');
    }

}
