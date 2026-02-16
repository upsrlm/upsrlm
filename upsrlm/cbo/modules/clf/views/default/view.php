<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use common\helpers\Utility;

/* @var $this yii\web\View */
/* @var $model app\models\CboVo */

$this->title = 'CLF :' . $model->name_of_clf;
$this->params['breadcrumbs'][] = ['label' => "CLF's", 'url' => ['/vo']];
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
                    <?php if (($model->status == \cbo\models\CboClf::STATUS_SAVE and $model->created_by == Yii::$app->user->identity->id)) { ?>
                        <?= Html::a('Update', ['/clf/default/update', 'clfid' => $model->id], ['class' => 'btn btn-primary']) ?>
                    <?php } ?>
                    <!-- <button class="btn btn-panel waves-effect waves-themed" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                    <button class="btn btn-panel waves-effect waves-themed" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button> -->
                    <!--                    <button class="btn btn-panel waves-effect waves-themed" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>-->
                </div>
            </div>
            <div class="panel-container show">
                <div class="panel-content">
                    <div class="row">
                        <div class="col-lg-4">
                            <?=
                            DetailView::widget([
                                'model' => $model,
                                'attributes' => [
                                    [
                                        'attribute' => 'district_name',
                                        'label' => 'District',
                                        'format' => 'html',
                                        'value' => function ($model) {
                                            return $model->district_name;
                                        }
                                    ],
                                    [
                                        'attribute' => 'block_name',
                                        'label' => 'Block',
                                        'format' => 'html',
                                        'value' => function ($model) {
                                            return $model->block_name;
                                        }
                                    ],
                                    'id',
                                    'name_of_clf',
                                    'nrlm_clf_code',
                                    'date_of_formation',
                                    'no_of_vo_connected',
                                    'no_of_shg_connected',
                                    'no_of_gps_covered',
                                    [
                                        'attribute' => 'total_amount_received',
                                        'label' => 'Total amount received',
                                        'format' => 'html',
                                        'value' => function ($model) {
                                            return $model->getFunds()->sum('total_amount_received') != null ? Utility::numberIndiaStyle($model->getFunds()->sum('total_amount_received'), 2) : '';
                                        }
                                    ],
                                    [
                                        'attribute' => 'accountant_name',
                                        'label' => 'संकुल लेखाकार ',
                                    ],
                                    [
                                        'attribute' => 'accountant_number',
                                        'label' => 'संकुल लेखाकार मोबाइल नंबर ',
                                    ],
                                ],
                            ])
                            ?>
                        </div> 
                        <div class="col-lg-4">
                            <?=
                            DetailView::widget([
                                'model' => $model,
                                'attributes' => [
                                    'bank_account_no_of_the_clf',
                                    'name_of_bank',
                                    'branch',
                                    'branch_code_or_ifsc',
                                    'date_of_opening_the_bank_account',
//                            [
//                                'attribute' => 'total_amount_received',
//                                'label' => 'total amount received',
//                                'format' => 'html',
//                                'value' => function($model) {
//                                    return $model->getFunds()->sum('total_amount_received') != null ? Utility::numberIndiaStyle($model->getFunds()->sum('total_amount_received'), 2) : '';
//                                }
//                            ],
                                    [
                                        'attribute' => 'updated_balance_in_bank',
                                        'label' => "CLFs' updated balance in Bank",
                                        'format' => 'html',
                                        'value' => function ($model) {
                                            return $model->updated_balance_in_bank != null ? Utility::numberIndiaStyle($model->updated_balance_in_bank, 2) : '';
                                        }
                                    ],
                                    [
                                        'attribute' => 'updated_balance_in_bank_date',
                                        'label' => "CLF bank balance date",
                                        'format' => 'html',
                                        'value' => function ($model) {
                                            return $model->updated_balance_in_bank_date != null ? $model->updated_balance_in_bank_date : '';
                                        }
                                    ],
                                    [
                                        'attribute' => 'is_registered_under',
                                        'label' => "क्या संकुल/ CLF पंजीकृत है? ",
                                        'format' => 'html',
                                        'value' => function ($model) {
                                            return $model->isregistered;
                                        }
                                    ],
                                ],
                            ])
                            ?>
                            <br/>
                            <?= $model->passbook_photo != null ? '<span class="profile-picture">
                                        <img width="220px" height="220px" src="' . $model->passbookUrl . '" data-src="' . $model->passbookUrl . '"  class="lozad" title="Passbook photo"/>
                                        </span> ' : '-' ?>
                            <?= $model->registration_document_photo != null ? '<span class="profile-picture">
                                        <img width="220px" height="220px" src="' . $model->registrationdocumentphotoUrl . '" data-src="' . $model->registrationdocumentphotoUrl . '"  class="lozad" title="पंजीकरण के दस्तावेज की स्कैन कॉपी "/>
                                        </span> ' : '-' ?>
                        </div> 
                        <div class="col-lg-4">
                            <?=
                            DetailView::widget([
                                'model' => $model,
                                'attributes' => [
                                    'bank_account_no_of_the_clf2',
                                    'name_of_bank2',
                                    'branch2',
                                    'branch_code_or_ifsc2',
                                    'date_of_opening_the_bank_account2',
//                          
                                    [
                                        'attribute' => 'updated_balance_in_bank2',
                                        'label' => "CLFs' updated balance in Bank2",
                                        'format' => 'html',
                                        'value' => function ($model) {
                                            return $model->updated_balance_in_bank2 != null ? Utility::numberIndiaStyle($model->updated_balance_in_bank2, 2) : '';
                                        }
                                    ],
                                    [
                                        'attribute' => 'updated_balance_in_bank_date2',
                                        'label' => "CLF bank2 balance date",
                                        'format' => 'html',
                                        'value' => function ($model) {
                                            return $model->updated_balance_in_bank_date2 != null ? $model->updated_balance_in_bank_date2 : '';
                                        }
                                    ],
                                ],
                            ])
                            ?>
                            <br/>
                            <?= $model->passbook_photo2 != null ? '<span class="profile-picture">
                                        <img width="220px" height="220px" src="' . $model->passbook2Url . '" data-src="' . $model->passbook2Url . '"  class="lozad" title="Passbook photo"/>
                                        </span> ' : '-' ?>
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
                                        'contentOptions' => ['style' => 'width: 20%']
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
                                            return Utility::numberIndiaStyle($model->total_amount_received, 2);
                                        },
                                        'contentOptions' => ['style' => 'width: 20%']
                                    ],
                                    [
                                        'attribute' => 'balance_as_on_date',
                                        'value' => function ($model) {
                                            return Utility::numberIndiaStyle($model->balance_as_on_date, 2);
                                        },
                                        'contentOptions' => ['style' => 'width: 20%']
                                    ],
                                ],
                            ]);
                            ?>
                            <br/>
                            CLF Status
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
                                        'value' => $model->clfstatus,
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
                                        'contentOptions' => ['style' => 'width: 20%']
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
<?php
$js = <<<JS
                
        observer = lozad('.lozad', {
                                        load: function (el) {
                                            console.log('loading element');
                                            el.src = el.getAttribute('data-src');
                                            // Custom implementation to load an element
                                            // e.g. el.src = el.getAttribute('data-src');

                
                
                                                $(el).elevateZoom({
                                                    scrollZoom: true,
                                                    responsive: true,
                                                    zoomWindowOffetx: -600
                                                });
                                                $('.popbc').click(function () {
                                                    $('#imagecontent').html('');
                                                    $('#modal').modal('show')
                                                            .find('#imagecontent')
                                                            .load($(this).attr('value'));
                                                    document.getElementById('modalHeader').innerHTML = '<h4>' + $(this).attr('title') + '<i class="glyphicon glyphicon-remove icon-arrow-right pull-right" data-dismiss="modal" style="cursor : pointer;color:red"></i></h4>';
                                                });

//                                            $(function () {
//                                                $('.popb').elevateZoom({
//                                                    scrollZoom: true,
//                                                    responsive: true,
//                                                    zoomWindowOffetx: -600
//                                                });
//                                                $('.popbc').click(function () {
//                                                    $('#imagecontent').html('');
//                                                    $('#modal').modal('show')
//                                                            .find('#imagecontent')
//                                                            .load($(this).attr('value'));
//                                                    document.getElementById('modalHeader').innerHTML = '<h4>' + $(this).attr('title') + '<i class="glyphicon glyphicon-remove icon-arrow-right pull-right" data-dismiss="modal" style="cursor : pointer;color:red"></i></h4>';
//                                                });
//                                            });

                                        }
                                    }); // lazy loads elements with default selector as '.lozad'
                                    observer.observe();     
        
JS;
$this->registerJs($js);
?> 