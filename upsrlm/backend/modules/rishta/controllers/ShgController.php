<?php

namespace backend\modules\rishta\controllers;

use Yii;
use yii\web\Controller;
use common\models\dynamicdb\cbo_detail\RishtaRolePermission;
use common\models\dynamicdb\cbo_detail\RishtaRolePermissionSearch;
use cbo\models\Shg;
use cbo\models\ShgSearch;
use common\models\CboMembers;
use common\models\CboMembersSearch;
use common\models\base\GenralModel;

/**
 * RolepermissionController for the `rishta` module
 */
class ShgController extends Controller {

    public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['index', 'user', 'samusakhi', 'bc'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'user', 'samusakhi', 'bc'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex() {
        $searchModel = new ShgSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30'], GenralModel::select_cbo_shg_columns());
        $searchModel->block_option = GenralModel::optionblock($searchModel);
        $searchModel->district_option = GenralModel::nfsaoptiondistrict($searchModel);
        if ($searchModel->block_code) {
            $searchModel->gp_option = GenralModel::nfsaoptiongp($searchModel);
        }
        $searchModel->verify_option = [1 => 'Member detail correct', 0 => 'Member detail wrong'];
        $searchModel->return_option = [1 => 'Return'];
        if (isset($searchModel->return) and $searchModel->return != '') {
            $dataProvider->query->andWhere([Shg::getTableSchema()->fullName . '.verification_status' => 1]);
            $dataProvider->query->andWhere([Shg::getTableSchema()->fullName . '.verify_mobile_no' => 0]);
        }
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionReport() {
        $searchModel = new ShgSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, 10);
        $dataProvidergp = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, 10, [\cbo\models\Shg::getTableSchema()->fullName . '.gram_panchayat_code']);
        $searchModel->block_option = GenralModel::optionblock($searchModel);
        $searchModel->district_option = GenralModel::nfsaoptiondistrict($searchModel);
        if ($searchModel->block_code) {
            $searchModel->gp_option = GenralModel::nfsaoptiongp($searchModel);
        }

        return $this->render('report', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'dataProvidergp' => $dataProvidergp,
        ]);
    }

    public function actionUser() {
        $searchModel = new \common\models\dynamicdb\cbo_detail\CboMembersSearch();
        $searchModel->cbo_type = CboMembers::CBO_TYPE_SHG;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        if ($searchModel->rishta_app_used != '') {
            $dataProvider->query->joinWith(['user']);
            if ($searchModel->rishta_app_used == '1') {
                $dataProvider->query->andWhere(['not', [\common\models\User::getTableSchema()->fullName . '.app_id' => null]]);
            }
            if ($searchModel->rishta_app_used == '0') {
                $dataProvider->query->andWhere(['is', \common\models\User::getTableSchema()->fullName . '.app_id', new \yii\db\Expression('null')]);
            }
        }
        $searchModel->district_option = GenralModel::nfsaoptiondistrict($searchModel);
        $searchModel->block_option = GenralModel::srlmblockopption($searchModel);
        if ($searchModel->block_code) {
            $searchModel->gp_option = GenralModel::nfsaoptiongp($searchModel);
        }
        if ($searchModel->district_code or $searchModel->block_code or $searchModel->gram_panchayat_code) {
            $dataProvider->query->joinWith(['shg']);
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
        if ($searchModel->wada != '') {
            $dataProvider->query->joinWith(['shg']);
            if ($searchModel->wada == 1) {
                $dataProvider->query->andWhere([\common\models\dynamicdb\cbo_detail\master\MasterGramPanchayat::getTableSchema()->fullName . '.wada_gp' => 1]);
            }
            if ($searchModel->wada == 0) {
                $dataProvider->query->andWhere([\common\models\dynamicdb\cbo_detail\master\MasterGramPanchayat::getTableSchema()->fullName . '.wada_gp' => 0]);
            }
        }
        return $this->render('user', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionBC() {
        $searchModel = new CboMembersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('bc', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionSamuhsakhi() {
        $searchModel = new CboMembersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('samuhsakhi', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

}
