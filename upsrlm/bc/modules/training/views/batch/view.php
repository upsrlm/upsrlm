<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\detail\DetailView;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use kartik\tabs\TabsX;
use common\models\master\MasterRole;

$this->title = "Batch View :" . $model->batch_name;
$this->params['breadcrumbs'][] = ['label' => 'Batches', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="training-default-index">
    <div class="panel panel-default">
        <div class='panel-body'>
            <?php
            $data = [
                [
                    'label' => '<i class="fa fa-building"></i> Batch Detail',
                    'content' => Yii::$app->controller->renderPartial('_view', ['model' => $model]),
                    'active' => true,
                ],
                [
                    'label' => '<i class="fa fa-user"></i>Participant',
                    'content' => Yii::$app->controller->renderPartial('_participandetail', ['model' => $model,
                        'searchModelp' => $searchModelp,
                        'dataProvider' => $dataProviderp,
                    ]),
                ],
            ];
            echo TabsX::widget([
                'items' => $data,
                'position' => TabsX::POS_ABOVE,
                'bordered' => false,
                'encodeLabels' => false
            ]);
            ?>    
        </div>
    </div>  
</div>
