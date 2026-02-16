<?php

namespace bc\modules\partneragencies\controllers;

use Yii;
use yii\base\Model;
use bc\models\PartnerBankDistrictPlanning;
use bc\models\PartnerBankDistrictPlanningSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PlanningController implements the CRUD actions for PartnerBankDistrictPlanning.
 */
class PlanningController extends Controller {

    use \common\traits\AjaxValidationTrait;

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['index', 'view', 'weekly'],
                'rules' => [
                    [
                        'actions' => ['index', 'view', 'weekly'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'block' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all PartnerAssociates models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new PartnerBankDistrictPlanningSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, 100);
        $searchModel->bank_option = \bc\modules\selection\models\base\GenralModel::partner_bank_option($searchModel);
        $searchModel->district_option = \bc\modules\selection\models\base\GenralModel::districtoption($searchModel);
        if (count($searchModel->district_option) == 1) {
            $searchModel->district_code = key($searchModel->district_option);
        }

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PartnerAssociates model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    public function actionWeekly($id) {
        $bank_district_model = $this->findModel($id);

        $model = new \bc\models\form\PlanningForm($bank_district_model);
//        $this->performAjaxValidation($model);
        if ($model->load(Yii::$app->request->post()) && Model::loadMultiple($model->weekly_planning_model, Yii::$app->request->post()) && $model->validate()) {
            if ($model->save()) {
                return $this->redirect(['/partneragencies/planning']);
            }
        }
        if (\Yii::$app->request->isAjax) {

            return $this->renderAjax('_planningform', [
                        'model' => $model,
            ]);
        } else {
            return $this->render('_planningform', [
                        'model' => $model,
            ]);
        }
    }

    protected function findModel($id) {
        if (($model = PartnerBankDistrictPlanning::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
