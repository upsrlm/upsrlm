<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap4\ActiveForm;
use kartik\widgets\DatePicker;

$this->title = 'Capturing unwilling of candidate : ' . $model->bc_model->name;
?>
<?php echo $this->render('bc_view_unwilling', ['model' => $model]); ?>
<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>
                    <?= $this->title ?>
                </h2>
                <div class="panel-toolbar">

                  
                </div>
            </div>
            <div class="panel-container show">
                <div class="panel-content">


                    <?php
                    $form = ActiveForm::begin([
                                'enableClientValidation' => false,
                                'enableAjaxValidation' => TRUE,
                                'options' => ['id' => 'unwilling', 'enctype' => 'multipart/form-data'],
                    ]);
                    ?>

                    <?= $form->field($model, 'unwilling_reason')->checkboxList($model->unwilling_reason_option) ?>
                    <?php
//            echo $form->field($model, 'unwilling_reason7_text', [
//                'template' => '{input}{error}',
//            ])->textInput()->label('');
                    ?>

                    <div class="form-group">
                        <div class="col-lg-offset-5 col-lg-11">
                            <?= Html::submitButton('Submit', ['id' => 'buttonsave', 'class' => 'btn btn-info', 'value' => 'save', 'name' => 'save']) ?>

                        </div>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
















