<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\bootstrap4\ActiveForm;
use yii\widgets\Pjax;
use kartik\select2\Select2;
use kartik\widgets\DepDrop;
use kartik\date\DatePicker;
use kartik\password\PasswordInput;
use app\models\UserModel;

$this->title = 'Change login method for ' . $model->user->name;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['/user']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>
                    <?= $this->title ?>
                </h2>
                <div class="panel-toolbar">

                    <!-- <button class="btn btn-panel waves-effect waves-themed" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                    <button class="btn btn-panel waves-effect waves-themed" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button> -->
                    <!--                    <button class="btn btn-panel waves-effect waves-themed" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>-->
                </div>
            </div>
            <div class="panel-container show">
                <div class="panel-content">

                    <?php
                    $form = ActiveForm::begin([
                                'id' => 'bdo-form',
                                'options' => ['class' => 'form-horizontal', 'id' => 'bdo-form'],
                                'fieldConfig' => [
                                    'template' => "{label}\n<div class=\"col-lg-4\">{input}</div>\n<div >{error}</div>",
                                    'labelOptions' => ['class' => 'col-md-3 control-label'],
                                ],
                                'enableAjaxValidation' => true,
                                'enableClientValidation' => false,
                    ]);
                    ?>
                    <?php
                    echo $form->field($model, 'login_by_otp')->widget(kartik\select2\Select2::classname(), [
                        'data' => $model->login_by_otp_option,
                        'size' => Select2::MEDIUM,
                        'options' => ['placeholder' => 'Select Login', 'multiple' => false],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                    <div class="form-group">
                        <div class="col-sm-offset-4 ">
                            <?= Html::submitButton('Save', ['class' => 'btn btn-info']) ?>
                        </div>
                    </div>

                    <?php ActiveForm::end(); ?>

                </div>   
            </div>
        </div> 
    </div> 
</div>    
<?php
$css = <<<css
   div.required label.control-label:after {
    content: " *";
    color: red;
}
css;
$this->registerCss($css);
?>