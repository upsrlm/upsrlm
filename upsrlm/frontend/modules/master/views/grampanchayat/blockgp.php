<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\Pjax;
use kartik\grid\GridView;
use common\models\User;
use yii\bootstrap4\Modal;
use common\models\master\MasterRole;
?>

<div class="col-xl-12">
    <div id="panel-1" class="panel">
        <div class="panel-header" style="margin-top: 20px">
            <h2>
                <?= $this->title ?>
            </h2>

        </div>
        <div class="panel-container show">
            <div class="panel-content">

                <?=
                GridView::widget([
                    'dataProvider' => $dataProvider,
                    'layout' => "{items}",
                    'tableOptions' => ['class' => 'table table-striped table-bordered table-condensed table-hover'],
                    'id' => 'grid-data',
                    'summary' => "Showing <b>{begin}</b> - <b>{end}</b> of <b>{totalCount}</b> results",
                    'pjax' => TRUE,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn', 'contentOptions' => ['style' => 'width: 2%']],
                        [
                            'attribute' => 'gram_panchayat_code',
                            'format' => 'raw',
                            'enableSorting' => false,
                            'value' => function ($model) {
                                return $model->gram_panchayat_code;
                            }
                        ],
                        [
                            'attribute' => 'gram_panchayat_name',
                            'format' => 'raw',
                            'enableSorting' => false,
                            'value' => function ($model) {
                                return $model->gram_panchayat_name;
                            }
                        ],
                        
                    ],
                ]);
                ?>


            </div>
        </div>  
    </div>
</div>


