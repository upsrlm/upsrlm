<?php

namespace cbo\modules\clf\controllers;

use Yii;
use cbo\models\CboClf;
use cbo\models\CboClfSearch;
use cbo\models\form\CboClfForm;
use cbo\models\form\CboClfMembersForm;
use common\models\base\GenralModel;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\master\MasterRole;
use kartik\mpdf\Pdf;
use Mpdf\Mpdf;

/**
 * View controller for the `clf` module
 */
class ViewController extends Controller {

    use \common\traits\AjaxValidationTrait;

    public $message = '';

    public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['index'],
                'rules' => [
                    [
                        'actions' => ['index', 'view'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            return (!Yii::$app->user->isGuest && in_array(\Yii::$app->user->identity->role, [MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_ADMIN, MasterRole::ROLE_BMMU, MasterRole::ROLE_DMMU, MasterRole::ROLE_YOUNG_PROFESSIONAL, MasterRole::ROLE_MD, MasterRole::ROLE_DC_NRLM, MasterRole::ROLE_CDO, MasterRole::ROLE_WADA_ADMIN]));
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
    public function actionIndex($clfid) {
        $clf_model = $this->findModel($clfid);
        if ($clf_model->created_by == \Yii::$app->user->identity->id || MasterRole::ROLE_YOUNG_PROFESSIONAL == Yii::$app->user->identity->role || MasterRole::ROLE_ADMIN == Yii::$app->user->identity->role || MasterRole::ROLE_MD == Yii::$app->user->identity->role) {
            
        } elseif (MasterRole::ROLE_DC_NRLM == Yii::$app->user->identity->role) {
            
        } else {
            Yii::$app->getSession()->setFlash('warning', "Not Allowed - Permission denied");
            return Yii::$app->getResponse()->redirect(Yii::$app->params['app_url']['cbo'] . '/vo');
        }
        return $this->render('/default/view', [
                    'model' => $this->findModel($clfid),
        ]);
    }

    /**
     * Finds the CboVo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Shg the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = CboClf::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
