<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\widgets\DetailView;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $model app\models\Center */


\yii\web\YiiAsset::register($this);
?>
<div class="baseline-master-center-view">
    <div class="box box-info">
        <div class="row-fluid">

            <div class="panel panel-primary">
                <div class="panel-heading"> <?php ?>

                </div>
                <div class="panel-body">
                    <div class="col-sm-6 col-md-6 col-lg-6" >
                        <?=
                        DetailView::widget([
                            'model' => $model,
                            'options' => ['class' => 'table table-striped table-bordered detail-view'],
                            //'template' =>'<tr><td}>{label}</td><th>{value}</th></tr>',
                            'attributes' => [
                                
                                [
                                    'attribute' => 'batch_name',
                                    'enableSorting' => false,
                                    'value' => $model->batch_name,
                                ],
                                [
                                    'attribute' => 'district_name',
                                    'enableSorting' => false,
                                    'value' => $model->district_name,
                                ],
                                [
                                    'attribute' => 'venue',
                                    'enableSorting' => false,
                                    'value' => isset($model->center)?$model->center->name:'',
                                ],
                            ],
                        ])
                        ?>

                    </div>
                    <div class="col-sm-6 col-md-6 col-lg-6" >
                        <?=
                        DetailView::widget([
                            'model' => $model,
                            'attributes' => [
                               [
                                    'attribute' => 'training',
                                    'enableSorting' => false,
                                    'value' => isset($model->training)?$model->training->date:'',
                                ],
                                [
                                    'attribute' => 'no_of_participant',
                                    'format' => 'html',
                                    
                                    'enableSorting' => false,
                                    'value' => function($model) {
                                        return $model->no_of_participant;
                                    }
                                ],
                                [
                                    'attribute' => 'no_of_gp_covered',
                                    'format' => 'html',
                                    
                                    'enableSorting' => false,
                                    'value' => function($model) {
                                        return $model->no_of_gp_covered;
                                    }
                                ],        
                            ],
                        ])
                        ?>
                    </div>


                </div>
            </div>
        </div>
    </div>
</div>
