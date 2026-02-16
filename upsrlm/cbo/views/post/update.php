<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\CboVo */

$this->title = 'Update Cbo Vo: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Cbo Vos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="cbo-vo-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
