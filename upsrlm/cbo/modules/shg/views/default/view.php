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
                    <?php if ($model->verify_mobile_no == '0' and $model->created_by == Yii::$app->user->identity->id) { ?>
                        <?= Html::a('Update', ['/shg/default/update', 'shgid' => $model->id], ['class' => 'btn btn-primary']) ?>
                    <?php } ?>
                    <!-- <button class="btn btn-panel waves-effect waves-themed" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                    <button class="btn btn-panel waves-effect waves-themed" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button> -->
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
                                    [
                                        'attribute' => 'name_of_shg',
                                        'format' => 'raw',
                                        'value' => function ($model) {
                                            return $model->name_of_shg . $model->getColumnstatus($model->verify_shg_name);
                                        }
                                    ],
                                    [
                                        'attribute' => 'shg_code',
                                        'format' => 'raw',
                                        'value' => function ($model) {
                                            return isset($model->shg_code) ? $model->shg_code . $model->getColumnstatus($model->verify_shg_code) : '';
                                        }
                                    ],
                                    [
                                        'attribute' => 'location_of_shg',
                                        'label' => 'location of the SHG',
                                        'format' => 'raw',
                                        'value' => function ($model) {
                                            return $model->fulladdress . $model->getColumnstatus($model->verify_shg_location);
                                        }
                                    ],
//                                    'division_name',
//                                    'district_name',
//                                    'block_name',
//                                    'gram_panchayat_name',
//                                    'village_name',
//                                    'hamlet',
//                                    [
//                                        'attribute' => 'no_of_members',
//                                        'format' => 'raw',
//                                        'value' => function ($model) {
//                                            return $model->no_of_members . $model->getColumnstatus($model->verify_shg_members);
//                                        }
//                                    ],
//                                    [
//                                        'attribute' => 'date_of_formation',
//                                        'format' => 'raw',
//                                        'visible' => isset(Yii::$app->user->identity->role) and in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN]),
//                                        'value' => function ($model) {
//                                            return isset($model->rprofile->date_of_formation) ? $model->rprofile->date_of_formation : '';
//                                        },
//                                    ],
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
                                        'attribute' => 'no_of_members',
                                        'format' => 'raw',
                                        'value' => function ($model) {
                                            return $model->no_of_members . $model->getColumnstatus($model->verify_shg_members);
                                        }
                                    ],
                                    [
                                        'attribute' => 'date_of_formation',
                                        'format' => 'raw',
                                        'visible' => isset(Yii::$app->user->identity->role) and in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN]),
                                        'value' => function ($model) {
                                            return isset($model->rprofile->date_of_formation) ? $model->rprofile->date_of_formation : '';
                                        },
                                    ],
//                                    [
//                                        'attribute' => 'chaire_person_name',
//                                        'label' => 'Chaire Person Name',
//                                        'format' => 'raw',
//                                        'value' => function ($model) {
//                                            $mmodel = $model->getRmembers()->andWhere(['role' => 1])->one();
//                                            return isset($mmodel) ? $mmodel->name : '';
//                                        }
//                                    ],
//                                    [
//                                        'attribute' => 'chaire_person_mobile_no',
//                                        'label' => 'Chaire Person Mobile No',
//                                        'format' => 'raw',
//                                        'value' => function ($model) {
//                                            $mmodel = $model->getRmembers()->andWhere(['role' => 1])->one();
//                                            return isset($mmodel) ? $mmodel->mobile . $model->getColumnstatus($model->verify_chaire_person_mobile_no) : '';
//                                        }
//                                    ],
//                                    [
//                                        'attribute' => 'secretary_name',
//                                        'label' => 'Secretary Name',
//                                        'format' => 'raw',
//                                        'value' => function ($model) {
//                                            $mmodel = $model->getRmembers()->andWhere(['role' => 2])->one();
//                                            return isset($mmodel) ? $mmodel->name : '';
//                                        }
//                                    ],
//                                    [
//                                        'attribute' => 'secretary_mobile_no',
//                                        'label' => 'Secretary Mobile No',
//                                        'format' => 'raw',
//                                        'value' => function ($model) {
//                                            $mmodel = $model->getRmembers()->andWhere(['role' => 2])->one();
//                                            return isset($mmodel) ? $mmodel->mobile . $model->getColumnstatus($model->verify_secretary_mobile_no) : '';
//                                        }
//                                    ],
//                                    [
//                                        'attribute' => 'treasurer_name',
//                                        'label' => 'Treasurer Name',
//                                        'format' => 'raw',
//                                        'value' => function ($model) {
//                                            $mmodel = $model->getRmembers()->andWhere(['role' => 3])->one();
//                                            return isset($mmodel) ? $mmodel->name : '';
//                                        }
//                                    ],
//                                    [
//                                        'attribute' => 'treasurer_mobile_no',
//                                        'label' => 'Treasurer Mobile No',
//                                        'format' => 'raw',
//                                        'value' => function ($model) {
//                                            $mmodel = $model->getRmembers()->andWhere(['role' => 3])->one();
//                                            return isset($mmodel) ? $mmodel->mobile . $model->getColumnstatus($model->verify_treasurer_mobile_no) : '';
//                                        }
//                                    ],
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
                                    [
                                        'attribute' => 'Verified By',
                                        'format' => 'html',
                                        'value' => function ($model) {
                                            $model_user = common\models\User::findOne($model->verify_by);
                                            return isset($model_user->name) ? $model_user->name . " (" . $model_user->mobile_no . ")" : '';
                                        }
                                    ],
                                    [
                                        'attribute' => 'Verified At',
                                        'format' => 'html',
                                        'value' => (isset($model->verify_datetime) and $model->verify_datetime != null) ? date('Y-m-d G:i:s', strtotime($model->verify_datetime)) : '',
                                    ],
                                ],
                            ])
                            ?>
                        </div> 
                    </div>
                    <?= \cbo\widgets\shg\MemberWidget::widget(['cbo_shg_id' => $model->id]) ?>
                    <?= \cbo\widgets\shg\BankAccountWidget::widget(['cbo_shg_id' => $model->id]) ?>
                    <?= \cbo\widgets\shg\FundrecivedWidget::widget(['cbo_shg_id' => $model->id]) ?>
                    <?php
                    if (isset(Yii::$app->user->identity->role) and in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN])) {
                        echo $this->render('_feedback', ['model' => $feedback]);
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>