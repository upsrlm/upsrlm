<?php

namespace bc\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\grid\GridView;
use kartik\mpdf\Pdf;
use Mpdf\Mpdf;
use bc\modules\selection\models\SrlmBcApplication;
use bc\modules\selection\models\SrlmBcApplicationSearch;
use bc\modules\selection\models\form\DashboardSearchForm;
use common\models\master\MasterRole;
use bc\modules\selection\models\SrlmBcSelectionUser;
use bc\modules\selection\models\SrlmBcSelectionUserSearch;
use bc\models\master\MasterDistrictSearch;
use bc\models\master\MasterBlockSearch;
use bc\models\master\MasterGramPanchayatSearch;
use bc\modules\selection\models\base\GenralModel;
use bc\modules\selection\components\BcApplication;

/**
 * Default controller for the `srlm` module
 */
class DashboardController extends Controller {

    public $flash_message;

    public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['index'],
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            return (!Yii::$app->user->isGuest );
                        }
                    ],
                ],
            ],
        ];
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex() {
        if (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN,MasterRole::ROLE_MSC, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_SPM_FI_MF, MasterRole::ROLE_SPM_FINANCE, MasterRole::ROLE_DC_NRLM, MasterRole::ROLE_CDO, MasterRole::ROLE_MD, MasterRole::ROLE_RSETIS_STATE_UNIT, MasterRole::ROLE_RSETIS_DISTRICT_UNIT, MasterRole::ROLE_RSETIS_NODAL_BANK, MasterRole::ROLE_UPSRLM_RSETI_ANCHOR, MasterRole::ROLE_BANK_DISTRICT_UNIT, MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL,MasterRole::ROLE_CORPORATE_BCS])) {
            return Yii::$app->getResponse()->redirect(Yii::$app->params['app_url']['bc'] . '/report/cumulative/pendencyd');
            exit;
        } else {
            return Yii::$app->getResponse()->redirect(Yii::$app->params['app_url']['bc'] . '/report/dashboard');
            exit;
        }
    }

}
