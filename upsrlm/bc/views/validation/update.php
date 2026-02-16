<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model bc\models\UpsrlmFrameworkValidation */

$this->title = 'Update Upsrlm Framework Validation: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Upsrlm Framework Validations', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="upsrlm-framework-validation-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
