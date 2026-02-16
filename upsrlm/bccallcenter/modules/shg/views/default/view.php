<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\master\MasterRole;

$this->title = 'UPSRLM SHG ID :' . $model->id;
$this->params['breadcrumbs'][] = ['label' => "SHG's", 'url' => ['/shg']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>
                    <?= $this->title ?>
                </h2>
                <div class="panel-toolbar">

                    <button class="btn btn-panel waves-effect waves-themed" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                    <button class="btn btn-panel waves-effect waves-themed" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                    <!--                    <button class="btn btn-panel waves-effect waves-themed" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>-->
                </div>
            </div>
            <div class="panel-container show">
                <div class="panel-content">

                    <div class="row">
                        <div class="col-lg-6">
                            <?=
                            DetailView::widget([
                                'model' => $model,
                                'attributes' => [
                                    'id',
                                    'name_of_shg',
                                    'shg_code',
                                    'division_name',
                                    'district_name',
                                    'block_name',
                                    'gram_panchayat_name',
                                    'village_name',
                                    'hamlet',
                                    'no_of_members',
                                ],
                            ])
                            ?>
                        </div> 
                        <div class="col-lg-6">
                            <?=
                            DetailView::widget([
                                'model' => $model,
                                'attributes' => [
                                     [
                                        'attribute' => 'chaire_person_name',
                                        'label' => 'Chaire Person Name',
                                        'value' => function ($model) {
                                            $mmodel = $model->getRmembers()->andWhere(['role' => 1])->one();
                                            return isset($mmodel) ? $mmodel->name : '';
                                        }
                                    ],
                                    [
                                        'attribute' => 'chaire_person_mobile_no',
                                        'label' => 'Chaire Person Mobile No',
                                        'value' => function ($model) {
                                            $mmodel = $model->getRmembers()->andWhere(['role' => 1])->one();
                                            return isset($mmodel) ? $mmodel->mobile : '';
                                        }
                                    ],
                                    [
                                        'attribute' => 'secretary_name',
                                        'label' => 'Secretary Name',
                                        'value' => function ($model) {
                                            $mmodel = $model->getRmembers()->andWhere(['role' => 2])->one();
                                            return isset($mmodel) ? $mmodel->name : '';
                                        }
                                    ],
                                    [
                                        'attribute' => 'secretary_mobile_no',
                                        'label' => 'Secretary Mobile No',
                                        'value' => function ($model) {
                                            $mmodel = $model->getRmembers()->andWhere(['role' => 2])->one();
                                            return isset($mmodel) ? $mmodel->mobile : '';
                                        }
                                    ],
                                    [
                                        'attribute' => 'treasurer_name',
                                        'label' => 'Treasurer Name',
                                        'value' => function ($model) {
                                            $mmodel = $model->getRmembers()->andWhere(['role' => 3])->one();
                                            return isset($mmodel) ? $mmodel->name : '';
                                        }
                                    ],
                                    [
                                        'attribute' => 'treasurer_mobile_no',
                                        'label' => 'Treasurer Mobile No',
                                        'value' => function ($model) {
                                            $mmodel = $model->getRmembers()->andWhere(['role' => 3])->one();
                                            return isset($mmodel) ? $mmodel->mobile : '';
                                        }
                                    ],
                                    [
                                        'attribute' => 'created_by',
                                        //'label'=>'sadsa',
                                        'format' => 'html',
                                        'value' => function ($model) {
                                            $model_user = common\models\User::findOne($model->created_by);
                                            return isset($model_user->name) ? $model_user->name . " (" . $model_user->mobile_no . ")" : '';
                                        }
                                    ],
                                    [
                                        'attribute' => 'created_at',
                                        //'label'=>'sadsa',
                                        'format' => 'html',
                                        'value' => date('Y-m-d G:i:s', $model->created_at),
                                    ],
                                ],
                            ])
                            ?>
                        </div> 
                    </div>

                    <div class="row">

                        <?php if ($model->verification_status) { ?>
                            <div class="col-lg-6">
                                Status of verification
                                <?=
                                DetailView::widget([
                                    'model' => $model,
                                    'attributes' => [
                                        [
                                            'attribute' => 'verify_shg_code',
                                            'format' => 'raw',
                                            'value' => function ($model) {
                                                return $model->verifyshgcodestatus;
                                            },
                                        ],
                                        [
                                            'attribute' => 'verify_shg_location',
                                            'format' => 'raw',
                                            'value' => function ($model) {
                                                return $model->verifyshglocationstatus;
                                            },
                                        ],
                                        [
                                            'attribute' => 'verify_shg_name ',
                                            'format' => 'raw',
                                            'value' => function ($model) {
                                                return $model->verifyshgnamestatus;
                                            },
                                        ],
                                        [
                                            'attribute' => 'verify_shg_members',
                                            'format' => 'raw',
                                            'value' => function ($model) {
                                                return $model->verifyshgmembersstatus;
                                            },
                                        ],
                                        [
                                            'attribute' => 'verify_chaire_person_mobile_no',
                                            'format' => 'raw',
                                            'value' => function ($model) {
                                                return $model->verifychairepersonmobilenostatus;
                                            },
                                        ],
                                        [
                                            'attribute' => 'verify_secretary_mobile_no',
                                            'format' => 'raw',
                                            'value' => function ($model) {
                                                return $model->verifysecretarymobilenostatus;
                                            },
                                        ],
                                        [
                                            'attribute' => 'verify_treasurer_mobile_no',
                                            'format' => 'raw',
                                            'value' => function ($model) {
                                                return $model->verifytreasurermobilenostatus;
                                            },
                                        ],
                                    ],
                                ])
                                ?>  
                            </div> 
                        <?php } ?>

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>