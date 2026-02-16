<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\master\SafaiKarmi */

$this->title = 'Create Safai Karmi';
$this->params['breadcrumbs'][] = ['label' => 'Safai Karmis', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="safai-karmi-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
