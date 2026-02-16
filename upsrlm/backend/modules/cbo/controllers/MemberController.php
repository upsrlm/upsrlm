<?php

namespace backend\modules\cbo\controllers;

use Yii;
use common\models\CboMemberProfile;
use common\models\CboMemberProfileSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\base\GenralModel;

/**
 * MemberController for the `rishta` module
 */
class MemberController extends Controller {

    public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['index'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex() {
        $searchModel = new CboMemberProfileSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);

        $searchModel->district_option = GenralModel::nfsaoptiondistrict($searchModel);
        $searchModel->rishta_access_option = [1 => 'Rishta App used', 0 => 'Rishta App not used'];
        if ($searchModel->district_code) {
            $searchModel->block_option = GenralModel::optionblock($searchModel);
        }
        if ($searchModel->block_code) {
            $searchModel->gp_option = GenralModel::nfsaoptiongp($searchModel);
        }
        if ($searchModel->rishta_access_page != '') {
            if ($searchModel->rishta_access_page == 0) {
                $dataProvider->query->andWhere(['=', 'cbo_member_profile.rishta_access_page_count', 0]);
            }
            if ($searchModel->rishta_access_page == 1) {
                $dataProvider->query->andWhere(['>', 'cbo_member_profile.rishta_access_page_count', 0]);
            }
        }
        if ($searchModel->transaction_start != '') {
            if ($searchModel->transaction_start == 0) {
                $dataProvider->query->andWhere(['=', 'cbo_member_profile.bc_no_of_transaction', 0]);
                $dataProvider->query->andWhere(['cbo_member_profile.bc' => 1]);
            }
            if ($searchModel->transaction_start == 1) {
                $dataProvider->query->andWhere(['>', 'cbo_member_profile.bc_no_of_transaction', 0]);
                $dataProvider->query->andWhere(['cbo_member_profile.bc' => 1]);
            }
        }
        if ($searchModel->ctc_call != '') {
            if ($searchModel->ctc_call == 0) {
                $dataProvider->query->andWhere(['=', 'cbo_member_profile.ctc_call_count', 0]);
            }
            if ($searchModel->ctc_call == 1) {
                $dataProvider->query->andWhere(['>', 'cbo_member_profile.ctc_call_count', 0]);
            }
        }
        if ($searchModel->ibd_call != '') {
            if ($searchModel->ibd_call == 0) {
                $dataProvider->query->andWhere(['=', 'cbo_member_profile.ibd_call_count', 0]);
            }
            if ($searchModel->ibd_call == 1) {
                $dataProvider->query->andWhere(['>', 'cbo_member_profile.ibd_call_count', 0]);
            }
        }
        $searchModel->member_option = [4 => 'BC', 3 => 'CLF', 2 => 'VO', 1 => 'SHG'];
        if (isset($searchModel->member) and is_array($searchModel->member)) {
//            if (in_array(5, $searchModel->member)) {
//                $dataProvider->query->andWhere(['cbo_member_profile.samuh_sakhi' => 1]);
//            }
            if (in_array(4, $searchModel->member)) {
                $dataProvider->query->andWhere(['cbo_member_profile.bc' => 1]);
            }
            if (in_array(3, $searchModel->member)) {
                $dataProvider->query->andWhere(['cbo_member_profile.clf' => 1]);
            }
            if (in_array(2, $searchModel->member)) {
                $dataProvider->query->andWhere(['cbo_member_profile.vo' => 1]);
            }
            if (in_array(1, $searchModel->member)) {
                $dataProvider->query->andWhere(['cbo_member_profile.shg' => 1]);
            }
        }
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CboMemberProfile model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Finds the CboMemberProfile model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CboMemberProfile the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = CboMemberProfile::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
