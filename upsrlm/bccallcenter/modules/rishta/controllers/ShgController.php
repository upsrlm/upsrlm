<?php

namespace bccallcenter\modules\rishta\controllers;

use Yii;
use yii\web\Controller;
use common\models\User;
use common\models\CboMemberProfile;
use common\models\CboMembers;
use common\models\master\MasterRole;
use common\models\dynamicdb\cbo_detail\RishtaShgMember;
use common\models\dynamicdb\cbo_detail\RishtaShgMemberSearch;
use cbo\models\Shg;
use common\models\wada\WadaApplicationSearch;
use common\models\wada\WadaApplication;
use common\models\base\GenralModel;

class ShgController extends Controller {

    use \common\traits\AjaxValidationTrait;

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['wss', 'officebearers'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['wss', 'officebearers'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionWss() {

        $null = new \yii\db\Expression('NULL');
        $searchModel = new \common\models\wada\form\DashboardSearchForm(Yii::$app->request->queryParams);
        $searchModels = new \common\models\dynamicdb\cbo_detail\CboMembersSearch();
        $dataProvider = $searchModels->search($searchModel, Yii::$app->user->identity);
        $dataProvider->query->andWhere(['suggest_wada_sakhi' => 1]);
        $dataProvider->query->joinWith(['user']);
        $dataProvider->query->andWhere([\common\models\User::getTableSchema()->fullName . '.dummy_column' => 0]);
        $dataProvider->query->joinWith(['shg']);
        if ($searchModel->cbo_shg_id) {
            $dataProvider->query->andWhere([\common\models\dynamicdb\cbo_detail\CboMembers::getTableSchema()->fullName . '.cbo_id' => $searchModel->cbo_shg_id, 'cbo_type' => 1]);
        }
        if ($searchModel->mobile_no != '') {
            $dataProvider->query->andWhere([\common\models\User::getTableSchema()->fullName . '.username' => $searchModel->mobile_no]);
        }
        if ($searchModel->district_code or $searchModel->block_code or $searchModel->gram_panchayat_code) {

            if ($searchModel->district_code) {
                $dataProvider->query->andWhere([Shg::getTableSchema()->fullName . '.district_code' => $searchModel->district_code]);
            }
            if ($searchModel->block_code) {
                $dataProvider->query->andWhere([Shg::getTableSchema()->fullName . '.block_code' => $searchModel->block_code]);
            }
            if ($searchModel->gram_panchayat_code) {
                $dataProvider->query->andWhere([Shg::getTableSchema()->fullName . '.gram_panchayat_code' => $searchModel->gram_panchayat_code]);
            }
        }

        return $this->render('wss', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionOfficebearers() {

        $null = new \yii\db\Expression('NULL');
        $searchModel = new \common\models\wada\form\DashboardSearchForm(Yii::$app->request->queryParams);
        $searchModels = new \common\models\dynamicdb\cbo_detail\CboMembersSearch();
        $dataProvider = $searchModels->search($searchModel, Yii::$app->user->identity);
        $dataProvider->query->andWhere([
            'or',
            ['=', 'shg_chairperson', 1],
            ['=', 'shg_secretary', 1],
            ['=', 'shg_treasurer', 1],
        ]);
        $dataProvider->query->joinWith(['user']);
        $dataProvider->query->andWhere([\common\models\User::getTableSchema()->fullName . '.dummy_column' => 0]);
        $dataProvider->query->joinWith(['shg']);
        if ($searchModel->cbo_shg_id) {
            $dataProvider->query->andWhere([\common\models\dynamicdb\cbo_detail\CboMembers::getTableSchema()->fullName . '.cbo_id' => $searchModel->cbo_shg_id, 'cbo_type' => 1]);
        }
        if ($searchModel->mobile_no != '') {
            $dataProvider->query->andWhere([\common\models\User::getTableSchema()->fullName . '.username' => $searchModel->mobile_no]);
        }
        if ($searchModel->district_code or $searchModel->block_code or $searchModel->gram_panchayat_code) {

            if ($searchModel->district_code) {
                $dataProvider->query->andWhere([Shg::getTableSchema()->fullName . '.district_code' => $searchModel->district_code]);
            }
            if ($searchModel->block_code) {
                $dataProvider->query->andWhere([Shg::getTableSchema()->fullName . '.block_code' => $searchModel->block_code]);
            }
            if ($searchModel->gram_panchayat_code) {
                $dataProvider->query->andWhere([Shg::getTableSchema()->fullName . '.gram_panchayat_code' => $searchModel->gram_panchayat_code]);
            }
        }

        return $this->render('officebearers', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

}
