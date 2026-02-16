<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ApplicationData */

$this->title = 'Create Application Data';
$this->params['breadcrumbs'][] = ['label' => 'Application Datas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="application-data-create">
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
