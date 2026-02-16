<?php

use yii\helpers\Html;
use yii\widgets\Pjax;


$this->title = 'Training Center';
$this->params['icon'] = 'fa fa-pie-chart';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="training-default-index">
        <div class="col-md-12">
            <h2> Update <?= $this->title;?></h2>
        </div>
        <?= $this->render('_form', [
                'model' => $model,
            ]) 
        ?>
</div>