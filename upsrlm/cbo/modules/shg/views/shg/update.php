<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\shg\models\Shg */

$this->title = 'Update Shg: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Shgs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="shg-update">

    <div class="panel panel-default">
        <div class='panel-body'>
            <h1><?= Html::encode($this->title) ?></h1>

            <?=
            $this->render('_form', [
                'model' => $model,
            ])
            ?>
        </div>
    </div>    

</div>
