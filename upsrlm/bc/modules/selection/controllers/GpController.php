<?php

namespace bc\modules\selection\controllers;

use Yii;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use bc\models\master\MasterGramPanchayatSearch;
use common\models\base\GenralModel;

/**
 * Default controller for the `page` module
 */
class GpController extends Controller {

    use \common\traits\AjaxValidationTrait;

    public function actionStatus() {
        $searchModel = new MasterGramPanchayatSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, 300);
        return $this->render('status', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionVacant() {
        $searchModel = new MasterGramPanchayatSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, 300);
        // $dataProvider->query->andWhere(['not in', 'current_status', [0, 1, 2, 3]]);
        $dataProvider->query->andWhere(['or',
            ['not in', 'current_status', [0, 1, 2, 3]],
            ['is', 'current_status', null]
        ]);
        if ($searchModel->current_status != '') {
            if ($searchModel->current_status == '-3') {
                $dataProvider->query->andWhere(['is', 'current_status', null]);
            } else {
                $dataProvider->query->andWhere(['=', 'current_status', $searchModel->current_status]);
            }
        }
        if ($searchModel->current_available == '1') {
            $dataProvider->query->andWhere(['=', 'current_available', 0]);
            $dataProvider->query->andWhere(['or',
                ['not in', 'current_status', [0, 1, 2, 3]],
                ['is', 'current_status', null]
            ]);
        }
        $district_option_model = \bc\models\master\MasterGramPanchayat::find()->select(['district_code', 'district_name'])->distinct('district_code')->andWhere(['master_gram_panchayat.status' => 1])->andWhere(['not in', 'current_status', [0, 1, 2, 3]])->all();

        $searchModel->district_option = \yii\helpers\ArrayHelper::map($district_option_model, 'district_code', 'district_name');

        $block_model = \bc\models\master\MasterGramPanchayat::find()->select(['block_code', 'block_name'])->distinct('block_code')->andWhere(['master_gram_panchayat.status' => 1])->andWhere(['not in', 'current_status', [0, 1, 2, 3]]);
        if ($searchModel->district_code) {
            $block_model->andWhere(['district_code' => $searchModel->district_code]);
        }
        $block_option_model = $block_model->all();
        $searchModel->block_option = \yii\helpers\ArrayHelper::map($block_option_model, 'block_code', 'block_name');

        return $this->render('vacant', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionVdownload() {
        ini_set('max_execution_time', 1200);
        ini_set('memory_limit', '2048M');
        try {

            $searchModel = new MasterGramPanchayatSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, 300);
            // $dataProvider->query->andWhere(['not in', 'current_status', [0, 1, 2, 3]]);
            $dataProvider->query->andWhere(['or',
                ['not in', 'current_status', [0, 1, 2, 3]],
                ['is', 'current_status', null]
            ]);
            if ($searchModel->current_status != '') {
                if ($searchModel->current_status == '-3') {
                    $dataProvider->query->andWhere(['is', 'current_status', null]);
                } else {
                    $dataProvider->query->andWhere(['=', 'current_status', $searchModel->current_status]);
                }
            }
            if ($searchModel->current_available == '1') {
                $dataProvider->query->andWhere(['=', 'current_available', 0]);
                $dataProvider->query->andWhere(['or',
                    ['not in', 'current_status', [0, 1, 2, 3]],
                    ['is', 'current_status', null]
                ]);
            }

            $dataProvider->pagination = false;
            $file_name = "vcant_gp_" . date("Y_m_d_H-m-s") . ".csv";
            header('Content-Type: text/csv; charset=utf-8');
            header("Content-Disposition: attachment; filename=$file_name");
            $output = fopen('php://output', 'w');
            fputcsv($output, array('Sr No', 'District', 'Block', 'Gram Panchayat', 'No. of Available Application', 'Vacant Reason'));
            $models = $dataProvider->getModels();

            $sr_no = 1;
            foreach ($models as $model) {
                $arr = ['4' => 'Not Certified', '5' => 'ineligible', '6' => 'Absent', '-2' => 'Unwilling', '32' => 'Certified Unwilling'];

                $row = [
                    $sr_no,
                    $model->district_name,
                    $model->block_name,
                    $model->gram_panchayat_name,
                    $model->current_available,
                    isset($arr[$model->current_status]) ? $arr[$model->current_status] : 'No Application',
                ];
                fputcsv($output, $row);
                $sr_no++;
            }
            exit;
        } catch (\Exception $ex) {
            print_r($ex);
            exit;
        }
    }

}
