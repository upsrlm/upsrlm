<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\master\MasterRole;

$this->title = 'SHG का विवरण';

$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">
<!--            <div class="panel-hdr">

            </div>-->
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
                                    'chaire_person_name',
                                    'chaire_person_mobile_no',
                                    'secretary_name',
                                    'secretary_mobile_no',
                                    'treasurer_name',
                                    'treasurer_mobile_no',
                                    [
                                        'attribute' => 'created_by',
                                        'format' => 'html',
                                        'value' => function ($model) {
                                            $model_user = common\models\User::findOne($model->created_by);
                                            return isset($model_user->name) ? $model_user->name . " (" . $model_user->mobile_no . ")" : '';
                                        }
                                    ],
                                    [
                                        'attribute' => 'created_at',
                                        'format' => 'html',
                                        'value' => date('Y-m-d G:i:s', $model->created_at),
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
</div>