<?php

namespace cbo\modules\wada\controllers;

use Yii;
use yii\base\Model;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\wada\WadaApplication;
use common\models\wada\WadaApplicationSearch;
use cbo\models\Shg;
use cbo\models\ShgSearch;
use common\models\base\GenralModel;
use common\models\master\MasterRole;
use yii\web\UploadedFile;
use common\models\CboMembers;
use common\models\User;
use common\models\CboMemberProfile;

/**
 * Samuhsakhi controller for the `wada` module
 */
class SamuhsakhiController extends Controller {

    use \common\traits\AjaxValidationTrait;

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

    public function actionIndex() {
        $searchModel = new \common\models\wada\form\DashboardSearchForm(Yii::$app->request->queryParams);
        if (Yii::$app->request->isPost) {
            $searchModel = new \common\models\wada\form\DashboardSearchForm(Yii::$app->request->post());
        }
        $searchModel->suggest_wada_sakhi = 1;
        $searchModels = new WadaApplicationSearch();
        $dataProvider = $searchModels->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider->query->joinWith(['gp', 'profile']);
        $dataProvider->query->andWhere(['master_gram_panchayat.wada_gp' => 1]);
        $dataProvider->query->andWhere(['cbo_member_profile.bc' => 0]);
        $dataProvider->query->andWhere([WadaApplication::getTableSchema()->fullName . '.status' => 2]);
        $dataProvider->query->andWhere([WadaApplication::getTableSchema()->fullName . '.highest_score_in_gp' => 1]);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionVeryfywadabank($wadaid) {
        $wada_model = $this->findModelwada($wadaid);

        $model = new \common\models\wada\form\VerificationBankDetailForm($wada_model);
        if (in_array($model->wada_bank, [0, 1])) {
            
        } else {
            return $this->redirect(['/wada/samuhsakhi?DashboardSearchForm[district_code]=' . $wada_model->district_code . '&DashboardSearchForm[block_code]=' . $wada_model->block_code]);
        }
        $this->performAjaxValidation($model);
        if ($model->load(Yii::$app->request->post()) and $model->validate()) {

            if ($model->wada_bank == 1) {
                if ($model->verify_wada_passbook_photo == '2') {
                    $model->wada_model->verify_wada_passbook_photo = 2;
                } else {
                    $model->wada_model->verify_wada_passbook_photo = 1;
                }
                if ($model->verify_wada_passbook_not == '2') {
                    $model->wada_model->verify_wada_passbook_not = 2;
                } else {
                    $model->wada_model->verify_wada_passbook_not = 1;
                }
                if ($model->verify_wada_bank_account_no == '2') {
                    $model->wada_model->verify_wada_bank_account_no = 2;
                } else {
                    $model->wada_model->verify_wada_bank_account_no = 1;
                }
                if ($model->verify_wada_branch_code_or_ifsc == '2') {
                    $model->wada_model->verify_wada_branch_code_or_ifsc = 2;
                } else {
                    $model->wada_model->verify_wada_branch_code_or_ifsc = 1;
                }
                if ($model->verify_wada_ifsc_code_entered == '2') {
                    $model->wada_model->verify_wada_ifsc_code_entered = 2;
                } else {
                    $model->wada_model->verify_wada_ifsc_code_entered = 1;
                }
                if ($model->verify_wada_other == 2) {
                    $model->wada_model->verify_wada_other = 2;
                    $model->wada_model->verify_wada_other_reason = $model->verify_wada_other_reason;
                } else {
                    $model->wada_model->verify_wada_other = 1;
                    $model->wada_model->verify_wada_other_reason = null;
                }
                $model->wada_model->verification_status_wada_bank = 1;
                $model->wada_model->wada_bank_verify_by = Yii::$app->user->identity->id;
                $model->wada_model->wada_bank_verify_date = new \yii\db\Expression('NOW()');
                if ($model->wada_model->verify_wada_passbook_photo == 1 and $model->wada_model->verify_wada_passbook_not == 1 and $model->wada_model->verify_wada_bank_account_no == 1 and $model->wada_model->verify_wada_branch_code_or_ifsc == 1 and $model->wada_model->verify_wada_ifsc_code_entered == 1 and $model->wada_model->verify_wada_other == 1) {
                    $model->wada_model->wada_bank = 2;
                } else {
                    $model->wada_model->wada_bank = 3;
                }
            }

            $model->wada_model->action_type = WadaApplication::ACTION_TYPE_WADA_BANK_VERIFY;
            if ($model->wada_model->save() and $model->sendnotification()) {
                return $this->redirect(['/wada/samuhsakhi?DashboardSearchForm[district_code]=' . $wada_model->district_code . '&DashboardSearchForm[block_code]=' . $wada_model->block_code]);
            }
        }
        if (\Yii::$app->request->isAjax) {

            return $this->renderAjax('verification_bank_detail_form', [
                        'model' => $model,
            ]);
        } else {
            return $this->render('verification_bank_detail_form', [
                        'model' => $model,
            ]);
        }
    }

    protected function findModelwada($id) {
        if (($model = WadaApplication::find()->where(['id' => $id])->andWhere(['!=', 'status', -1])->one()) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
