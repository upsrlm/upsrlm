<?php

namespace app\modules\selection;

use Yii;
use common\models\master\MasterRole;

/**
 * selection module definition class
 */
class Module extends \yii\base\Module {

    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'bc\modules\selection\controllers';

    /**
     * {@inheritdoc}
     */
    public function init() {
        parent::init();
        
        $this->modules = [
            'data' => [
                'class' => 'bc\modules\selection\modules\data\Module',
            ],
            'dashboard' => [
                'class' => 'bc\modules\selection\modules\dashboard\Module',
            ],
            'phase2' => [
                'class' => 'bc\modules\selection\modules\phasetwo\Module',
            ],
            'phase3' => [
                'class' => 'bc\modules\selection\modules\phasethree\Module',
            ],
            'phase4' => [
                'class' => 'bc\modules\selection\modules\phasefour\Module',
            ],
            'phase5' => [
                'class' => 'bc\modules\selection\modules\phasefive\Module',
            ],
            'phase6' => [
                'class' => 'bc\modules\selection\modules\phasesix\Module',
            ],
            'phase7' => [
                'class' => 'bc\modules\selection\modules\phaseseven\Module',
            ],
        ];
        // Module-level access control moved to controller-level behaviors
        // Access is already checked by BC\components\App and controller-level AccessControl
        if (isset(\Yii::$app->user->identity->role)) {
//            if (in_array(\Yii::$app->user->identity->role, [MasterRole::ROLE_SPM_FI_MF])) {
//                return \Yii::$app->getResponse()->redirect(Yii::$app->params['app_url']['bc'] . '/training/participants/verification');
//                exit;
//            }
            if (in_array(\Yii::$app->user->identity->role, [MasterRole::ROLE_BMMU, MasterRole::ROLE_SMMU, MasterRole::ROLE_DMMU])) {
                return \Yii::$app->getResponse()->redirect(Yii::$app->params['app_url']['bc'] . '/training/participants/certified');
                exit;
            }
        }
        // custom initialization code goes here
    }

}
