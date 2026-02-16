<?php

namespace bccallcenter\modules\bc\controllers;

use Yii;
use cbo\models\Shg;
use cbo\models\ShgSearch;
use common\models\base\GenralModel;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\master\MasterRole;
use kartik\mpdf\Pdf;
use Mpdf\Mpdf;
use yii\web\UploadedFile;

/**
 * Default controller for the `bc` module
 */
class DefaultController extends Controller {

    public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['shg'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['shg'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }
    public function actionShg($gram_panchayat_code) {
        $searchModel = new ShgSearch();
        $searchModel->gram_panchayat_code = $gram_panchayat_code;
        $dataProvider = $searchModel->search($searchModel, Yii::$app->user->identity, false);
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
        if (\Yii::$app->request->isAjax) {

            return $this->renderAjax('index', [
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
            ]);
        } else {
            return $this->render('index', [
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
            ]);
        }
    }

}
