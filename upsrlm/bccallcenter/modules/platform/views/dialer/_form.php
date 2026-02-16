<?php

use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;
use kartik\widgets\Select2;

$this->title = 'Test Call';
?>
<?php
$form = ActiveForm::begin([
            'enableClientValidation' => FALSE,
            'enableAjaxValidation' => FALSE,
            'options' => ['enctype' => 'multipart/form-data'],
        ]);
?>

<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-container show">
                <div class="panel-content">
                    <div class="panel-hdr">
                        <h3><?= $this->title ?></h3>
                    </div>
                    <div class="col-md-6">
                        <?php
                        echo $form->field($model, 'customer_number')->widget(Select2::classname(), [
                            'data' => $model->customer_number_option,
                            'options' => ['placeholder' => 'Call To'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ])->label('Call To');
                        ?>
                        <?php
                        //$form->field($model, 'customer_number')->textInput(['type' => 'number', 'min' => 0])->label('Mobile Number'); 
                        ?>
                    </div>
                    <div class="col-md-6 pt-2">
                        <?= Html::submitButton('Make a Call', ['id' => 'buttonsave', 'class' => 'btn btn-info', 'value' => 'save', 'name' => 'save']) ?>
                    </div>
                    <div class="col-lg-8 mb-2">
                        <div class="form-group pt-2">
                            <div style="display:none">
                                <?= $form->field($model, 'calling_agent_id')->hiddenInput()->label(false); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>