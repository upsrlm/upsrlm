<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\master\MasterBlockBdo */

$this->title = 'Create Master Block Bdo';
$this->params['breadcrumbs'][] = ['label' => 'Master Block Bdos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="master-block-bdo-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
