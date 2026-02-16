<?php

namespace bcsakhi\components\widget\home;

use yii\base\Widget;

// TimelinesWidget.php
class TopbcWidget extends Widget {

    public $model;

    public function init() {
        parent::init();
    }

    public function run() {
        GalleryWidgetAsset::register($this->getView());
        $this->model=[];
        $app_data = \common\models\ApplicationData::findOne(1);
        $top_20_bc= \common\models\dynamicdb\bc\bcsakhi\BcsakhiTransactionBcSummary::find()->orderBy(['commission_amount'=>SORT_DESC])->all();
        return $this->render('topbc', [
                    'model' => $this->model,
                    'app_data' => $app_data,
                    'top_20_bc'=>$top_20_bc
        ]);
    }
}

?>