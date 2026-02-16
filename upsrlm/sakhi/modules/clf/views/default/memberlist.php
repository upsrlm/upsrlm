<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use common\helpers\Utility;
use yii\widgets\ListView;
?>
<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">
            <h1>संकुल सदस्यों का विवरण <a href="/clf/default/addmember?clfid=<?= $model->clf_model->id ?>" class="text-right btn btn-info"><i class="fal fa-plus"></i></a></h1>
            <?php
            $providermembers = new \yii\data\ArrayDataProvider([
                'allModels' => $model->clf_model->members,
                'pagination' => false,
            ]);
            ?>
            <div class="panel-container show">
                <div class="panel-content">
                    <?php
                    echo ListView::widget([
                        'dataProvider' => $providermembers,
                        'summary' => 'कुल {totalCount} सदस्य। ',
                        'itemView' => '_memberview',
                    ]);
                    ?>

                </div>
            </div>
        </div>          
    </div>
</div>