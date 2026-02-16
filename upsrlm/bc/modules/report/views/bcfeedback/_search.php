<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Url;
use yii\widgets\Pjax;
use kartik\widgets\DepDrop;
use kartik\widgets\Select2;
use kartik\widgets\DateTimePicker;
//use kartik\date\DatePicker;
use kartik\widgets\DatePicker;
use common\models\base\GenralModel;
use common\models\User;
use common\models\master\MasterRole;
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
    echo $form->field($model, 'district_code')->widget(Select2::classname(), [
        'data' => $model->district_option,
        'options' => ['placeholder' => 'Select District', 'style' => 'width:200px'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ])->label('District');
    ?>
        </div>
        <div class="col-xl-2 col-md-4 mb-2">
            <?php
    echo $form->field($model, 'block_code')->widget(Select2::classname(), [
        'data' => $model->block_option,
        'options' => ['placeholder' => 'Select Block', 'style' => 'width:200px'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ])->label('Block');
    ?>
        </div>
        <div class="col-xl-2 col-md-4 mb-2">
            <?php
    echo $form->field($model, 'gram_panchayat_code')->widget(Select2::classname(), [
        'data' => $model->gp_option,
        'options' => ['placeholder' => 'Select Gram Panchayat', 'style' => 'width:250px'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ])->label('GP');
    ?>
        </div>
        <div class="col-xl-2 col-md-4 mb-2">
            <?php
    if (isset(Yii::$app->user->identity) and!in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_BANK_DISTRICT_UNIT, MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL,MasterRole::ROLE_CORPORATE_BCS])) {
        echo $form->field($model, 'master_partner_bank_id')->widget(Select2::classname(), [
            'data' => $model->bank_option,
            'options' => ['placeholder' => 'Select Partner agencies', 'style' => 'width:200px'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ])->label('Partner agencies');
    }
    ?>
        </div>
        <div class="col-xl-2 col-md-4 mb-2">
            <?php
    echo $form->field($model, 'ques_1')->widget(Select2::classname(), [
        'data' => $model->q1_option,
        'options' => ['placeholder' => 'फ़्रॉड कॉल के माध्यम से ऑनलाइन आपके बैंक खाते से पैसे निकाल लेने के ख़तरे', 'style' => 'width:200px'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);
    ?>
        </div>
        <div class="col-xl-2 col-md-4 mb-2">

            <?php
    echo $form->field($model, 'ques_2')->widget(Select2::classname(), [
        'data' => $model->q2_option,
        'options' => ['placeholder' => 'ऐंटी मनी लॉंडरिंग (AML)/ ग़लत तरीक़े से ऑनलाइन पैसे के लेनदेन से जुड़े विषय', 'style' => 'width:200px'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);
    ?>
        </div>
        <div class="col-xl-2 col-md-4 mb-2">
            <?php
    echo $form->field($model, 'ques_3')->widget(Select2::classname(), [
        'data' => $model->q3_option,
        'options' => ['placeholder' => 'नक़ली मुद्रा/ नोट के ख़तरे - उनके व्यवहार एवं पहचान करने के तरीक़े ताकि उनसे बचा जा सके ।', 'style' => 'width:200px'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);
    ?>
        </div>
        <div class="col-xl-2 col-md-4 mb-2">
            <?php
    echo $form->field($model, 'ques_4')->widget(Select2::classname(), [
        'data' => $model->q4_option,
        'options' => ['placeholder' => 'क्या आपको सभी विषय एवं उनसे सम्बंधित सावधानियों के बारे समझ मिली?', 'style' => 'width:200px'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);
    ?>
        </div>
        <div class="col-xl-2 col-md-4 mb-2">
            <?= Html::submitButton('Search', ['class' => 'btn  btn-primary', 'id' => 'searchbtn', 'name' => 'search', 'value' => 'search', 'style' => 'padding:7px 20px;margin-left:10px']) ?>
        </div>
    </div>












    <?php ActiveForm::end(); ?>
</div>
<?php
$css = <<<cs
 .select2-selection__rendered {
    width: 200px !important;
}
cs;
$this->registerCss($css);
?>