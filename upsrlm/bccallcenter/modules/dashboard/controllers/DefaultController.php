<?php

namespace bccallcenter\modules\dashboard\controllers;

use Yii;
use yii\base\Model;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use bc\modules\training\models\RsetisCenterTrainingSearch;
use bc\modules\training\models\RsetisBatchParticipants;
use bc\modules\training\models\RsetisBatchParticipantsSearch;
use bc\modules\selection\models\SrlmBcApplication;
use bc\modules\training\models\form\AddScoreForm;
use common\models\master\MasterRole;
use yii\web\UploadedFile;
use common\models\CboMembers;
use common\models\User;
use common\models\CboMemberProfile;

/**
 * Default controller for the `dashboard` module
 */
class DefaultController extends Controller {

    public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['index', 'bankstatus'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'bankstatus'],
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
        $searchModel = new RsetisBatchParticipantsSearch();
        $searchModel->show_blocked = 0;
        if (Yii::$app->request->isGet)
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        if (Yii::$app->request->isPost)
            $dataProvider = $searchModel->search(Yii::$app->request->post(), Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider->query->andWhere(['rsetis_batch_participants.training_status' => SrlmBcApplication::TRAINING_STATUS_PASS]);
        if ($searchModel->rishta_access_page != '') {
            if ($searchModel->rishta_access_page == '0') {
                $dataProvider->query->andWhere(['srlm_bc_application.rishta_access_page_count' => 0]);
                $dataProvider->query->andWhere(['not', ['srlm_bc_application.user_id' => null]]);
                $dataProvider->query->andWhere(['srlm_bc_application.blocked' => 0]);
            }
            if ($searchModel->rishta_access_page == '1') {
                $dataProvider->query->andWhere(['>', 'srlm_bc_application.rishta_access_page_count', 0]);
            }
        }
        $searchModel->division_option = \bc\modules\selection\models\base\GenralModel::divisionoption();
        $searchModel->district_option = \bc\modules\selection\models\base\GenralModel::districtoption($searchModel);
        if (count($searchModel->district_option) == 1) {
            $searchModel->district_code = key($searchModel->district_option);
        }
        if ($searchModel->district_code) {
            $searchModel->block_option = \bc\modules\selection\models\base\GenralModel::blockoption($searchModel);
        }
        if ($searchModel->block_code) {
            $searchModel->gp_option = \bc\modules\selection\models\base\GenralModel::gpoption($searchModel);
        }

        $searchModel->training_status_option = ['3' => 'Certified', '31' => 'Already certified', '7' => 'Onboarding']; //\yii\helpers\ArrayHelper::map(\bc\modules\training\models\RsetisTrainingStatus::find()->where(['status' => 1, 'id' => [3, 7]])->all(), 'id', 'status_eng');

        $searchModel->gp_member_option = \yii\helpers\ArrayHelper::map(\bc\modules\selection\models\master\BcApplicationMasterAlreadyGroupMember::find()->andWhere(['status' => 1])->all(), 'id', 'name_eng');
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionBankstatus($bcid) {
        $bc_model = $this->findModelbc($bcid);
        $model = new \bc\modules\selection\models\form\VerificationBankDetailForm($bc_model);

        if (\Yii::$app->request->isAjax) {

            return $this->renderAjax('bank_detail_status', [
                        'model' => $model,
            ]);
        } else {
            return $this->render('bank_detail_status', [
                        'model' => $model,
            ]);
        }
    }

    public function actionView($participantid) {

        $model = $this->findModel($participantid);

        if (\Yii::$app->request->isAjax) {
            return $this->renderAjax('view', [
                        'model' => $model,
            ]);
        } else {
            return $this->render('view', [
                        'model' => $model,
            ]);
        }
    }

    protected function findModelbc($id) {
        if (($model = SrlmBcApplication::find()->where(['id' => $id])->one()) !== null) {
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
