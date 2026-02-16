<?php

namespace cbo\widgets\shg;

use Yii;
use yii\base\Model;
use yii\base\Widget;
use yii\web\Response;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Json;
use yii\helpers\Url;
use cbo\models\Shg;

class FundrecivedWidget extends Widget {

    public $cbo_shg_id;
    public $visible = true;

    public function init() {
        parent::init();
    }

    public function run() {
        if ($this->visible) {
            $searchModel = new \common\models\dynamicdb\cbo_detail\RishtaShgFundReceivedSearch();
            $searchModel->cbo_shg_id=$this->cbo_shg_id;
            $dataProvider = $searchModel->search($searchModel, Yii::$app->user->identity, '50');
            return $this->render('shg_fund_recived', [
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
            ]);
        }
    }
}
?>

