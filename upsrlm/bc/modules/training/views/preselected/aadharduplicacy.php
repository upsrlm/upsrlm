<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use kartik\tabs\TabsX;
use bc\modules\selection\models\form\DashboardSearchForm;
use common\models\User;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;
use yii\bootstrap\Modal;
use common\models\master\MasterRole;
use bc\modules\selection\models\SrlmBcApplication;

$this->title = 'Aadhar duplicacy';
$this->params['icon'] = 'fa fa-pie-chart';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="nfsa-base-survey-index">
    

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'layout' => "\n{summary}\n{items}",
        'tableOptions' => ['class' => 'table table-striped table-bordered table-condensed table-hover'],
        'id' => 'grid-data',
        'summary' => "Showing <b>{begin}</b> - <b>{end}</b> of <b>{totalCount}</b> results",
       
        'columns' => [
            ['class' => 'yii\grid\SerialColumn', 'contentOptions' => ['style' => 'width: 4%', 'class' => 'text-center']],
            [
                'attribute' => 'name',
                'enableSorting' => false,
                
                'format' => 'raw',
                'value' => function ($model) {
                    return $model->name; 
                    //return Html::a($model->name, "/selection/data/application/view?id=" . $model->id, ['target' => '_blank', 'data-pjax' => "0"]);
                    
                },
            ],
            [
                'attribute' => 'guardian_name',
                'format' => 'html',
                'enableSorting' => false,
                
                'value' => function ($model) {
                    return $model->guardian_name != null ? $model->guardian_name : '';
                },
            ],
            [
                'attribute' => 'aadhar_number',
                'format' => 'raw',
                'enableSorting' => false,
                'value' => function ($model) {

                    return common\helpers\Utility::maskaadhar($model->aadhar_number);
                }
            ],
            [
                'attribute' => 'mobile_number',
                'contentOptions' => ['style' => 'width: 7%'],
                'enableSorting' => false,
                'format' => 'raw',
                'value' => function ($model) {
                    return common\helpers\Utility::mask($model->mobile_number) . '<br/>' . common\helpers\Utility::mask($model->mobile_no);
                },
            ],
            [
                'attribute' => 'age',
                'enableSorting' => false,
                'format' => 'raw',
                'value' => function ($model) {

                    return $model->age != null ? $model->age : '';
                },
            ],
            [
                'attribute' => 'reading_skills',
                'enableSorting' => false,
                'label' => 'Education',
                'format' => 'html',
                'value' => function ($model) {

                    return $model->readingskills != null ? $model->readingskills->name_eng : '';
                },
            ],
            [
                'attribute' => 'address',
                'enableSorting' => false,
                'format' => 'html',
                'value' => function ($model) {
                    return $model->fulladdress;
                },
            ],
            [
                'attribute' => 'Status',
                'enableSorting' => false,
                'format' => 'html',
                'value' => function ($model) {
                    return $model->tstatus;
                },
            ],
            [
                'attribute' => 'bc_shg_funds_status',
                'header' => 'BC-SHG payment status',
                //'visible' => in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_BANK_DISTRICT_UNIT, MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL,MasterRole::ROLE_CORPORATE_BCS]),
                'enableSorting' => false,
                'format' => 'raw',
                'value' => function ($model) {
                    $status = '';
                    if ($model->bc_shg_funds_status == 1) {
                        $status = 'Yes';
                    }
                    if ($model->bc_shg_funds_status == 0) {
                        $status = 'No';
                    }
                    return $status;
                }
            ],
            
            [
                'attribute' => 'bc_support_funds_received',
                'header' => 'Acknowledge support funds received',
                'enableSorting' => false,
                'format' => 'raw',
                'value' => function ($model) {
                    return $model->bc_support_funds_received == 1 ? 'Yes' : 'No';
                }
            ],
            [
                'attribute' => 'bc_handheld_machine_recived',
                'header' => 'Acknowledge handheld machine received',
                'enableSorting' => false,
                'format' => 'raw',
                'value' => function ($model) {
                    return $model->bc_handheld_machine_recived == 1 ? 'Yes' : 'No';
                }
            ],
            [
                'attribute' => 'bankidbc',
                'header' => 'Bank ID of BC',
                'enableSorting' => false,
                'format' => 'raw',
                'value' => function ($model) {
                    return $model->bankidbc != null ? $model->bankidbc : '';
                }
            ],        
        ],
    ]);
    ?>


</div>

    



