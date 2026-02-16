<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\CboVo */

$this->title = 'Create Cbo Vo';
$this->params['breadcrumbs'][] = ['label' => 'Cbo Vos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cbo-vo-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
