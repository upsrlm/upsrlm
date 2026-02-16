<?php

use yii\helpers\Html;
use sakhi\widgets\ActiveMobileForm;
use kartik\date\DatePicker;

$namopt = ['maxlength' => true];
$mobileopt = ['type' => 'number'];
if (isset($model->user_id)) {
    $namopt = ['maxlength' => true, 'readonly' => 'readonly'];
    $mobileopt = ['type' => 'number', 'readonly' => 'readonly'];
}
// echo date('Y-m-d', strtotime('18 years ago'));
?>
<script type="text/javascript">
    var date = <?= isset($model->dob) ? strtotime($model->dob) . '000' : 0 ?>;
    var mindate = <?= date('Y-m-d', strtotime('18 years ago')) . '000' ?>;
    var maxdate = <?= time() . '000' ?>;
</script>

<script>
    function takePicturePassbook(outputFunction) {
        if (typeof AndroidDevice !== "undefined") {
            AndroidDevice.takePicture(outputFunction);
        }
    }

    function imageDataPassbook(data) {
        document.getElementById('passbook_photo-image').setAttribute('src', 'data:image/png;base64,' + data);
        document.getElementById('dbtbeneficiarymemberform-passbook_photo').setAttribute('value', data);
    }

    function takePictureMemberPhoto(outputFunction) {
        if (typeof AndroidDevice !== "undefined") {
            AndroidDevice.takePicture(outputFunction);
        }
    }

    function imageDataMemberPhoto(data) {
        document.getElementById('member_photo-image').setAttribute('src', 'data:image/png;base64,' + data);
        document.getElementById('dbtbeneficiarymemberform-member_photo').setAttribute('value', data);
    }

    function takePictureAadharFront(outputFunction) {
        if (typeof AndroidDevice !== "undefined") {
            AndroidDevice.takePicture(outputFunction);
        }
    }

    function imageDataAadharFront(data) {
        document.getElementById('aadhar_front_photo-image').setAttribute('src', 'data:image/png;base64,' + data);
        document.getElementById('dbtbeneficiarymemberform-aadhar_front_photo').setAttribute('value', data);
    }

    function takePictureAadharBack(outputFunction) {
        if (typeof AndroidDevice !== "undefined") {
            AndroidDevice.takePicture(outputFunction);
        }
    }

    function imageDataAadharBack(data) {
        document.getElementById('aadhar_back_photo-image').setAttribute('src', 'data:image/png;base64,' + data);
        document.getElementById('dbtbeneficiarymemberform-aadhar_back_photo').setAttribute('value', data);
    }

    function takePictureVoterid(outputFunction) {
        if (typeof AndroidDevice !== "undefined") {
            AndroidDevice.takePicture(outputFunction);
        }
    }

    function imageDataVoterid(data) {
        document.getElementById('voter_id_photo-image').setAttribute('src', 'data:image/png;base64,' + data);
        document.getElementById('dbtbeneficiarymemberform-voter_id_photo').setAttribute('value', data);
    }
    var date = <?= isset($model->date_of_opening_the_bank_account) ? strtotime($model->date_of_opening_the_bank_account) . '000' : 0 ?>;
    var mindate = <?= strtotime('2000-01-01') . '000' ?>;
    var maxdate = <?= time() . '000' ?>;
</script>
<?php $form = ActiveMobileForm::begin([
    'id' => 'form-shgmember', 'enableAjaxValidation' => true, 'enableClientValidation' => false,
    'action' => $action_url,

    'options' => ['enctype' => 'multipart/form-data']
]); ?>
<div class="row">
    <div class="col-lg-6 mb-2">
        <?php echo $form->field($model, "aadhaar_number")->textInput() ?>
    </div>

</div>

<div class='card'>
    <div class="col-lg-12">

        <button type="button" class="btn btn-primary btn-sm mt-2" onClick="takePictureAadharFront('imageDataAadharFront')">
            <i class="fal fa-camera"></i> आधार फ्रंट फोटो अपलोड करें
        </button>
        <?= $form->field($model, 'aadhar_front_photo')->hiddenInput()->label('') ?>
        <img id="aadhar_front_photo-image" src="" class="img-responsive" width="200" height="300" />
        <?php if (isset($model->dbt_member_model->aadhar_front_photo)) { ?>
            <div class="col-lg-6">
                <img src="<?= $model->dbt_member_model->aadharfront_photo_url ?>" alt="<?= $model->dbt_member_model->aadhar_front_photo ?>" class="img-responsive mb-2" width="100%" height="auto">
            </div>
        <?php } ?>

    </div>
</div>
<div class='card'>
    <div class="col-lg-12">

        <button type="button" class="btn btn-primary btn-sm mt-2" onClick="takePictureAadharBack('imageDataAadharBack')">
            <i class="fal fa-camera"></i> आधार पीछे फोटो अपलोड करें
        </button>
        <?= $form->field($model, 'aadhar_back_photo')->hiddenInput()->label('') ?>
        <img id="aadhar_back_photo-image" src="" class="img-responsive" width="200" height="300" />
        <?php if (isset($model->dbt_member_model->aadhar_back_photo)) { ?>
            <div class="col-lg-6">
                <img src="<?= $model->dbt_member_model->aadharback_photo_url ?>" alt="<?= $model->dbt_member_model->aadhar_back_photo ?>" class="img-responsive mb-2" width="100%" height="auto">
            </div>
        <?php } ?>

    </div>
</div>
<div class="form-group text-center">

    <?= $form->field($model, 'dbt_beneficiary_household_id')->hiddenInput()->label(false); ?>
    <?= $form->field($model, 'rishta_shg_member_id')->hiddenInput()->label(false); ?>
    <?= $form->field($model, 'dbt_beneficiary_member_id')->hiddenInput()->label(false); ?>
    <?= $form->field($model, 'cbo_shg_id')->hiddenInput()->label(false); ?>
    <?= $form->field($model, 'scenario')->hiddenInput()->label(false); ?>

    <?= Html::submitButton('सेव', ['class' => 'btn btn-sm btn-info form-control mt-2', 'name' => 'save_b', 'id' => 'save_b']) ?>
</div>
<?php ActiveMobileForm::end(); ?>

<?php
$style = <<< CSS
 img[src=""] {
        display: none;
    }  

CSS;
$this->registerCss($style);
?>