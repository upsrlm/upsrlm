<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\detail\DetailView;
use kartik\grid\GridView;
use kartik\tabs\TabsX;
use yii\widgets\Pjax;
use common\models\master\MasterRole;

$this->title = "Venue View :" . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Venues', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="training-default-index">
    <div class="panel panel-default">
        <div class='panel-body'>
            <?= Yii::$app->controller->renderPartial('_view', ['model' => $model]) ?> 
            <?=
            Yii::$app->controller->renderPartial('_training', ['model' => $model,
                'searchModel' => $searchModelt,
                'dataProvider' => $dataProvidert,
            ])
            ?> 
            <?=
            Yii::$app->controller->renderPartial('_participandetail', ['model' => $model,
                'searchModelp' => $searchModelp,
                'dataProvider' => $dataProviderp,
            ])
            ?> 
            
        </div>
    </div>  
</div>
