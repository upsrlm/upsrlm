<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\shg\models\Shg */

$this->title = 'Create SHG';
$this->params['breadcrumbs'][] = ['label' => 'SHG', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="shg-create">
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
