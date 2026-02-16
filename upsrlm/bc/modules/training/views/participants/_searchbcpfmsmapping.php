<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Url;
use yii\widgets\Pjax;
use kartik\widgets\DepDrop;
use kartik\widgets\Select2;
use common\models\master\MasterRole;
use yii\bootstrap4\ButtonDropdown;
$request = explode('?', Yii::$app->request->url);
$request_url = rtrim($request[0], '/');
?>
<div class="srlm-search">
    <?php
    $form = ActiveForm::begin([
                'layout' => 'inline',
                'options' => [
                    'class' => 'form-inline',
                    'data-pjax' => true,
                    'id' => 'Searchform'
                ],
                'method' => 'POST',
    ]);
    ?>
    <div class="row">
        <div class="col-xl-2 col-md-4 mb-2">
            <?php
            echo $form->field($model, 'aspirational')->widget(Select2::classname(), [
                'data' => ['1' => 'Yes', '0' => 'No'],
                'options' => ['placeholder' => 'Aspirational Block', 'style' => 'width:250px'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?>
        </div>
        <div class="col-xl-2 col-md-4 mb-2">
            <?php
            echo $form->field($model, 'district_code')->widget(Select2::classname(), [
                'bsVersion' => '4.x',
                'data' => $model->district_option,
                'options' => ['placeholder' => 'District', 'style' => 'width:200px'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label('District');
            ?>
        </div>
        <div class="col-xl-2 col-md-4 mb-2">
            <?php
            echo $form->field($model, 'block_code')->widget(Select2::classname(), [
                'bsVersion' => '4.x',
                'data' => $model->block_option,
                'options' => ['placeholder' => 'Block', 'style' => 'width:200px'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label('Block');
            ?>
        </div>
        <!-- <div class="col-xl-2 col-md-4 mb-2">
        <?php
        $form->field($model, 'gram_panchayat_code')->widget(Select2::classname(), [
            'bsVersion' => '4.x',
            'data' => $model->gp_option,
            'options' => ['placeholder' => 'GP', 'style' => 'width:200px'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ])->label('GP');
        ?>
        </div> -->
        <div class="col-xl-2 col-md-4 mb-2">
            <?php
            echo $form->field($model, 'bc_shg_map')->widget(Select2::classname(), [
                'bsVersion' => '4.x',
                'data' => [1 => 'Assigned', 3 => 'Not Assigned'],
                'options' => ['placeholder' => 'BC-SHG Mapped Status', 'style' => 'width:250px'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label('BC-SHG Mapped');
            ?>
        </div>
        <div class="col-xl-2 col-md-4 mb-2">
            <?php
            echo $form->field($model, 'bc_shg_bank')->widget(Select2::classname(), [
                'bsVersion' => '4.x',
                'data' => [1 => 'Not Verified', 2 => 'Not Filled', 3 => 'Verified', 4 => 'Return'],
                'options' => ['placeholder' => 'Bank Detail status', 'style' => 'width:200px'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label('Bank Detail');
            ?>
        </div>
        <div class="col-xl-2 col-md-4 mb-2">
            <?php
            echo $form->field($model, 'pfms_maped_status')->widget(Select2::classname(), [
                'bsVersion' => '4.x',
                'data' => [0 => 'No', 1 => 'Yes'],
                'options' => ['placeholder' => 'SHG PFMS Maped', 'style' => 'width:200px'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label('SHG PFMS Mapped');
            ?>
        </div>
        <div class="col-xl-2 col-md-4 mb-2">
            <?php
            echo $form->field($model, 'bc_beneficiaries_map')->widget(Select2::classname(), [
                'bsVersion' => '4.x',
                'data' => [0 => 'No', 1 => 'Yes'],
                'options' => ['placeholder' => 'BC PFMS Maped', 'style' => 'width:200px'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label('BC PFMS Maped');
            ?>
        </div>
        <div class="col-xl-2 col-md-4 mb-2">
            <?php
            echo $form->field($model, 'blocked_bc')->widget(Select2::classname(), [
                'data' => [0 => 'No', 1 => 'Yes'],
                'options' => ['placeholder' => 'Blocked', 'style' => 'width:250px'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label('Blocked');
            ?>
        </div>
        <div class="col-xl-2 col-md-4 mb-2">
            <?= Html::submitButton('Search', ['class' => 'btn  btn-primary', 'id' => 'searchbtn', 'name' => 'search', 'value' => 'search', 'style' => 'padding:7px 20px;']) ?>
            <?php
            if (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN,MasterRole::ROLE_DC_NRLM])) {
                echo ButtonDropdown::widget([
                    'label' => 'Action',
                    'class' => 'btn btn-info',
                    'dropdown' => [
                        'items' => [
                            ['label' => 'Upload CSV for replace BC Beneficiaries code (Vender Code)', 'url' => '/training/participants/importbcpfms', 'data-pjax' => "0",],
                           
                        ],
                    ],
                ]);
            }
            ?>

            <?php Html::button('<i class="glyphicon glyphicon-download-alt"></i> Download CSV', ['class' => 'btn btn-primary ', 'style' => 'padding:7px 20px;margin-top:10px;', 'id' => 'download', 'name' => 'download', 'value' => 'download']) ?>
        </div>
    </div>















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
    width: 200px !important;
}
cs;
$this->registerCss($css);
?>