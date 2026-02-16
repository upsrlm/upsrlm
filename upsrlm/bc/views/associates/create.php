<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model bc\models\PartnerAssociates */

$this->title = 'Create Partner Associates';
$this->params['breadcrumbs'][] = ['label' => 'Partner Associates', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="partner-associates-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
