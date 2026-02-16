<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use kartik\widgets\DatePicker;
use yii\helpers\ArrayHelper;
use kartik\widgets\DepDrop;
use kartik\widgets\Select2;
use yii\widgets\DetailView;

$this->title = 'Verification Samuh Sakhi detail';
?>
<div class="row">
    <div class="col-xl-12">
        <div  class="panel">

            <div class="panel-container show">
                <div class="panel-content">
                    <div class="row">
                        <div class="col-lg-12">समूह सखी ब्यौरा</div>
                        <div class="col-lg-6">
                            <?=
                            DetailView::widget([
                                'model' => $model->vo_model,
                                'attributes' => [
                                    [
                                        'attribute' => 'samuh_sakhi_name',
                                        'format' => 'html',
                                        'value' => function ($model) {
                                            return $model->samuh_sakhi_name;
                                        }
                                    ],
                                    [
                                        'attribute' => 'samuh_sakhi_age',
                                        'format' => 'html',
                                        'value' => function ($model) {
                                            return $model->samuh_sakhi_age;
                                        }
                                    ],
                                    [
                                        'attribute' => 'samuh_sakhi_cbo_shg_id',
                                        'format' => 'html',
                                        'value' => function ($model) {
                                            return $model->samuhsakhishg != null ? $model->samuhsakhishg->name_of_shg : '';
                                        }
                                    ],
                                ],
                            ])
                            ?>
                        </div> 
                        <div class="col-lg-6">
                            <?=
                            DetailView::widget([
                                'model' => $model->vo_model,
                                'attributes' => [
                                    [
                                        'attribute' => 'samuh_sakhi_mobile_no',
                                        'format' => 'html',
                                        'value' => function ($model) {
                                            return $model->samuh_sakhi_mobile_no;
                                        }
                                    ],
                                    [
                                        'attribute' => 'samuh_sakhi_mobile_type',
                                        'format' => 'html',
                                        'value' => function ($model) {
                                            return $model->mobiletype != null ? $model->mobiletype->name_hi : '';
                                        }
                                    ],
                                    [
                                        'attribute' => 'samuh_sakhi_social_category',
                                        'format' => 'html',
                                        'value' => function ($model) {
                                            return $model->socialcategory != null ? $model->socialcategory->name_hi : '';
                                        }
                                    ],
                                ],
                            ])
                            ?>
                        </div> 
                    </div>
                    <?php
                    $form = ActiveForm::begin([
                                'enableClientValidation' => FALSE,
                                'enableAjaxValidation' => TRUE,
                                'options' => ['id' => 'add-score-form', 'enctype' => 'multipart/form-data'],
                    ]);
                    ?>
                    <div class="col-xl-12">

                        <?=
                        $form->field($model, 'verification_status_samuh_sakhi', [
                            'template' => "<div class=\"col-lg-12\">{input}</div>\n<div class=\"col-lg-12\">{error}</div>",
                        ])->checkbox([
//                'checked' => false, 'required' => true,
                            'label' => "I've checked and Confirm Samuh Sakhi के नाम व फ़ोन नम्बर सत्यापित "
                        ])->label();
                        ?>

                    </div>
                    <div class="col-md-12">
                        <div class="text-center">
                            <?= Html::submitButton('<i class="fal fa-save"></i> Save', ['class' => 'btn btn-success']) ?>
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
    
$('#add-score-form').on('beforeSubmit', function (e) {
    var form = $(this);
    var submit = form.find(':submit');
    submit.html('<span class="fa fa-spin fa-spinner"></span> Wait...');
    submit.prop('disabled', true);

});       
JS;
$this->registerJs($js);
?>
<?php
$css = <<<css
   div.required label.control-label:after {
    content: " *";
    color: red;
}
css;
$this->registerCss($css);
?>











