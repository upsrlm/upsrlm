<?php

namespace bccallcenter\modules\vo\controllers;

use Yii;
use cbo\models\CboVo;
use cbo\models\CboVoSearch;
use cbo\models\form\CboVoForm;
use cbo\models\form\CboVoMembersForm;
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
                'only' => ['index'],
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['@'],
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
    public function actionIndex($void) {
        $vo_model = $this->findModel($void);
        return $this->render('/default/view', [
                    'model' => $this->findModel($void),
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
        if (($model = CboVo::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
