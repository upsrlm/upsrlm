<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel bc\models\PartnerAssociatesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Partner Associates';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="partner-associates-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Partner Associates', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'master_bank_id',
            'name_of_the_field_officer',
            'gender',
            'date_of_birth',
            //'age',
            //'photo_profile',
            //'designation',
            //'mobile_no',
            //'alternate_mobile_no',
            //'whatsapp_no',
            //'email_id:email',
            //'photo_aadhaar_front',
            //'photo_aadhaar_back',
            //'company_letter',
            //'name_of_supervisor',
            //'designation_of_supervisor',
            //'mobile_no_of_supervisor',
            //'bank_name',
            //'bank_branch',
            //'bank_ifsc_code',
            //'bank_account_number',
            //'created_by',
            //'created_at',
            //'updated_by',
            //'updated_at',
            //'status',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
