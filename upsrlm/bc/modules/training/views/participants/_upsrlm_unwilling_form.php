<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap4\ActiveForm;
use kartik\widgets\DatePicker;

$this->title = 'अनिच्छा प्रकट करने के कारण';
$mobileopt = ['type' => 'number'];
?>
<?php echo $this->render('bc_view_unwilling', ['model' => $model]); ?>
<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">
            <!--            <div class="panel-hdr">
                            <h2>
            <?= 'अनिच्छा प्रकट करने के कारण' ?>
                            </h2>
            
                        </div>-->
            <div class="panel-container show">
                <div class="panel-content h3 font-weight-bold">


                    <?php
                    $form = ActiveForm::begin([
                                'enableClientValidation' => false,
                                'enableAjaxValidation' => TRUE,
                                'options' => ['id' => 'unwilling', 'enctype' => 'multipart/form-data'],
                    ]);
                    ?>

                    <?=
                    $form->field($model, 'unwilling_reason', [
                        'labelOptions' => []
                    ])->checkboxList($model->unwilling_reason_option)
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


<?php
$js = <<<JS
 $(function() {    
$('#unwilling').on('beforeSubmit', function (e) {
    var form = $(this);
    var submit = form.find(':submit');
    submit.html('<span class="fa fa-spin fa-spinner"></span> Wait...');
    submit.prop('disabled', true);

}); 
});    
JS;
$this->registerJs($js);
?>












