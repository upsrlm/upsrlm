<?php

namespace bccallcenter\modules\bc\controllers;

use Yii;
use yii\base\Model;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use bc\modules\selection\models\SrlmBcApplication;
use bc\modules\selection\models\SrlmBcApplicationSearch;
use bc\modules\selection\models\form\DashboardSearchForm;
use common\models\master\MasterRole;
use yii\web\UploadedFile;
use common\models\CboMembers;
use common\models\User;
use common\models\CboMemberProfile;

/**
 * Default controller for the `bc` module
 */
class RsetisController extends Controller {

    use \common\traits\AjaxValidationTrait;

    public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['index', 'add', 'update'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'add', 'update'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex() {
        if (Yii::$app->request->isGet)
            $searchModel = new DashboardSearchForm(Yii::$app->request->queryParams);
        if (Yii::$app->request->isPost)
            $searchModel = new DashboardSearchForm(Yii::$app->request->post());
        $searchModels = new SrlmBcApplicationSearch();

        $dataProvider = $searchModels->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider->query->andWhere(['not', ['srlm_bc_application.created_by' => null]]);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionAdd() {
        $model = new \bc\modules\selection\models\form\AddRsethiCertifiedBCForm();
        $this->performAjaxValidation($model);
        if ($model->load(Yii::$app->request->post())) {

            if ($model->validate()) {
                $model->save();
                return $this->redirect(['/bc/rsetis']);
            }
        }

        return $this->render('add', [
                    'model' => $model,
        ]);
    }

    public function actionUpdate($bcid) {
        $bc_model = $this->findModelbc($bcid);
        $model = new \bc\modules\selection\models\form\AddRsethiCertifiedBCForm($bc_model);
        $this->performAjaxValidation($model);
        if ($model->load(Yii::$app->request->post())) {

            if ($model->validate()) {
                if ($model->save()) {
                    return $this->redirect(['/bc/rsetis']);
                }
            }
        }

        return $this->render('update', [
                    'model' => $model,
        ]);
    }

    protected function findModelbc($id) {
        if (($model = SrlmBcApplication::find()->where(['id' => $id])->andWhere(['not', ['srlm_bc_application.created_by' => null]])->andWhere(['!=', 'status', -1])->one()) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findModel($id) {
        if (($model = RsetisBatchParticipants::find()->where(['id' => $id])->andWhere(['!=', 'status', -1])->one()) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
