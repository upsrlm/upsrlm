<?php

use yii\bootstrap4\Html;
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

$this->title = 'WSS बैंक विवरण';
$app = new \sakhi\components\App();
$mobile = new \sakhi\components\MobileDetect();
?>
<script type="text/javascript">
    function takePicturePassbook(outputFunction) {
        if (typeof AndroidDevice !== "undefined") {
            AndroidDevice.takePicture(outputFunction);
        }
    }

    function imageDataPassbook(data) {
        document.getElementById('passbook_photo-image').setAttribute('src', 'data:image/png;base64,' + data);
        document.getElementById('wssbankform-passbook_photo').setAttribute('value', data);
    }
</script>
<script type="text/javascript">
    jQuery(document).ready(function () {
        jQuery(".phone").keypress(function (e) {
            var length = jQuery(this).val().length;
            if (length > 9) {
                return false;
            } else if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                return false;
            } else if ((length == 0) && (e.which == 48)) {
                return false;
            }
        });
    });
</script>
<div class="subheader" style="text-align: center">
    <h3 class="subheader-title">
       <?=$this->title?>
    </h3>
</div>
<?php if ($model->wada_model->wada_bank == 3) { ?>
    <div class="card">

        <div class="col-lg-12">
            <?php
            if ($model->wada_model->wadabankrjregion) {

                echo "<div class='text-danger'> बैंक विवरण वापसी कारण <br/>" . $model->wada_model->wadabankrjregion . "</div>";
            }
            ?>
            <div class='card-body'>
                <?php $form = ActiveMobileForm::begin(['id' => 'form-bank-application_form', 'enableAjaxValidation' => true, 'enableClientValidation' => false, 'options' => ['enctype' => 'multipart/form-data']]); ?>
                <div class='card'>
                    <div class="col-lg-12">
                        <?php echo $form->field($model, "bank_account_no")->textInput(['type' => 'number']) ?>

                    </div>
                </div>
                <div class='card'>
                    <div class="col-lg-12">
                        <?php echo $form->field($model, "bank_id")->dropDownList(yii\helpers\ArrayHelper::map(cbo\models\master\CboMasterBank::find()->where(['status' => 1])->all(), 'id', 'bank_name'), ['prompt' => 'चयन कीजिए']) ?>
                    </div>
                </div>
                <div class='card'>
                    <div class="col-lg-12">
                        <?php echo $form->field($model, "branch")->textInput([]) ?>
                    </div>
                </div>
                <div class='card'>
                    <div class="col-lg-12">
                        <?php echo $form->field($model, "branch_code_or_ifsc")->textInput([]) ?>

                    </div>
                </div>
                <div class='card'>
                    <div class="col-lg-12">
                        <button type="button" class="btn btn-primary btn-sm mt-2" onClick="takePicturePassbook('imageDataPassbook')">
                            <i class="fal fa-camera"></i> पासबुक फोटो अपलोड करें
                        </button>
                        <?= $form->field($model, 'passbook_photo')->hiddenInput()->label('') ?>
                        <img id="passbook_photo-image" src="" class="img-responsive" width="200" height="300" />
                        <?php if (isset($model->wada_model->passbook_photo)) { ?>
                            <div>
                                <img id="old_passbook_photo-image" src="<?= $model->wada_model->passbook_photo_url ?>" alt="<?= '' ?>" class="img-responsive mb-2" width="100%" height="auto">
                            </div>
                        <?php } ?>

                    </div>
                </div>
            </div>

            <div class="form-group text-center">
                <?= $form->field($model, 'cbo_shg_id')->hiddenInput()->label('') ?>
                <?php if ($app->checkAccess('shg', Yii::$app->user->identity, '/shg/wss/bank', ['shgid' => $model->cbo_shg_id])) { ?>
                    <?= Html::submitButton('सेव (save)', ['class' => 'btn btn-small btn-info', 'name' => 'save_b', 'id' => 'save_b']) ?>

                <?php } ?>
            </div>
            <?php ActiveMobileForm::end(); ?>

        </div>
    </div>
<?php } else { ?>
    <?=
    $this->render('_viewbankdetail', [
        'model' => $model->wada_model,
        'form' => $model,
    ])
    ?>
<?php } ?>
<?php
$style = <<< CSS
 img[src=""] {
        display: none;
    }  
  button[file=""] {
        display: none;
    }      
CSS;
$this->registerCss($style);
?>
<?php
//$js = <<<JS
// $(function () {       
//$('.saveimage').click(function(){                
//   var url=$(this).attr('url');
//   var file_name=$(this).attr('file_name');
//   var file=$(this).attr('file');  
//   var message=$(this).attr('file_name')+'_msg';    
//   var target_id=$(this).attr('target_id');    
//                   $.ajax({
//                        url: url,
//                        type: 'post',
//                        data: {
//                                file : file,
//                                file_name : file_name,
//                        },
//                        dataType: 'json',
//                        context: this,    
//                        success: function (data) {
//                               if(data.success === true){
//                                     $('#'+target_id).val('1');
//                                     $('#'+file_name).css('display','none');
//                                     $('#'+message).text('फोटो सेव हुआ');
//                                   }
//                            },
//                            error  : function (e)
//                            {
//                                console.log(e);
//                            }
//                           });
//                     
//   });                     
// }); 
//        
//JS;
//$this->registerJs($js);
?> `
<style>
    .col-lg-12 {
        padding-right: 0.5rem;
        padding-left: 0.5rem;
    }

    .card .card-body {
        padding: 0px
    }

    .card-body .card {
        margin: 5px 0px
    }

    .card-body .card> :last-child,
    .card-group> :last-child {
        margin-bottom: 10px;
        margin-top: 5px;
    }

    .form-group:last-child,
    .form-group:only-child {
        margin-bottom: 10px;
    }
</style>