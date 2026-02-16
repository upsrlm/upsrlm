<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model bc\models\UpsrlmFrameworkValidation */

$this->title = 'Create Upsrlm Framework Validation';
$this->params['breadcrumbs'][] = ['label' => 'Upsrlm Framework Validations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="upsrlm-framework-validation-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
