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

/* @var $this yii\web\View */
/* @var $searchModel bc\models\transaction\BcTransactionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = "Sbi Mou";
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>
                    <?= $this->title ?>
                </h2>
                <div class="panel-toolbar">


                </div>
            </div>
            <div class="panel-container show">
                <div class="panel-content">
                    <h2>Allotment of Gram Panchayats for BC-Sakhis (Service Areas)   <a href="/report/sbi/downloadp" class="btn btn-sm btn-info"><i class="fal fa fa-download"> </i> Download</a></h2>

                    <?=
                    GridView::widget([
                        'dataProvider' => $dataProvider1,
                        'layout' => "{items}",
                        'tableOptions' => ['class' => 'table table-striped table-bordered table-condensed table-hover'],
                        'id' => 'grid-data',
                        'summary' => "Showing <b>{begin}</b> - <b>{end}</b> of <b>{totalCount}</b> results",
                        'pjax' => TRUE,
                        'showPageSummary'=>true,
                        'pageSummaryContainer' => ['class' => 'font-weight-bold bg-success-100','style' => 'bottom: 50px'],
                        'pageSummaryRowOptions'=>['class' => 'font-weight-bold bg-success-100'],
                        'beforeHeader' => true ? [
                            [
                                'columns' => [
                                    ['content' => 'क्रमांक', 'options' => ['colspan' => 1, 'class' => 'font-weight-bold bg-success-100 ']],
                                    ['content' => 'जनपद के नाम', 'options' => ['colspan' => 1, 'class' => 'font-weight-bold bg-success-100']],
                                    ['content' => 'मौजूदा पार्टनर बैंक', 'options' => ['colspan' => 1, 'class' => 'font-weight-bold bg-success-100']],
                                    ['content' => 'कुल ग्राम पंचायतें _ स्थानीय निकाय चुनाव २०२३ के सापेक्ष', 'options' => ['colspan' => 2, 'class' => 'font-weight-bold bg-success-100']],
                                    ['content' => 'बीसी सखी ऑनबोर्ड', 'options' => ['colspan' => 1, 'class' => 'font-weight-bold bg-success-100']],
                                    ['content' => 'बीसी सखी ऑनबोर्ड(वर्तमान में)', 'options' => ['colspan' => 1, 'class' => 'font-weight-bold bg-success-100']],
                                    ['content' => 'ग्राम पंचायतें जहां बीसी सखी ऑनबोर्ड', 'options' => ['colspan' => 1, 'class' => 'font-weight-bold bg-success-100']],
                                    ['content' => 'कार्यान्वयन के चरण', 'options' => ['colspan' => 1, 'class' => 'font-weight-bold bg-success-100']],
                                ],
                            ]
                                ] : '',
                        'columns' => [
                            [
                                'class' => 'yii\grid\SerialColumn',
                            ],
                            [
                                'attribute' => 'district_name',
                                'header' => 'जनपद के नाम',
                                'enableSorting' => false,
                                'format' => 'raw',
                                'contentOptions' => ['data-title' => 'जनपद के नाम'],
                                'pageSummary'=>'योग',
                                'value' => function ($model) {
                                    return isset($model->district_name) ? $model->district_name : '';
                                },
                            ],
                            [
                                'attribute' => 'existing_partner_name',
                                'header' => 'मौजूदा पार्टनर बैंक',
                                'enableSorting' => false,
                                'format' => 'raw',
                                'contentOptions' => ['data-title' => 'मौजूदा पार्टनर बैंक'],
                                'pageSummary'=>'योग',
                                'value' => function ($model) {
                                    return isset($model->existing_partner_name) ? $model->existing_partner_name : '';
                                },
                            ],            
                            [
                                'attribute' => 'before_2023_ulb_election_gp_count',
                                'header' => 'पहले',
                                'enableSorting' => false,
                                'format' => 'raw',
                                'contentOptions' => ['data-title' => 'पहले'],
                                'pageSummary'=>true,
                                'value' => function ($model) {

                                    return $model->before_2023_ulb_election_gp_count;
                                },
                            ],
                            [
                                'attribute' => 'current_gp_count',
                                'header' => 'वर्तमान में',
                                'enableSorting' => false,
                                'format' => 'raw',
                                'contentOptions' => ['data-title' => 'वर्तमान में'],
                                'pageSummary'=>true,
                                'value' => function ($model) {
                                    return $model->current_gp_count;
                                },
                            ],
                            [
                                'attribute' => 'bc_sakhi_onboard',
                                'header' => 'बीसी सखी ऑनबोर्ड',
                                'format' => 'raw',
                                'contentOptions' => ['data-title' => 'बीसी सखी ऑनबोर्ड'],
                                'pageSummary'=>true,
                                'value' => function ($model) {
                                    return $model->bc_sakhi_onboard;
                                }
                            ],
                            [
                                'attribute' => 'bc_sakhi_onboard_current',
                                'header' => 'बीसी सखी ऑनबोर्ड(वर्तमान में)',
                                'format' => 'raw',
                                'contentOptions' => ['data-title' => 'बीसी सखी ऑनबोर्ड(वर्तमान में)','class' => 'text-success'],
                                'pageSummary'=>true,
                                'value' => function ($model) {
                                    return $model->bc_sakhi_onboard_current;
                                }
                            ],
                            [
                                'attribute' => 'gram_pardhan_go_contact',
                                'header' => ' SBI को आवंटित की जानेवाली शेष ग्राम पंचायतें <i class="text-danger">*</>',
                                'format' => 'raw',
                                'contentOptions' => ['data-title' => 'SBI को आवंटित की जानेवाली शेष ग्राम पंचायतें', 'style' => 'color:#0000FF'],
                                'pageSummary'=>true,
                                'value' => function ($model) {
                                    return $model->bc_sakhi_onboard_remain;
                                }
                            ],
                            [
                                'attribute' => 'gram_pardhan_login',
                                'header' => 'कार्यान्वयन के चरण',
                                'format' => 'raw',
                                'contentOptions' => ['data-title' => 'कार्यान्वयन के चरण'],
                                'value' => function ($model) {
                                   return $model->work_phase_name;
                                }
                            ],
                        ],
                    ]);
                    ?>    
                    <h2> जिन जनपदों में SBI सभी ग्राम पंचायतों (संपूर्ण जनपद) में पार्टनर बैंक के रूप में कार्य करेगी, उनकी सूची

                        निम्नवत् है -</h2>
                     <?=
                    GridView::widget([
                        'dataProvider' => $dataProvider2,
                        'layout' => "{items}",
                        'tableOptions' => ['class' => 'table table-striped table-bordered table-condensed table-hover'],
                        'id' => 'grid-data',
                        'summary' => "Showing <b>{begin}</b> - <b>{end}</b> of <b>{totalCount}</b> results",
                        'pjax' => TRUE,
                        'showPageSummary'=>true,
                        'pageSummaryContainer' => ['class' => 'font-weight-bold bg-success-100','style' => 'bottom: 50px'],
                        'pageSummaryRowOptions'=>['class' => 'font-weight-bold bg-success-50'],
                        'beforeHeader' => true ? [
                            [
                                'columns' => [
                                    ['content' => 'क्रमांक', 'options' => ['colspan' => 1, 'class' => 'font-weight-bold bg-success-100 ']],
                                    ['content' => 'जनपद के नाम', 'options' => ['colspan' => 1, 'class' => 'font-weight-bold bg-success-100']],
                                    ['content' => 'मौजूदा पार्टनर बैंक', 'options' => ['colspan' => 1, 'class' => 'font-weight-bold bg-success-100']],
                                    ['content' => 'कुल ग्राम पंचायतें _ स्थानीय निकाय चुनाव २०२३ के सापेक्ष', 'options' => ['colspan' => 2, 'class' => 'font-weight-bold bg-success-100']],
                                    ['content' => 'बीसी सखी ऑनबोर्ड', 'options' => ['colspan' => 1, 'class' => 'font-weight-bold bg-success-100']],
                                    ['content' => 'बीसी सखी ऑनबोर्ड(वर्तमान में)', 'options' => ['colspan' => 1, 'class' => 'font-weight-bold bg-success-100']],
                                    ['content' => 'ग्राम पंचायतें जहां बीसी सखी ऑनबोर्ड', 'options' => ['colspan' => 1, 'class' => 'font-weight-bold bg-success-100']],
                                    ['content' => 'कार्यान्वयन के चरण', 'options' => ['colspan' => 1, 'class' => 'font-weight-bold bg-success-100']],
                                ],
                            ]
                                ] : '',
                        'columns' => [
                            [
                                'class' => 'yii\grid\SerialColumn',
                            ],
                            [
                                'attribute' => 'district_name',
                                'header' => 'जनपद के नाम',
                                'enableSorting' => false,
                                'format' => 'raw',
                                'contentOptions' => ['data-title' => 'जनपद के नाम'],
                                'pageSummary'=>'योग',
                                'value' => function ($model) {
                                    return isset($model->district_name) ? $model->district_name : '';
                                },
                            ],
                            [
                                'attribute' => 'existing_partner_name',
                                'header' => 'मौजूदा पार्टनर बैंक',
                                'enableSorting' => false,
                                'format' => 'raw',
                                'contentOptions' => ['data-title' => 'मौजूदा पार्टनर बैंक'],
                                'pageSummary'=>'योग',
                                'value' => function ($model) {
                                    return isset($model->existing_partner_name) ? $model->existing_partner_name : '';
                                },
                            ],                
                            [
                                'attribute' => 'before_2023_ulb_election_gp_count',
                                'header' => 'पहले',
                                'enableSorting' => false,
                                'format' => 'raw',
                                'contentOptions' => ['data-title' => 'पहले'],
                                'pageSummary'=>true,
                                'value' => function ($model) {

                                    return $model->before_2023_ulb_election_gp_count;
                                },
                            ],
                            [
                                'attribute' => 'current_gp_count',
                                'header' => 'वर्तमान में <i class="text-danger">*</>',
                                'enableSorting' => false,
                                'format' => 'raw',
                                'contentOptions' => ['data-title' => 'वर्तमान में'],
                                'pageSummary'=>true,
                                'value' => function ($model) {
                                    return $model->current_gp_count;
                                },
                            ],
                            [
                                'attribute' => 'bc_sakhi_onboard',
                                'header' => 'बीसी सखी ऑनबोर्ड',
                                'format' => 'raw',
                                'contentOptions' => ['data-title' => 'बीसी सखी ऑनबोर्ड'],
                                'pageSummary'=>true,
                                'value' => function ($model) {
                                    return $model->bc_sakhi_onboard;
                                }
                            ],
                            [
                                'attribute' => 'bc_sakhi_onboard_current',
                                'header' => 'बीसी सखी ऑनबोर्ड(वर्तमान में)',
                                'format' => 'raw',
                                'contentOptions' => ['data-title' => 'बीसी सखी ऑनबोर्ड(वर्तमान में)', 'style' => 'color:#0000FD'],
                                'pageSummary'=>true,
                                'value' => function ($model) {
                                    return $model->bc_sakhi_onboard_current;
                                }
                            ],
                            [
                                'attribute' => 'gram_pardhan_go_contact',
                                'header' => ' SBI को आवंटित की जानेवाली शेष ग्राम पंचायतें',
                                'format' => 'raw',
                                'contentOptions' => ['data-title' => 'SBI को आवंटित की जानेवाली शेष ग्राम पंचायतें', 'style' => 'color:#0000FF'],
                                'pageSummary'=>true,
                                'value' => function ($model) {
                                    return $model->bc_sakhi_onboard_remain;
                                }
                            ],
                            [
                                'attribute' => 'gram_pardhan_login',
                                'header' => 'कार्यान्वयन के चरण',
                                'format' => 'raw',
                                'contentOptions' => ['data-title' => 'कार्यान्वयन के चरण'],
                                'value' => function ($model) {
                                    return $model->work_phase_name;
                                }
                            ],
                        ],
                    ]);
                    ?>  
                </div>
            </div> 
        </div>
    </div>
</div>
