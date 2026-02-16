<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\shg\models\Shg */

$this->title = 'Update Village Organization/ विलेज आर्गेनाइजेशन (ग्राम संगठन) का नाम: ' . $model->name_of_vo;
$this->params['breadcrumbs'][] = ['label' => 'VO', 'url' => ['index']];

$this->params['breadcrumbs'][] = 'Update';
?>
<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>
                    <?= Html::encode($this->title) ?>
                </h2>
                <div class="panel-toolbar">

                    <?= Html::a('VO', ['/vo'], ['class' => 'btn btn-success']) ?>

                    <button class="btn btn-panel waves-effect waves-themed" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                    <button class="btn btn-panel waves-effect waves-themed" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                    <!--                    <button class="btn btn-panel waves-effect waves-themed" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>-->
                </div>  
            </div> 
            <div class="panel-container show">
                <div class="panel-content">
                    <?=
                    $this->render('_form', [
                        'model' => $model,
                    ])
                    ?>
                </div>
            </div>          
        </div>
    </div>     
</div>
