<?php

namespace cbo\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\User;
use common\models\UserSearch;
use common\models\base\GenralModel;
use common\models\master\MasterRole;

class BmmuController extends Controller {

    use \common\traits\AjaxValidationTrait;

    public $message = '';

    public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['member', 'call'],
                'rules' => [
                    [
                        'actions' => ['member', 'call'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            return (!Yii::$app->user->isGuest) and (Yii::$app->user->identity->username == '9506812777' or Yii::$app->user->identity->role == MasterRole::ROLE_ADMIN);
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
    public function actionMember() {
        $searchModel = new UserSearch();
        $searchModel->role = MasterRole::ROLE_BMMU;
        $searchModel->status = User::STATUS_ACTIVE;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider->query->joinWith(['blocks', 'blockdis']);
        $dataProvider->query->andWhere(['master_block.wada_block' => 1]);
        $dataProvider->query->distinct('relation_user_bdo_block.block_code');
        $district_option_model = \common\models\master\MasterDistrict::find()->select(['district_code', 'district_name'])->andWhere(['master_district.wada_district' => 1])->all();
        $searchModel->district_option = \yii\helpers\ArrayHelper::map($district_option_model, 'district_code', 'district_name');
        $block_model = \common\models\master\MasterBlock::find()->select(['block_code', 'block_name'])->andWhere(['master_block.status' => 1]);
        if ($searchModel->district_code) {
            $block_model->andWhere(['district_code' => $searchModel->district_code]);
        }
        $block_option_model = $block_model->all();

        $searchModel->block_option = \yii\helpers\ArrayHelper::map($block_option_model, 'block_code', 'block_name');

        if (isset($searchModel->district_code) and $searchModel->district_code != '') {
            $dataProvider->query->joinWith(['blockdis']);
            $dataProvider->query->andWhere(['master_block.district_code' => $searchModel->district_code]);
            $dataProvider->query->distinct('master_block.district_code');
        }
        if (isset($searchModel->block_code) and $searchModel->block_code != '') {
            $dataProvider->query->joinWith(['blocks']);
            $dataProvider->query->andWhere(['relation_user_bdo_block.block_code' => $searchModel->block_code]);
            $dataProvider->query->distinct('relation_user_bdo_block.block_code');
        }
        return $this->render('member', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCall($id, $mobile_no, $log_id) {
        $member_model = User::findOne($id);
        
        $log_model = \common\models\dynamicdb\internalcallcenter\CloudTeleApiLog::findOne(['id' => $log_id]);
        $model = new \common\models\dynamicdb\internalcallcenter\form\CloudLog($log_model);
        $model->status_url = '/call/upsrlmstatus';
        $searchModel = new \common\models\dynamicdb\internalcallcenter\CloudTeleApiLogSearch();
        $searchModel->upsrlm_call_type = 1;
        $searchModel->customernumber = $log_model->customernumber;
        $model->dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, 2, \common\models\base\GenralModel::select_cloud_tele_log_columns());
        $model->dataProvider->query->andwhere(['!=', 'id', $log_model->id]);
        $this->performAjaxValidation($model);
        if ($model->load(Yii::$app->request->post())) {
            $log_model->upsrlm_call_quality = $model->upsrlm_call_quality;
            $log_model->upsrlm_call_outcome = $model->upsrlm_call_outcome;
            $log_model->upsrlm_call_again = $model->upsrlm_call_again;

            if ($log_model->save()) {
                return $this->redirect('/bmmu/member');
            }
            return $this->redirect('/bmmu/member');
        }
        if (\Yii::$app->request->isAjax) {

            return $this->renderAjax('_callcloudform', [
                        'model' => $model,
                        'member_model' => $member_model
            ]);
        } else {
            return $this->render('_callcloudform', [
                        'model' => $model,
                        'member_model' => $member_model
            ]);
        }
    }

}
