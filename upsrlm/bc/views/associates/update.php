<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model bc\models\PartnerAssociates */

$this->title = 'Update Partner Associates: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Partner Associates', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="partner-associates-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
