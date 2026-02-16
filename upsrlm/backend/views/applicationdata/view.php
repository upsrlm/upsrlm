<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\ApplicationData */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Application Datas', 'url' => ['index']];
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
                    <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                    <button class="btn btn-panel waves-effect waves-themed" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                    <button class="btn btn-panel waves-effect waves-themed" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                    <!--                    <button class="btn btn-panel waves-effect waves-themed" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>-->
                </div>
            </div>
            <div class="panel-container show">
                <div class="panel-content">

                    <?=
                    DetailView::widget([
                        'model' => $model,
                        'attributes' => [
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
                        ],
                    ])
                    ?>

                </div>
            </div>     
        </div>
    </div>     
</div>