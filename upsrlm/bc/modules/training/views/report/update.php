<?php

use yii\helpers\Html;
use yii\widgets\Pjax;

$this->title = 'Update Venue';
$this->params['breadcrumbs'][] = ['label' => 'Venues', 'url' => ['index']];
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