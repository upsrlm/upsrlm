<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Url;
use \yii\widgets\Pjax;
use kartik\widgets\DepDrop;
use kartik\widgets\Select2;
use common\models\base\GenralModel;
use common\models\User;

/* @var $this yii\web\View */
/* @var $model bc\models\NotificationLogSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="notification-log-search">

    <?php
    $form = ActiveForm::begin([
                'layout' => 'inline',
                'options' => [
                    'class' => 'form-inline',
                    'data-pjax' => true,
                    'id' => 'Searchform'
                ],
                'method' => 'get',
    ]);
    ?>
    <div class="row">
        <div class="col-xl-4 col-md-4 mb-2">
        <?php
    echo $form->field($model, 'notification_template_id')->widget(Select2::classname(), [
        'data' => $model->temp_option,
        'options' => ['placeholder' => '', 'style' => 'width:250px'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ])->label('Notitifcation Template');
    echo "&nbsp;&nbsp;&nbsp;";
    echo $form->field($model, 'acknowledge_status')->widget(Select2::classname(), [
        'data' => [1 => 'Yes', 0 => 'No'],
        'options' => ['placeholder' => '', 'style' => 'width:250px'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ])->label('Acknowledgement Status');
    ?> 
        </div>
        <div class="col-xl-4 col-md-4 mb-2">
        <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary','style' => 'padding:7px 20px;margin-left:10px;']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary','style' => 'padding:7px 20px;']) ?>
    </div>
        </div>

    </div>

  


   

    <?php ActiveForm::end(); ?>
    <?php
    $js = <<<JS
$('#reloads').click(function() {
    location.reload();
});        
JS;
    $this->registerJs($js);

    $css = <<<cs
 .select2-selection__rendered {
    width: 200px !important;
}
cs;
    $this->registerCss($css);
    ?>
</div>
