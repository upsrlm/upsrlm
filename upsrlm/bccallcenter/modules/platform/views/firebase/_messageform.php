<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;
use common\models\User;
use kartik\date\DatePicker;
use kartik\password\PasswordInput;

$this->title = 'Send Notification';
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

                    <button class="btn btn-panel waves-effect waves-themed" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                    <button class="btn btn-panel waves-effect waves-themed" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                    <!--                    <button class="btn btn-panel waves-effect waves-themed" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>-->
                </div>
            </div>
            <div class="panel-container show">
                <div class="panel-content">
                    <?php
                    if (isset($model->user_model)) {
                        echo $this->render('_userprofile', ['model' => $model->user_model, 'bc_model' => $model->bc_model]);
                    }
                    ?>
                    <?php
                    $form = ActiveForm::begin([
                                'id' => 'bdo-form',
                                'options' => ['class' => 'form-horizontal', 'id' => 'user-form'],
                                'fieldConfig' => [
                                    'template' => "{label}\n<div >{input}</div>\n<div >{error}</div>",
                                    'labelOptions' => ['class' => ' control-label'],
                                ],
                                'enableAjaxValidation' => true,
                                'enableClientValidation' => false,
                    ]);
                    ?>
                    <div class="row">
                        <div class="col-xl-12 col-md-12 mb-2">
                            <?= $form->field($model, 'message_title')->textInput(['maxlength' => true, 'placeholder' => 'Title']) ?>
                        </div>
                        <div class="col-xl-12 col-md-12 mb-2">
                            <?= $form->field($model, 'message')->textarea(['rows' => '8', 'placeholder' => 'Message']) ?>
                        </div>

                    </div>


                    <div class="form-group">
                        <div class="col-sm-offset-4 ">
                            <?= Html::submitButton('Send', ['class' => 'btn btn-info']) ?>
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