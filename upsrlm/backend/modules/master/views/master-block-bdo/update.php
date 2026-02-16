<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\master\MasterBlockBdo */

$this->title = 'Update Master Block Bdo: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Master Block Bdos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="master-block-bdo-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
