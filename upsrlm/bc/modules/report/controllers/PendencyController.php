<?php

namespace bc\modules\report\controllers;

use Yii;
use yii\web\Controller;
use bc\modules\selection\models\SrlmBcApplication;
use bc\modules\report\models\form\ReportSearchForm;
use common\models\master\MasterRole;
use bc\modules\selection\models\BcGramPanchayat;
use bc\modules\selection\models\BcGramPanchayatSearch;

/**
 * PartneragenciesController for the `report` module
 */
class PendencyController extends Controller {

    use \common\traits\AjaxValidationTrait;

    public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['district', 'block', 'gp'],
                'rules' => [
                    [
                        'actions' => ['district', 'block', 'gp'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionDistrict() {

        $searchModel = new BcGramPanchayatSearch();

        if (in_array(\Yii::$app->user->identity->role, [MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL, MasterRole::ROLE_BANK_DISTRICT_UNIT, MasterRole::ROLE_CORPORATE_BCS])) {
            $searchModel->master_partner_bank_id = \Yii::$app->user->identity->master_partner_bank_id;
        }
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity,100,'district_code');
        $searchModel->bank_option = \bc\modules\selection\models\base\GenralModel::partner_bank_option($searchModel);
        $searchModel->district_option = \bc\modules\selection\models\base\GenralModel::districtoption($searchModel);
        if (count($searchModel->district_option) == 1) {
            $searchModel->district_code = key($searchModel->district_option);
        }
        
        return $this->render('district', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                 
        ]);
    }
}
