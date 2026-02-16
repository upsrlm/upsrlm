<?php

namespace bc\widgets\bc;

use yii\base\Widget;

// TimelinesWidget.php
class TopbcWidget extends Widget {

    public $model;
    public $ids;
    public function init() {
        parent::init();
    }

    public function run() {
        TopbcWidgetAsset::register($this->getView());
        $this->model=[];
        $app_data = \common\models\ApplicationData::findOne(1);
        $top_20_bc= \common\models\dynamicdb\bc\bcsakhi\BcsakhiTransactionBcSummary::find()->andWhere(['bc_application_id'=>\Yii::$app->params['top_bc_ids']])->orderBy(['commission_amount'=>SORT_DESC])->all();
        return $this->render('topbc', [
                    'model' => $this->model,
                    'app_data' => $app_data,
                    'top_20_bc'=>$top_20_bc
        ]);
    }
}

?>