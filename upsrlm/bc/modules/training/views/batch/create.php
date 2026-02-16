<?php

use yii\helpers\Html;
use yii\widgets\Pjax;

$this->title = 'Add Batch Participant';
$this->params['icon'] = 'fa fa-pie-chart';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="training-default-index">
    <div class="panel panel-default">
        <div class='panel-body'>
            <?=
            $this->render('_form', [
                'model' => $model,
            ])
            ?>
        </div>
    </div>  
</div>
