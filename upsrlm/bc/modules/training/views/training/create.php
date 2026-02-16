<?php

use yii\helpers\Html;
use yii\widgets\Pjax;

$this->title = 'Add Training';
$this->params['breadcrumbs'][] = ['label' => 'Training list', 'url' => ['index']];
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