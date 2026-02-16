<?php

namespace bc\modules\training\controllers;

use Yii;
use yii\web\Controller;
use bc\models\report\Graph;
use bc\modules\training\models\RsetisBatchParticipantsSearch;
use bc\modules\selection\models\SrlmBcApplication;
use common\models\master\MasterRole;

/**
 * Default controller for the `report` module
 */
class BcController extends Controller {

    use \common\traits\AjaxValidationTrait;

    public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['loanrepaid'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['loanrepaid'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionLoanrepaid($bcid) {
        $model = new \bc\modules\selection\models\form\BcshgRefundAmountForm();
        $this->performAjaxValidation($model);
        if ($model->load(Yii::$app->request->post())) {
            $model->shg_confirm_funds_return_photo = UploadedFile::getInstance($model, 'shg_confirm_funds_return_photo');
        }
        if (\Yii::$app->request->isAjax) {

            return $this->renderAjax('_loanrepaidform', [
                        'model' => $model,
            ]);
        } else {
            return $this->render('_loanrepaidform', [
                        'model' => $model,
            ]);
        }
    }

    public function actionList($q = null, $id = null) {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        if (!is_null($q)) {
            $sql = "SELECT 
srlm_bc_application.id,
CONCAT_WS(' ', srlm_bc_application.first_name, srlm_bc_application.middle_name, srlm_bc_application.sur_name, srlm_bc_application.district_name, srlm_bc_application.block_name, srlm_bc_application.gram_panchayat_name) AS text
FROM  srlm_bc_application 
WHERE status=2 and gender=2 and training_status in (3,32) limit 20";
            $connection = \Yii::$app->dbbc;
            $insql = $connection->createCommand($sql);
            $data = $insql->queryAll();
            $out['results'] = array_values($data);
        } elseif ($id > 0) {
            $model = SrlmBcApplication::findOne($id);
            $out['results'] = ['id' => $id, 'text' => $model->name . ' ' . $model->district_name . ' ' . $model->block_name . ' ' . $model->gram_panchayat_name];
        }
        return $out;
    }
    protected function findModelbc($id) {
        if (($model = SrlmBcApplication::find()->where(['id' => $id])->andWhere(['!=', 'status', -1])->one()) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
