<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\shg\models\Shg */

$this->title = 'UPSRLM SHG ID :' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Shgs', 'url' => ['/shg']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="shg-view">
    <div class="panel panel-default">
        <div class='panel-body'>
            <p>
                <?php if ($model->verify_mobile_no == '0' and $model->created_by == Yii::$app->user->identity->id) { ?>
                    <?= Html::a('Update', ['/shg/default/update', 'shgid' => $model->id], ['class' => 'btn btn-primary']) ?>
                <?php } ?>
            </p>
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
                            'chaire_person_name',
                            'chaire_person_mobile_no',
                            'secretary_name',
                            'secretary_mobile_no',
                            'treasurer_name',
                            'treasurer_mobile_no',
                            'created_by',
                            'updated_by',
                            'created_at',
                            'updated_at',
                            'status',
                        ],
                    ])
                    ?>
                </div> 
            </div>
            <?php if ($model->verification_status) { ?>
                <div class="row">
                    <div class="col-lg-6">
                        Status of verification
                       <?=
                    DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            [
                                'attribute' => 'verify_shg_code',
                                'format'=>'raw',
                                'value' => function ($model) {
                                    return $model->verifyshgcodestatus;
                                },
                                
                            ],
                            [
                                'attribute' => 'verify_shg_location',
                                'format'=>'raw',
                                'value' => function ($model) {
                                    return $model->verifyshglocationstatus;
                                },
                                
                            ],
                           [
                                'attribute' => 'verify_shg_name ',
                                'format'=>'raw',
                                'value' => function ($model) {
                                    return $model->verifyshgnamestatus;
                                },
                                
                            ],
                            [
                                'attribute' => 'verify_shg_members',
                                'format'=>'raw',
                                'value' => function ($model) {
                                    return $model->verifyshgmembersstatus;
                                },
                                
                            ],
                            [
                                'attribute' => 'verify_chaire_person_mobile_no',
                                'format'=>'raw',
                                'value' => function ($model) {
                                    return $model->verifychairepersonmobilenostatus;
                                },
                                
                            ],
                          [
                                'attribute' => 'verify_secretary_mobile_no',
                                'format'=>'raw',
                                'value' => function ($model) {
                                    return $model->verifysecretarymobilenostatus;
                                },
                                
                            ],
                            [
                                'attribute' => 'verify_treasurer_mobile_no',
                                'format'=>'raw',
                                'value' => function ($model) {
                                    return $model->verifytreasurermobilenostatus;
                                },
                                
                            ],
                            
                           
                        ],
                    ])
                    ?>  
                    </div> 

                </div>
            <?php } ?>
        </div>
    </div>
</div>
