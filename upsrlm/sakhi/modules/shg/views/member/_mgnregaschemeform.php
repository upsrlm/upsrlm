<?php

use yii\helpers\Html;
use sakhi\widgets\ActiveMobileForm;
use kartik\date\DatePicker;

$namopt = ['maxlength' => true];
$mobileopt = ['type' => 'number'];
$labelopt = ['class' => 'formlabel'];
// if (isset($model->dbt_member_model->id)) {
//     $namopt = ['maxlength' => true, 'readonly' => 'readonly'];
//     $mobileopt = ['readonly' => 'readonly'];
// }
?>

<div class="row">
    <div class="col-md-12">
        <p><span class="formlabel">1). क्या आप मनरेगा योजना का लाभ प्राप्त कर रहे हैं?: </span><?= $model->scheme_model->yesnooption('current_mgnrega_beneficiary') ?></p>
        <p><span class="formlabel">2). क्या आप MGNREGA में काम करने को इच्छुक है?: </span><?= $model->scheme_model->yesnooption('current_mgnrega_beneficiary_interested_work') ?></p>
        <p><span class="formlabel">3). अगर इच्छुक हैं तो कितने दिन के लिए काम चाहिए?: </span><?= $model->scheme_model->workdaylabel ?></p>
    </div>
</div>

<?php $form = ActiveMobileForm::begin(['id' => 'form-shgmember', 'enableAjaxValidation' => true, 'enableClientValidation' => false, 'options' => ['enctype' => 'multipart/form-data']]); ?>
<div class="row">

    <div class="col-lg-12">
        <p class="formlabel">1). आवेदकों का ब्योरा </p>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>क्र. सं.</th>
                        <th>नाम</th>
                        <th>आयु</th>
                        <th>लिंग</th>
                        <th>काम करने के इच्छुक</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($model->applicants_list) {
                        $srn = 1;
                        foreach ($model->applicants_list as $applicant) {
                    ?>
                            <tr>
                                <td><?= $srn ?></td>
                                <td><?= $applicant->name ?></td>
                                <td><?= $applicant->age ?></td>
                                <td><?= $applicant->genderlabel ? $applicant->genderlabel->name_hi : '' ?></td>
                                <td><?php echo $form->field($model, "applicants_ids[$applicant->id]")->checkbox(['value' => $applicant->id, 'checked' => in_array($applicant->id, $model->applicants_ids)])->label('') ?></td>
                            </tr>
                    <?php $srn++;
                        }
                    } ?>

                </tbody>
            </table>
        </div>
        <hr>
    </div>
    <div class="col-lg-12 mb-2">
        <?php echo $form->field($model, "house_no")->textInput($namopt)->label($model->getAttributeLabel('house_no'), $labelopt) ?>
    </div>

    <div class="col-lg-12 mb-3">
        <p><span class="formlabel">3). ग्राम का नाम : </span><?= $model->scheme_model->village_name ?></p>
        <p><span class="formlabel">4). ग्राम पंचायत का नाम : </span><?= $model->scheme_model->gram_panchayat_name ?></p>
        <p><span class="formlabel">5). ब्लॉक का नाम : </span><?= $model->scheme_model->block_name ?></p>
        <?php echo $form->field($model, "family_head_member_id")->radioList($model->applicants_list_head, ['prompt' => 'चयन कीजिए'])->label($model->getAttributeLabel('family_head_member_id'), $labelopt) ?>
    </div>


    <div class="col-lg-12 mb-3">
        <?php echo $form->field($model, "caste_category")->radioList($model->casteoption)->label($model->getAttributeLabel('caste_category'), $labelopt) ?>
    </div>

    <div class="col-lg-12 mb-3">
        <?php echo $form->field($model, "minority_family")->radioList($model->yesnooption)->label($model->getAttributeLabel('minority_family'), $labelopt) ?>
    </div>

    <div class="col-lg-12 mb-3">
        <?php echo $form->field($model, "iay_beneficiary")->radioList($model->yesnooption)->label($model->getAttributeLabel('iay_beneficiary'), $labelopt) ?>
    </div>

    <div class="col-lg-12 mb-3">
        <?php echo $form->field($model, "land_reforms")->radioList($model->yesnooption)->label($model->getAttributeLabel('land_reforms'), $labelopt) ?>
    </div>
    <div class="col-lg-12 mb-3">
        <?php echo $form->field($model, "small_marginal_farmers")->radioList($model->yesnooption)->label($model->getAttributeLabel('small_marginal_farmers'), $labelopt) ?>
    </div>
    <div class="col-lg-12 mb-3">
        <?php echo $form->field($model, "st_or_tribal")->radioList($model->yesnooption)->label($model->getAttributeLabel('st_or_tribal'), $labelopt) ?>
    </div>

    <div class="col-lg-12 mb-3">
        <?php echo $form->field($model, "bpl_family")->radioList($model->yesnooption)->label($model->getAttributeLabel('bpl_family'), $labelopt) ?>
    </div>

    <div class="col-lg-12 mb-3">
        <?php echo $form->field($model, "rsbyi_beneficiary")->radioList($model->yesnooption)->label($model->getAttributeLabel('rsbyi_beneficiary'), $labelopt) ?>
    </div>

    <div class="col-lg-12 mb-3">
        <?php echo $form->field($model, "aaby_beneficiary")->radioList($model->yesnooption)->label($model->getAttributeLabel('aaby_beneficiary'), $labelopt) ?>
    </div>

    <div class="col-lg-12 mb-3">
        <?php echo $form->field($model, "bpl_secc_id")->textInput($namopt)->label($model->getAttributeLabel('bpl_secc_id'), $labelopt) ?>
    </div>

    <div class="col-lg-12 mb-3">
        <?php echo $form->field($model, "mobile_number")->textInput($mobileopt)->label('17). मोबाइल नम्बर जिस पर परिवार को एस एम एस (SMS) के माध्यम से जानकारी दी जा सके', $labelopt) ?>
    </div>
</div>


<div class="form-group text-center">
    <?= Html::submitButton('सेव', ['class' => 'btn btn-sm btn-info form-control mt-2', 'name' => 'save_b', 'id' => 'save_b']) ?>
    <?= $form->field($model, 'dbt_beneficiary_household_id')->hiddenInput()->label(false); ?>
    <?= $form->field($model, 'rishta_shg_member_id')->hiddenInput()->label(false); ?>
    <?= $form->field($model, 'dbt_beneficiary_scheme_mgnrega_id')->hiddenInput()->label(false); ?>
    <?= $form->field($model, 'cbo_shg_id')->hiddenInput()->label(false); ?>
    <?= $form->field($model, 'scenario')->hiddenInput()->label(false); ?>
    <?php if ($model->scheme_model->status == 1) : ?>
        <a href="/shg/member/mgnregascheme?shgid=<?= $model->cbo_shg_id ?>&dbt_household_id=<?= $model->dbt_beneficiary_household_id ?>&final_step=1" class="btn btn-success form-control"><i class="fal fa-eye"> आवेदन पत्र पूर्वावलोकन और सबमिट करें</i></a>
    <?php endif; ?>
</div>
<?php ActiveMobileForm::end(); ?>

<?php
$style = <<< CSS
 img[src=""] {
        display: none;
    }  
    .formlabel {
        font-weight:bold;
    }

CSS;
$this->registerCss($style);
?>