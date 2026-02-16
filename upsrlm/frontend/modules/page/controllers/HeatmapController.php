<?php

namespace app\modules\page\controllers;

use Yii;
use yii\web\Controller;
use common\models\base\GenralModel;

/**
 * Graph controller for the `dashboard` module
 */
class HeatmapController extends Controller {

    use \common\traits\AjaxValidationTrait;

    public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['index', 'scheme'],
                'rules' => [
                    [
                        'actions' => ['index', 'scheme'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            return (!Yii::$app->user->isGuest);
                        }
                    ],
                ],
            ],
        ];
    }

    public function actionIndex() {
        \Yii::$app->params['page_size30'] = 10;
        $params = [];
        if (Yii::$app->request->isGet) {
            $params = Yii::$app->request->queryParams;
        }
        if (Yii::$app->request->isPost) {
            $params = Yii::$app->request->post();
        }
        $searchModel = new \bc\models\report\AnalyticsHeatmap($params, 1);
        if (!isset($params['AnalyticsHeatmap']['month_id'])) {
            $searchModel->month_id = \bc\modules\selection\models\base\GenralModel::current_month_id();
        }
        $searchModel->month_model = \bc\models\transaction\BcTransactionMasterMonth::findOne($searchModel->month_id);
        $searchModel->all = 1;
        $searchModel->month_deafault_value=(($searchModel->month_model->year-$searchModel->startYear)*12)+$searchModel->month_model->month_no;
        $total_count = $searchModel->search($searchModel);

        $geojsondata = $searchModel->geojson;
        $searchModel->month_option = \bc\modules\selection\models\base\GenralModel::bctmonthoption();
        return $this->render('index', [
                    'total_count' => $total_count,
                    'searchModel' => $searchModel,
                    'geojsonRender' => $geojsondata['render'],
                    'geojsonContent' => $geojsondata['content'],
                    'heatmap_chart_group_list' => [$searchModel->heatmapChartGroupList()['bc-active']]
        ]);
    }

    public function actionData($month, $year) {
        \Yii::$app->params['page_size30'] = 10;
        $params = [];
        if (Yii::$app->request->isGet) {
            $params = Yii::$app->request->queryParams;
        }
        if (Yii::$app->request->isPost) {
            $params = Yii::$app->request->post();
        }
        $searchModel = new \bc\models\report\AnalyticsHeatmap($params, 1);
        $searchModel->month_model = \bc\models\transaction\BcTransactionMasterMonth::find()->where(['month_no' => $month])->andFilterWhere(['=', 'year', $year])->one();
        if (isset($searchModel->month_model)) {
            $searchModel->month_id = $searchModel->month_model->id;
        } else {
            $searchModel->month_id = 0;
        }

        $searchModel->all = 1;

        $total_count = $searchModel->search($searchModel);

        $geojsondata = $searchModel->geojson;
        $searchModel->month_option = \bc\modules\selection\models\base\GenralModel::bctmonthoption();
        return $this->renderAjax('data', [
                    'total_count' => $total_count,
                    'searchModel' => $searchModel,
                    'geojsonRender' => $geojsondata['render'],
                    'geojsonContent' => $geojsondata['content'],
                    'heatmap_chart_group_list' => [$searchModel->heatmapChartGroupList()['bc-active']]
        ]);
    }
}
