<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\master\SafaiKarmi */

$this->title = 'Update Safai Karmi: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Safai Karmis', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="safai-karmi-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
