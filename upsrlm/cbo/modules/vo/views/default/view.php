<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model app\models\CboVo */

$this->title = 'VO :' . $model->name_of_vo;
$this->params['breadcrumbs'][] = ['label' => "VO's", 'url' => ['/vo']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
$activerecordfunds = new \yii\data\ArrayDataProvider([
    'allModels' => $model->funds,
    'pagination' => [
        'pageSize' => 100,
    ],
        ]);

$providermembers = new \yii\data\ArrayDataProvider([
    'allModels' => $model->members,
    'pagination' => [
        'pageSize' => 100,
    ],
        ]);
?>
<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>
                    <?= $this->title ?>
                </h2>
                <div class="panel-toolbar">
                    <?php if (($model->status == \cbo\models\CboVo::STATUS_SAVE and $model->created_by == Yii::$app->user->identity->id)) { ?>
                        <?= Html::a('Update', ['/vo/default/update', 'void' => $model->id], ['class' => 'btn btn-primary']) ?>
                    <?php } ?>
                    <?php if (($model->samuh_sakhi_name == null and $model->created_by == Yii::$app->user->identity->id)) { ?>
                        <?= Html::a('Add Samuh Sakhi detail', ['/vo/default/samuhsakhi', 'void' => $model->id], ['class' => 'btn btn-primary']) ?>
                    <?php } ?>
                    <button class="btn btn-panel waves-effect waves-themed" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                    <button class="btn btn-panel waves-effect waves-themed" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                    <!--                    <button class="btn btn-panel waves-effect waves-themed" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>-->
                </div>
            </div>
            <?php echo $this->render('verificationstaus', ['model' => $model]); ?>
            <div class="panel-container show">
                <div class="panel-content">            
                    <div class="row">
                        <div class="col-lg-6">
                            <?=
                            DetailView::widget([
                                'model' => $model,
                                'attributes' => [
                                    'id',
                                    'name_of_vo',
                                    'nrlm_vo_code',
                                    'district_name',
                                    'block_name',
                                    'gram_panchayat_name',
                                    'date_of_formation',
                                    'no_of_shg_connected',
                                ],
                            ])
                            ?>
                        </div> 
                        <div class="col-lg-6">
                            <?=
                            DetailView::widget([
                                'model' => $model,
                                'attributes' => [
                                    'bank_account_no_of_the_vo',
                                    'name_of_bank',
                                    'branch',
                                    'branch_code_or_ifsc',
                                    'date_of_opening_the_bank_account',
                                    [
                                        'attribute' => 'total_amount_received',
                                        'label' => 'total amount received',
                                        'format' => 'html',
                                        'value' => function ($model) {
                                            return $model->getFunds()->sum('total_amount_received') != null ? $model->getFunds()->sum('total_amount_received') : '';
                                        }
                                    ],
                                    [
                                        'attribute' => 'total_amount_received',
                                        'label' => "VOs updated balance in Bank",
                                        'format' => 'html',
                                        'value' => function ($model) {
                                            return $model->getFunds()->sum('balance_as_on_date') != null ? $model->getFunds()->sum('balance_as_on_date') : '';
                                        }
                                    ],
                                ],
                            ])
                            ?>
                        </div> 
                    </div>
                    <?php if (($model->samuh_sakhi_name != null)) { ?>
                    <div class="row">
                        <div class="col-lg-12">समूह सखी ब्यौरा</div>
                        <div class="col-lg-6">
                            <?=
                            DetailView::widget([
                                'model' => $model,
                                'attributes' => [
                                    [
                                        'attribute' => 'samuh_sakhi_name',
                                        'format' => 'html',
                                        'value' => function ($model) {
                                            return $model->samuh_sakhi_name;
                                        }
                                    ],
                                    [
                                        'attribute' => 'samuh_sakhi_age',
                                        'format' => 'html',
                                        'value' => function ($model) {
                                            return $model->samuh_sakhi_age;
                                        }
                                    ],
                                    [
                                        'attribute' => 'samuh_sakhi_cbo_shg_id',
                                        'format' => 'html',
                                        'value' => function ($model) {
                                            return $model->samuhsakhishg != null ? $model->samuhsakhishg->name_of_shg : '';
                                        }
                                    ],
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
                                        'attribute' => 'samuh_sakhi_mobile_no',
                                        'format' => 'html',
                                        'value' => function ($model) {
                                            return $model->samuh_sakhi_mobile_no;
                                        }
                                    ],
                                    [
                                        'attribute' => 'samuh_sakhi_mobile_type',
                                        'format' => 'html',
                                        'value' => function ($model) {
                                            return $model->mobiletype != null ? $model->mobiletype->name_hi : '';
                                        }
                                    ],
                                    [
                                        'attribute' => 'samuh_sakhi_social_category',
                                        'format' => 'html',
                                        'value' => function ($model) {
                                            return $model->socialcategory != null ? $model->socialcategory->name_hi : '';
                                        }
                                    ],
                                ],
                            ])
                            ?>
                        </div> 
                    </div>
                    <?php } ?>
                    <div class="row">
                        <div class="col-lg-12">
                            Assigned SHG
                            <table class="table table-striped table-bordered table-condensed table-hover kv-grid-table kv-table-wrap kv-table-float" style="border-collapse: collapse; display: table; width: 1793px; margin: 0px; border-bottom-width: 0px; table-layout: fixed;">

                                <thead>

                                    <tr>
                                        <th style="width: 3.81%;">#</th>
                                        <th data-col-seq="1" style="width: 3.84%;">UPSRLM SHG ID</th>
                                        <th data-col-seq="2" style="width: 9.98%;">Name of SHG</th>
                                        <th data-col-seq="3" style="width: 4.84%;">SHG Code</th>
                                        <th data-col-seq="4" style="width: 7.78%;">District</th>
                                        <th data-col-seq="5" style="width: 7.85%;">Block </th>
                                        <th data-col-seq="6" style="width: 9.71%;">Gram Panchayat </th>
                                        <th data-col-seq="7" style="width: 9.59%;">Rev. Village</th>
                                        <th data-col-seq="8" style="width: 9.69%;">Hamlet</th>
                                        <th data-col-seq="9" style="width: 4.94%;">No. of members</th>
                                        <th data-col-seq="10" style="width: 9.63%;">Chair Person</th>
                                        <th data-col-seq="11" style="width: 9.65%;">Secretary</th>
                                        <th data-col-seq="12" style="width: 7.97%;">Treasurer</th>

                                    </tr>

                                </thead>
                                <tbody>
                                    <?php
                                    if (!empty($model->shg)) {
                                        $no = 1;
                                        foreach ($model->shg as $modelshg) {
                                            $class = '';
//                                    $modelshg = app\modules\shg\models\Shg::findOne($shg->cbo_shg_id);
                                            if (!empty($modelshg)) {
                                                if ($modelshg->verification_status == '1' and $modelshg->verify_mobile_no == '0') {
                                                    $class = 'warning';
                                                } elseif ($modelshg->verification_status == '1' and $modelshg->verify_mobile_no == '1') {
                                                    $class = 'success';
                                                } else {
                                                    
                                                }
                                                ?>    
                                                <tr class="<?= $class ?>">
                                                    <td style="width: 3.81%;"><?= $no ?></td>
                                                    <td data-col-seq="1" style="width: 3.84%;"><?= $modelshg->id ?></td>
                                                    <td data-col-seq="2" style="width: 7.78%;"><?= $modelshg->name_of_shg ?></td>
                                                    <td data-col-seq="3" style="width: 4.84%;"><?= $modelshg->shg_code ?></td>
                                                    <td data-col-seq="4" style="width: 7.78%;"><?= $modelshg->district_name ?></td>
                                                    <td data-col-seq="5" style="width: 7.85%;"><?= $modelshg->block_name ?> </td>
                                                    <td data-col-seq="6" style="width: 9.71%;"><?= $modelshg->gram_panchayat_name ?> </td>
                                                    <td data-col-seq="7" style="width: 9.59%;"><?= $modelshg->village_name ?></td>
                                                    <td data-col-seq="8" style="width: 9.69%;"><?= $modelshg->hamlet ?></td>
                                                    <td data-col-seq="9" style="width: 4.94%;"><?= $modelshg->no_of_members ?></td>
                                                    <td data-col-seq="10" style="width: 9.63%;"><?= $modelshg->chaire_person_name . "<br/>" . $modelshg->chaire_person_mobile_no ?></td>
                                                    <td data-col-seq="11" style="width: 9.65%;"><?= $modelshg->secretary_name . "<br/>" . $modelshg->secretary_mobile_no ?></td>
                                                    <td data-col-seq="12" style="width: 7.97%;"><?= $modelshg->treasurer_name . "<br/>" . $modelshg->treasurer_mobile_no ?></td>

                                                </tr>
                                                <?php
                                            } $no++;
                                        }
                                    } else {
                                        ?>
                                        <tr>
                                            <td colspan="12">No record found</td>   
                                        </tr>
                                    <?php } ?>  
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            Status of access to funds
                            <?=
                            GridView::widget([
                                'dataProvider' => $activerecordfunds,
                                'showOnEmpty' => false,
                                'tableOptions' => ['class' => 'data-table table table-bordered table-striped dataTable'],
                                'summaryOptions' => ['class' => 'summary col-sm-6 dataTables_info'],
                                'layout' => '{items}{pager}',
                                'columns' => [
                                    ['class' => 'yii\grid\SerialColumn', 'contentOptions' => ['style' => 'width: 4%']],
                                    [
                                        'attribute' => 'fund_type',
                                        'value' => function ($model) {
                                            return $model->type != null ? $model->type->fund_type : '';
                                        },
                                        'contentOptions' => ['style' => 'width: 19%']
                                    ],
                                    [
                                        'attribute' => 'date_of_receipt',
                                        'value' => function ($model) {
                                            return $model->date_of_receipt != null ? $model->date_of_receipt : '';
                                        },
                                        'contentOptions' => ['style' => 'width: 15%']
                                    ],
                                    [
                                        'attribute' => 'instalment_if_any',
                                        'value' => function ($model) {
                                            return $model->instalment_if_any != null ? $model->instalment_if_any : '';
                                        },
                                        'contentOptions' => ['style' => 'width: 20%']
                                    ],
                                    [
                                        'attribute' => 'total_amount_received',
                                        'value' => function ($model) {
                                            return $model->total_amount_received;
                                        },
                                        'contentOptions' => ['style' => 'width: 20%']
                                    ],
                                    [
                                        'attribute' => 'balance_as_on_date',
                                        'value' => function ($model) {
                                            return $model->balance_as_on_date;
                                        },
                                        'contentOptions' => ['style' => 'width: 20%']
                                    ],
                                ],
                            ]);
                            ?>
                            VO Status
                            <?=
                            DetailView::widget([
                                'model' => $model,
                                'attributes' => [
                                    [
                                        'attribute' => 'created_by',
                                        /// 'label' => 'Entry By',
                                        'format' => 'html',
                                        'value' => function ($model) {
                                            return isset($model->entryby) ? $model->entryby->name . " (" . $model->entryby->mobile_no . ")" : '';
                                        }
                                    ],
                                    [
                                        'attribute' => 'created_at',
                                        'format' => 'html',
                                        'value' => date('Y-m-d G:i:s', $model->created_at),
                                    ],
                                    [
                                        'attribute' => 'updated_at',
                                        'label' => 'Last updated at',
                                        'format' => 'html',
                                        'value' => date('Y-m-d G:i:s', $model->updated_at),
                                    ],
                                    [
                                        'attribute' => 'status',
                                        'format' => 'html',
                                        'value' => $model->vostatus,
                                    ],
                                ],
                            ])
                            ?>
                        </div> 
                        <div class="col-lg-6">
                            Members
                            <?=
                            GridView::widget([
                                'dataProvider' => $providermembers,
                                'showOnEmpty' => false,
                                'tableOptions' => ['class' => 'data-table table table-bordered table-striped dataTable'],
                                'summaryOptions' => ['class' => 'summary col-sm-6 dataTables_info'],
                                'layout' => '{items}{pager}',
                                'columns' => [
                                    ['class' => 'yii\grid\SerialColumn', 'contentOptions' => ['style' => 'width: 4%']],
                                    [
                                        'attribute' => 'name',
                                        'value' => function ($model) {
                                            return $model->name;
                                        },
                                        'contentOptions' => ['style' => 'width: 30%']
                                    ],
                                    [
                                        'attribute' => 'mobile_no',
                                        'value' => function ($model) {
                                            return $model->mobile_no;
                                        },
                                        'contentOptions' => ['style' => 'width: 20%']
                                    ],
                                    [
                                        'attribute' => 'role',
                                        'value' => function ($model) {
                                            return $model->memberrole != null ? $model->memberrole->role : '';
                                        },
                                        'contentOptions' => ['style' => 'width: 20%']
                                    ],
                                    [
                                        'attribute' => 'bank_operator',
                                        'value' => function ($model) {
                                            return $model->operator;
                                        },
                                        'contentOptions' => ['style' => 'width: 20%']
                                    ],
                                ],
                            ]);
                            ?>
                        </div> 
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>        