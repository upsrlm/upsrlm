<?php

namespace bcsakhi\components\widget\bc;

use yii\base\Widget;

// TimelinesWidget.php
class SakhiWidget extends Widget {

    public $model;

    public function init() {
        parent::init();
    }

    public function run() {
        \Yii::$app->params['page_size30']=10;
        $searchModel = new \common\models\dynamicdb\bc\bcsakhi\BcsakhiTransactionBcSummaryMonthlySearch();
        $searchModel->bc_application_id = $this->model->bc_application_id;
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams, \Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider->query->andWhere(['bc_application_id' => $this->model->bc_application_id]);
        $dataProvider->sort->defaultOrder = ['month_start_date' => SORT_DESC];
        $searchModel1 = new \common\models\dynamicdb\bc\bcsakhi\BcsakhiTransactionBcSummaryMonthlySearch();
        $report = $searchModel1->chart($searchModel, \Yii::$app->user->identity);
        return $this->render('bc', [
                    'model' => $this->model,
                    'dataProvider' => $dataProvider,
                    'report' => $report
        ]);
    }
}

?>