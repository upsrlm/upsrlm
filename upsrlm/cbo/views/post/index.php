<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CboVoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Cbo Vos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cbo-vo-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Cbo Vo', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'state_code',
            'state_name',
            'division_code',
            'division_name',
            //'district_code',
            //'district_name',
            //'block_code',
            //'block_name',
            //'gram_panchayat_code',
            //'gram_panchayat_name',
            //'name_of_vo',
            //'date_of_formation',
            //'no_of_shg_connected',
            //'bank_account_no_of_the_vo',
            //'name_of_bank',
            //'branch',
            //'branch_code_or_ifsc',
            //'date_of_opening_the_bank_account',
            //'created_by',
            //'updated_by',
            //'created_at',
            //'updated_at',
            //'status',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
