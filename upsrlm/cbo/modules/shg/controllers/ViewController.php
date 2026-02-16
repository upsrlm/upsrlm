<?php

namespace cbo\modules\shg\controllers;

use Yii;
use cbo\models\Shg;
use app\modules\shg\models\ShgSearch;
use app\modules\shg\models\form\ShgForm;
use app\modules\shg\models\form\ShgVerifyForm;
use common\models\base\GenralModel;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\master\MasterRole;
use kartik\mpdf\Pdf;
use Mpdf\Mpdf;

/**
 * View controller for the `shg` module
 */
class ViewController extends Controller {

    use \common\traits\AjaxValidationTrait;

    public $message = '';

    public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['index', 'view', 'create', 'update', 'verify'],
                'rules' => [
                    [
                        'actions' => ['index', 'view'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            return (!Yii::$app->user->isGuest && in_array(\Yii::$app->user->identity->role, [MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_ADMIN, MasterRole::ROLE_BMMU, MasterRole::ROLE_DMMU, MasterRole::ROLE_SMMU, MasterRole::ROLE_YOUNG_PROFESSIONAL, MasterRole::ROLE_MD, MasterRole::ROLE_DC_NRLM, MasterRole::ROLE_CDO, MasterRole::ROLE_WADA_ADMIN]));
                        }
                    ],
                    [
                        'actions' => ['verify'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            return (!Yii::$app->user->isGuest && in_array(\Yii::$app->user->identity->role, [MasterRole::ROLE_YOUNG_PROFESSIONAL]));
                        }
                    ],
                    [
                        'actions' => ['create', 'update'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            return (!Yii::$app->user->isGuest && in_array(\Yii::$app->user->identity->role, [MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_ADMIN, MasterRole::ROLE_BMMU, MasterRole::ROLE_DMMU]));
                        }
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex($shgid) {
        $shg_model = $this->findModel($shgid);
        if ((in_array($shg_model->block_code, \yii\helpers\ArrayHelper::getColumn(Yii::$app->user->identity->blocks, 'block_code')) and in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_BMMU]))) {
            
        } elseif ($shg_model->created_by == \Yii::$app->user->identity->id || MasterRole::ROLE_YOUNG_PROFESSIONAL == Yii::$app->user->identity->role || MasterRole::ROLE_ADMIN == Yii::$app->user->identity->role || MasterRole::ROLE_MD == Yii::$app->user->identity->role || MasterRole::ROLE_SMMU == Yii::$app->user->identity->role) {

        } elseif (MasterRole::ROLE_DC_NRLM == Yii::$app->user->identity->role) {

        } else {
            Yii::$app->getSession()->setFlash('warning', "Not Allowed - Permission denied");
            return Yii::$app->getResponse()->redirect(Yii::$app->params['app_url']['cbo'] . '/shg');
        }
        $feedback = \common\models\dynamicdb\cbo_detail\RishtaShgFeedback::findOne(['cbo_shg_id' => $shg_model->id]);
        return $this->render('/default/view', [
                    'model' => $this->findModel($shgid),
                    'feedback' => $feedback,
        ]);
    }

    /**
     * Finds the Shg model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Shg the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Shg::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
