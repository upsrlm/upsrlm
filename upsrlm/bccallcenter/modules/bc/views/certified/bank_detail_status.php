<?php

use Yii;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap4\ActiveForm;
use kartik\widgets\DatePicker;
use kartik\widgets\Select2;
use kartik\grid\GridView;
use dosamigos\tinymce\TinyMce;
use app\modules\hsc\models\HscAmrutApplication;
use kartik\checkbox\CheckboxX;

$this->title = 'Verify BC/SHG Bank Account Detail Status';
$this->params['breadcrumbs'][] = $this->title;
?>
<div  class="panelss">

    <!--    <div class="panel-container show">
            <div class="panel-content">-->


    <?php
    $form = ActiveForm::begin([
//                    'enableClientValidation' => false,
//                    'enableAjaxValidation' => true,
                'options' => ['id' => 'verify-form', 'enctype' => 'multipart/form-data'],
    ]);
    ?>
    <div class="row">

        <div class="col-lg-6">    
            <?php
            $bcdup = '';
            if (in_array($model->bc_bank, [0, 1, 2, 3])) {
                if ($model->participant_model->dupacno > 1) {
                    $bcdup = '<span class="label label-danger">Duplicate</span>';
                }
                ?>
                <div class="row">

                    <div class="col-lg-12"><h4>BC Name : <?= $model->participant_model->name ?>  </h4></div>
                    <?php if (in_array($model->bc_bank, [0])) { ?>
                        <div class="col-lg-12"><h3>बीसी बैंक विवरण अपलोड नहीं किया गया</h3></div>
                    <?php } ?>
    <?php if (in_array($model->bc_bank, [1, 2, 3])) { ?>
                        <div class="col-lg-12"><h3>BC bank account verification </h3></div>
                        <div class="col-lg-12"><h4><?= $model->participant_model->bcbanks ?></h4></div>
                        <div class="col-lg-12">
                            <?= $model->participant_model->passbook_photo != null ? '<span class="profile-picture">
                                        <img style="height:300px" src="' . Yii::$app->params['app_url']['bc'] . $model->participant_model->passbook_photo_url . '" data-src="' . Yii::$app->params['app_url']['bc'] . $model->participant_model->passbook_photo_url . '"  class="img-responsive lozad" title="Passbook Photo"/>
                                        </span> ' : '-' ?>
                            <div> बैंक अकाउंट नम्बर : <?= $model->participant_model->bank_account_no_of_the_bc . ' ' . $bcdup ?></div>
                            <div> बैंक अकाउंट का IFSC कोड : <?= $model->participant_model->branch_code_or_ifsc ?></div>
                            <?php echo $form->field($model, 'verify_bc_passbook_photo')->checkbox(['value' => 1, 'disabled' => 'disabled']) ?> 
                            <?php echo $form->field($model, 'verify_bc_passbook_not')->checkbox(['value' => 1, 'disabled' => 'disabled']) ?> 
                            <?php echo $form->field($model, 'verify_bc_bank_account_no')->checkbox(['value' => 1, 'disabled' => 'disabled']) ?> 
                            <?php echo $form->field($model, 'verify_bc_branch_code_or_ifsc')->checkbox(['value' => 1, 'disabled' => 'disabled']); ?> 
                            <?php echo $form->field($model, 'verify_bc_ifsc_code_entered')->checkbox(['value' => 1, 'disabled' => 'disabled']) ?>
                            <?php echo $form->field($model, 'verify_bc_other')->checkbox(['value' => 1, 'disabled' => 'disabled']) ?> 
                            <?php
                            echo $form->field($model, 'verify_bc_other_reason', [
                                'template' => '{input}{error}',
                            ])->textInput(['disabled' => 'disabled'])->label('');
                            ?>
                        </div> 

    <?php } ?>


                </div>    
<?php } ?>
        </div>

        <div class="col-lg-6">    
            <?php
            $shgdup = '';
            if (in_array($model->shg_bank, [0, 1, 2, 3])) {
                if ($model->participant_model->dupshgacno > 1) {
                    $shgdup = ' <span class="label label-danger">Duplicate</span>';
                }
                ?>
                <div class="row">
                    <div class="col-lg-12"><h4>Name of SHG : <?= isset($model->shg_model->name_of_shg) ? $model->shg_model->name_of_shg : '' ?>  </h4></div>
                    <?php if (in_array($model->shg_bank, [0])) { ?>
                        <div class="col-lg-12"><h3>बीसी स्वयं सहायता समूह बैंक विवरण अपलोड नहीं किया गया</h3></div>
                    <?php } ?>
    <?php if (in_array($model->shg_bank, [1, 2, 3])) { ?>    
                        <div class="col-lg-12"><h3>SHG bank account verification </h3></div>
                        <div class="col-lg-12"><h4><?= $model->participant_model->shgbanks ?></h4></div>
                        <div class="col-lg-12">
                            <?= $model->participant_model->passbook_photo_shg != null ? '<span class="profile-picture">
                                        <img style="height:300px" src="' . Yii::$app->params['app_url']['bc'] . $model->participant_model->passbook_photo_shg_url . '" data-src="' . Yii::$app->params['app_url']['bc'] . $model->participant_model->passbook_photo_shg_url . '"  class="img-responsive lozad" title="Passbook Photo"/>
                                        </span> ' : '-' ?> 
                            <div> बैंक अकाउंट नम्बर : <?= $model->participant_model->bank_account_no_of_the_shg . ' ' . $shgdup ?></div>
                            <div> बैंक अकाउंट का IFSC कोड : <?= $model->participant_model->branch_code_or_ifsc_shg ?></div>
                            <?php echo $form->field($model, 'verify_bc_shg_passbook_photo')->checkbox(['value' => 1, 'disabled' => 'disabled']); ?> 
                            <?php echo $form->field($model, 'verify_bc_shg_name')->checkbox(['value' => 1, 'disabled' => 'disabled']) ?> 
                            <?php echo $form->field($model, 'verify_bc_shg_bank_account_no')->checkbox(['value' => 1, 'disabled' => 'disabled']) ?> 
                            <?php echo $form->field($model, 'verify_bc_shg_passbook_not')->checkbox(['value' => 1, 'disabled' => 'disabled']) ?> 
                            <?php echo $form->field($model, 'verify_bc_shg_branch_code_or_ifsc')->checkbox(['value' => 1, 'disabled' => 'disabled']) ?> 
                            <?php echo $form->field($model, 'verify_bc_shg_ifsc_code_entered')->checkbox(['value' => 1, 'disabled' => 'disabled']); ?>
                            <?php echo $form->field($model, 'verify_bc_shg_other')->checkbox(['value' => 1, 'disabled' => 'disabled']); ?> 
                            <?php
                            echo $form->field($model, 'verify_bc_shg_other_reason', [
                                'template' => '{input}{error}',
                            ])->textInput(['disabled' => 'disabled'])->label('');
                            ?>
                        </div>

    <?php } ?>


                </div>  
<?php } ?>
        </div>
    </div>    


<?php ActiveForm::end(); ?>
    <!--        </div>
        </div>-->
</div>

<?php
$js = <<<JS
observer = lozad('.lozad', {
load: function (el) {
el.src = el.getAttribute('data-src');
$(el).elevateZoom({
//zoomType: 'inner',
//cursor: 'crosshair'        
scrollZoom: true,
responsive: true,       
zoomWindowOffetx: -600
});
}
}); 
observer.observe();     
 $(function() {
  $("input[type=checkbox]:checked").css('background-color', 'red !important')
})       
JS;
$this->registerJs($js);
?> 

<?php
$css = <<<cs
 .custom-checkbox .custom-control-input:checked ~ .custom-control-label::before {
  border-color: #FF0000 !important;
  background-color: #FF0000 !important;
}
.custom-control-input:checked + label {
    color: #FF0000 !important;
}  
cs;
$this->registerCss($css);

