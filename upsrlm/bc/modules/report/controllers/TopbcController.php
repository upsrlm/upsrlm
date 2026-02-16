<?php

namespace bc\modules\report\controllers;

use Yii;
use yii\web\Controller;
use bc\models\report\Graph;
use bc\modules\training\models\RsetisBatchParticipantsSearch;
use bc\modules\selection\models\SrlmBcApplication;
use bc\modules\training\models\RsetisBatchParticipants;
use common\models\master\MasterRole;

/**
 * Default controller for the `report` module
 */
class TopbcController extends Controller {

    use \common\traits\AjaxValidationTrait;

    public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['index', 'bcview'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'bcview'],
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
    public function actionIndex() {
        $model = '';

        return $this->render('index', [
                    'model' => $model,
        ]);
    }
    public function actionBcview($bcid) {
       Yii::$app->params['baseurl_bc_image']='https://bc.upsrlm.org';
       $model=$this->findModel($bcid);
        return $this->render('bcview', [
                    'model' => $model,
                    
        ]);
    }
    protected function findModel($id) {
        if (($model = \common\models\dynamicdb\bc\bcsakhi\BcsakhiTransactionBcSummary::findOne(['bc_application_id'=>$id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    protected function findModelbc($id) {
        if (($model = SrlmBcApplication::find()->where(['id' => $id])->andWhere(['!=', 'status', -1])->one()) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
