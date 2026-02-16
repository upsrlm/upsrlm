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
use common\models\master\MasterRole;

$this->title = 'SRLM BC Selection report';
$this->params['icon'] = 'fa fa-pie-chart';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="col-xs-12 applicant" id="printcontaineer">
    <?php
    if ($dataProvider->count > 0)
        echo
        GridView::widget([
            'dataProvider' => $dataProvider,
            'layout' => "\n{pager}\n{summary}\n{items}\n{pager}\n{summary}",
            'tableOptions' => ['class' => 'table table-striped table-bordered table-condensed table-hover'],
            'id' => 'grid-data',
            'summary' => "Showing <b>{begin}</b> - <b>{end}</b> of <b>{totalCount}</b> results",
            'pjax' => TRUE,
            'floatHeader' => true,
            'floatHeaderOptions' => ['scrollingTop' => '50'],
            'columns' => [
                ['class' => 'yii\grid\SerialColumn', 'contentOptions' => ['style' => 'width: 4%', 'class' => 'text-center']],
                [
                    'attribute' => 'name',
                    'enableSorting' => false,
                    'header' => 'Candidiate Detail',
                    'contentOptions' => ['style' => 'width: 30%'],
                    'format' => 'raw',
                    'value' => function ($model) {
                        $status = '';
                        return "Application No. : " . $model->id . "<br/>Name : " . $model->name . '<br/>Guardian name : ' . $model->guardian_name .  '<br/>Age : ' . $model->age . '<br/>Category : ' . $model->castrel->name_eng ;
                        //return Html::a($model->name, "/srlm/data/bcselection/view?id=" . $model->id, ['target' => '_blank', 'data-pjax' => "0"]) . $status;
                        ///return $model->name_of_head_of_household;
                    },
                ],
                [
                    'attribute' => 'address',
                    'enableSorting' => false,
                    'format' => 'html',
                    'header' => 'Address<br/>Mobile No',
                    'contentOptions' => ['style' => 'width: 20%'],
                    'value' => function ($model) {
                        return $model->fulladdressgp.'<br/><br/>Mobile Number : ' . common\helpers\Utility::mask($model->mobile_number) . '<br/>Verified mobile no :  ' . common\helpers\Utility::mask($model->user->mobile_no);
                    },
                ],
                [
                    'attribute' => 'Images',
                    'header' => 'Aadhar front photo',
                    'format' => 'raw',
                    'contentOptions' => ['style' => 'width: 22%'],
                    'value' => function ($model) {
                        $html = '';
                        if ($model->user->aadhar_front_photo != null) {
                            $html .= ' <span class="profile-picture">
                                        <img width="140px" height="140px" src="' . $model->aadhar_front_photo_url . '" data-src="' . $model->aadhar_front_photo_url . '"  class="lozad" title="aadhar_front_photo" style="cursor : pointer"/>
                                        </span>';
                        }
                        return $html;
                    }
                ],
                [
                    'attribute' => 'Images',
                    'header' => 'Aadhar back photo',
                    'format' => 'raw',
                    'contentOptions' => ['style' => 'width: 22%'],
                    'value' => function ($model) {
                        $html = '';
                        if ($model->user->aadhar_back_photo != null) {
                            $html .= '<span class="profile-picture">
                                        <img width="140px" height="140px" src="' . $model->aadhar_back_photo_url . '" data-src="' . $model->aadhar_back_photo_url . '"  class="lozad" title="aadhar_back_photo" style="cursor : pointer"/>
                                        </span>';
                        }
                        return $html;
                    }
                ],
            ],
        ]);
    ?>


</div>



