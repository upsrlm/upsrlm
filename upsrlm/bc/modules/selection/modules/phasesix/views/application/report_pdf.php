<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\bootstrap4\ActiveForm;
use yii\widgets\Pjax;
use kartik\grid\GridView;
use kartik\widgets\Select2;
use bc\modules\selection\models\form\DashboardSearchForm;
use common\models\User;
use common\models\master\MasterRole;
use common\helpers\Utility;

$this->title = 'SRLM BC Selection report';
$this->params['icon'] = 'fa fa-pie-chart';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="col-xs-12 applicant" id="printcontaineer">

    <?=
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
                'header' => 'Name / Guardian name / Mobile Number / Age / Social Category / OTP Verified mobile no',
                'contentOptions' => ['style' => 'width: 26%'],
                'format' => 'raw',
                'value' => function ($model) {
                    $status = '';
                    return $model->name . '<br/>' . $model->guardian_name . '<br/>' . Utility::mask($model->mobile_number) . '<br/>' . $model->age . '<br/>' . $model->castrel->name_eng . '<br/>' . $model->user->mobile_no;

                    ///return $model->name_of_head_of_household;
                },
            ],
            [
                'attribute' => 'address',
                'enableSorting' => false,
                'format' => 'html',
                'contentOptions' => ['style' => 'width: 24%'],
                'value' => function ($model) {
                    return $model->fulladdress;
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



