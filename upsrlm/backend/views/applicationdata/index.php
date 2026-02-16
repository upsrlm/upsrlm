<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use common\models\master\MasterRole;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ApplicationDataSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Application Datas';
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

                    <!-- <button class="btn btn-panel waves-effect waves-themed" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                    <button class="btn btn-panel waves-effect waves-themed" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button> -->
                    <!--                    <button class="btn btn-panel waves-effect waves-themed" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>-->
                </div>
            </div>
            <div class="panel-container show">
                <div class="panel-content">
                    <?php
                    Pjax::begin([
                        'id' => 'grid-data',
                        'enablePushState' => FALSE,
                        'enableReplaceState' => FALSE,
                        'timeout' => false,
                    ]);
                    ?>
                    <div class="clearfix"></div>
                    <?=
                    GridView::widget([
                        'dataProvider' => $dataProvider,
                        'layout' => "\n{pager}\n{summary}\n{items}\n{pager}\n{summary}",
                        'tableOptions' => ['class' => 'table table-striped table-bordered table-condensed table-hover'],
                        'id' => 'grid-data',
//                        'summary' => "Showing <b>{begin}</b> - <b>{end}</b> of <b>{totalCount}</b> results",
//                        'pjax' => TRUE,
//                        'floatHeader' => true,
//                        'floatHeaderOptions' => ['scrollingTop' => '50'],
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            'bc_identify',
                            'bc_preselect',
                            'bc_trained',
                            'bc_trained_and_certified',
                            'bc_onboarded',
                            'bc_operational',
                            'clf_formed',
                            'clf_e_registered',
                            'clf_app_operated',
                            'clf_start_up_received',
                            'clf_cif_received',
                            'clf_isf_received',
                            'clf_infra_fund_received',
                            'clf_others_fund_received',
                            'clf_fund_utilization_efficiency',
                            'clf_stagnant_fund',
                            'vo_formed',
                            'vo_e_registered',
                            'vo_app_operated',
                            'vo_start_up_received',
                            'vo_vrf_received',
                            'vo_lf_received',
                            'vo_patb_received',
                            'vo_agey_received',
                            'vo_isf_received',
                            'shg_formed',
                            'shg_e_registered',
                            'shg_members',
                            'shg_start_up_received',
                            'shg_cif_received',
                            'shg_repeated_bank_loan',
                            'shg_fund_3_received',
                            'shg_fund_4_received',
                            'shg_fund_utilization_efficiency',
                            'shg_stagnant_fund',
                            'ga_total_users',
                            'ga_total_pageviews',
                            'ga_last_updated_on',
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'visible' => in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN]),
                                'template' => '{update}{view}',
                            ],
                        ],
                    ]);
                    ?>
                    <?php Pjax::end(); ?> 
                </div>
            </div>
        </div>    
    </div>
</div>  
