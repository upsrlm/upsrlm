<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Url;
use yii\widgets\Pjax;
use kartik\widgets\DepDrop;
use kartik\widgets\Select2;
use common\models\base\GenralModel;
use common\models\User;
use common\models\master\MasterArea;
?>
<div class="col-xl-12">
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

    <?php
    echo $form->field($model, 'district_code')->widget(Select2::classname(), [
        'data' => $model->district_option,
        'options' => ['placeholder' => 'District', 'style' => 'width:250px'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);
    ?>
    <?php
    echo $form->field($model, 'block_code')->label('Block')->widget(Select2::classname(), [
        'data' => $model->block_option,
        'options' => ['placeholder' => 'Block', 'style' => 'width:250px'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);
    ?>
    <?php
    echo $form->field($model, 'gram_panchayat_code')->label('Gram Panchayat')->widget(Select2::classname(), [
        'data' => $model->gp_option,
        'options' => ['placeholder' => 'Gram Panchayat', 'style' => 'width:250px'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);
    ?>
    <?php
    echo $form->field($model, 'wada')->label('WADA SHG')->widget(Select2::classname(), [
        'data' => [1 => 'Yes', 0 => 'No'],
        'options' => ['placeholder' => 'WADA SHG', 'style' => 'width:250px'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);
    ?>
    <?php
    echo $form->field($model, 'is_bc')->label('BC Sakhi')->widget(Select2::classname(), [
        'data' => [1 => 'Yes', 0 => 'No'],
        'options' => ['placeholder' => 'BC Sakhi', 'style' => 'width:250px'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);
    ?>
    <?php
    echo $form->field($model, 'no_of_cst_user')->label('Chairperson/Secretary/Treasurer user')->widget(Select2::classname(), [
        'data' => [1 => 'Yes', 0 => 'No'],
        'options' => ['placeholder' => 'Chairperson/Secretary/Treasurer user', 'style' => 'width:250px'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);
    ?>
    <?php
    echo $form->field($model, 'suggest_samuh_sakhi')->label('suggest samuh sakhi')->widget(Select2::classname(), [
        'data' => [1 => 'Yes', 0 => 'No'],
        'options' => ['placeholder' => 'Nominated samuh sakhi', 'style' => 'width:250px'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);
    ?>
    <?php
    echo $form->field($model, 'suggest_samuh_sakhi_completed_application')->label('samuh sakhi form complete')->widget(Select2::classname(), [
        'data' => [1 => 'Yes', 0 => 'No'],
        'options' => ['placeholder' => 'Nominated samuh sakhi form complete', 'style' => 'width:250px'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);
    ?>
    <?php
//    echo $form->field($model, 'shg_profile_updated')->label('SHG Profile updated')->widget(Select2::classname(), [
//        'data' => [1 => 'Yes', 0 => 'No'],
//        'options' => ['placeholder' => 'SHG Profile updated', 'style' => 'width:250px'],
//        'pluginOptions' => [
//            'allowClear' => true
//        ],
//    ]);
    ?>
    <?= Html::submitButton('Search', ['class' => 'btn btn-sm btn-primary', 'id' => 'searchbtn', 'name' => 'search', 'value' => 'search', 'style' => 'margin-top:10px;width:75px;margin-left:10px']) ?>
    <?= Html::button('Reset', ['class' => 'btn btn-sm btn-primary reset', 'style' => 'margin-top:10px;width:75px;margin-left:10px', 'id' => 'reloads']) ?>

    <?php ActiveForm::end(); ?>
</div>
<?php
$js = <<<JS
$('#reloads').click(function() {
    location.reload();
});        
JS;
$this->registerJs($js);
$css = <<<cs
 .select2-selection__rendered {
    width: 180px !important;
}
cs;
$this->registerCss($css);
?>


