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
use common\models\master\MasterRole;

$this->title = 'Call Scenario of BCs : ' . $model->bc_model->name;
?>
<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>
                    <?= 'Call Scenario of BCs : ' . $model->bc_model->name ?>
                </h2>

            </div>
            <div class="panel-container show">
                <div class="panel-content">


                    <?php
                    $form = ActiveForm::begin([
                                'enableClientValidation' => false,
                                'enableAjaxValidation' => TRUE,
                                'id' => 'scenario',
                                'options' => ['id' => 'scenario', 'enctype' => 'multipart/form-data'],
                    ]);
                    ?>

                    <?php
                    echo $form->field($model, 'scenario')->widget(Select2::classname(), [
                        'data' => $model->scenario_option,
                        'options' => ['placeholder' => 'Select Call scenario', 'style' => 'width:200px'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ])->label('Call scenario');
                    ?>   
                    <div class="form-group">
                        <div class="col-lg-offset-5 col-lg-11">
                            <?= Html::submitButton('Make a call', ['id' => 'buttonsave', 'class' => 'btn btn-info', 'value' => 'save', 'name' => 'save']) ?>

                        </div>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>        
        </div>
    </div>        
</div>
<?php
$js = <<<JS
    $(document).ready(function() {

    $('#scenario').on('beforeSubmit', function (e) {
        var form = $(this);
        var submit = form.find(':submit');
        submit.html('<span class="fa fa-spin fa-spinner"></span> Wait...');
        submit.prop('disabled', true);

    });          
JS;
$this->registerJs($js);
?>