<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel bc\models\UpsrlmFrameworkValidationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Upsrlm Framework Validations';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="upsrlm-framework-validation-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Upsrlm Framework Validation', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'key_id',
            'deliverables_id',
            'start_date',
            'operational_stage',
            //'current_status',
            //'validation_by',
            //'validation_status',
            //'validation_datetime',
            //'created_by',
            //'updated_by',
            //'created_at',
            //'updated_at',
            //'status',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
