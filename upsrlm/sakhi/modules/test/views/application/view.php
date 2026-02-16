<?php

use yii\helpers\Html;
use yii\helpers\Url;
use sakhi\widgets\ActiveMobileForm;
use kartik\select2\Select2;
use kartik\widgets\DepDrop;
use kartik\date\DatePicker;
use kartik\widgets\FileInput;
use common\models\wada\master\WadaApplicationMasterCast;
use common\models\wada\master\WadaApplicationMasterEducationalLevel;
use common\models\wada\master\WadaApplicationMasterMarriageStatus;
use common\models\wada\master\WadaApplicationMasterVocationalTraining;

$this->title = 'आवेदन पत्र';
$app = new \sakhi\components\App();
?>
<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">

            <div class="panel-container show">
                <div class="panel-content">

                    <?php if (isset($model->application_model->form_number) and $model->application_model->form_number >= 1) { ?>
                        <?=
                        $this->render('section_1_view', [
                            'model' => $model->application_model,
                            'form' => $model,
                        ])
                        ?>
                    <?php } ?>
                    <?php if (isset($model->application_model->form_number) and $model->application_model->form_number >= 2) { ?>
                        <?=
                        $this->render('section_2_view', [
                            'model' => $model->application_model,
                            'form' => $model,
                        ])
                        ?>
                    <?php } ?>
                    <?php if (isset($model->application_model->form_number) and $model->application_model->form_number >= 3) { ?>
                        <?=
                        $this->render('section_3_view', [
                            'model' => $model->application_model,
                            'form' => $model,
                        ])
                        ?>
                    <?php } ?>
                    <?php if (isset($model->application_model->form_number) and $model->application_model->form_number >= 4) { ?>
                        <?=
                        $this->render('section_4_view', [
                            'model' => $model->application_model,
                            'form' => $model,
                        ])
                        ?>
                    <?php } ?>
                    <?php if (isset($model->application_model->form_number) and $model->application_model->form_number >= 5) { ?>
                        <?=
                        $this->render('section_5_view', [
                            'model' => $model->application_model,
                            'form' => $model,
                        ])
                        ?>
                    <?php } ?>
                    <?php if (isset($model->application_model->form_number) and $model->application_model->form_number >= 6) { ?>
                        <?=
                        $this->render('section_6_view', [
                            'model' => $model->application_model,
                            'form' => $model,
                        ])
                        ?>
                    <?php } ?>
                    <?php if (isset($model->application_model->form_number) and $model->application_model->form_number >= 6 and $model->application_model->status == 1) { ?>
                        <?php $form = ActiveMobileForm::begin(['id' => 'form-shg-application_form', 'enableAjaxValidation' => true, 'enableClientValidation' => false, 'options' => ['enctype' => 'multipart/form-data']]); ?>
                        <div class="form-group text-center">
                            <?= $form->field($model, 'status')->hiddenInput(['value' => 2])->label('') ?>
                            <?= $form->field($model, 'cbo_shg_id')->hiddenInput()->label('') ?>
                            <?php
                            if ($app->checkAccess('shg', Yii::$app->user->identity, '/shg/application/form', ['shgid' => $model->cbo_shg_id])) {
//                                if ($model->application_model->pay == 1) :
//                                    if ($model->application_model->is_amount_pay != 1) : 
                                ?>
<!--                                <a href="/shg/application/makepayment?shgid=<?= $model->cbo_shg_id ?>" class="btn btn-info" data-method="post">भुगतान शुल्क और सबमिट करें</a>-->
                                <?php
                                //endif;
//                                else :
//                                    echo Html::submitButton('पुष्टि और सबमिट करें', ['class' => 'btn btn-small btn-info', 'name' => 'save_b', 'id' => 'save_b']);
//                                endif;
                                ?>
                                <?php echo Html::submitButton('पुष्टि और सबमिट करें', ['class' => 'btn btn-small btn-info', 'name' => 'save_b', 'id' => 'save_b'])
                                ?>

                            <?php } ?>
                        </div>
                        <?php ActiveMobileForm::end(); ?>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>