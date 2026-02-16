<?php

use yii\helpers\Html;
use yii\helpers\Url;
use sakhi\widgets\ActiveMobileForm;
use kartik\select2\Select2;
use kartik\widgets\DepDrop;
use kartik\date\DatePicker;
use kartik\widgets\FileInput;

$this->title = $name;
$app = new \sakhi\components\App();
$option = [];
?>
<script>

    function takePictureAadharFront(outputFunction) {
        if (typeof AndroidDevice !== "undefined") {
            AndroidDevice.takePicture(outputFunction);
        }
    }

    function imageDataAadharFront(data) {
        document.getElementById('aadhar_front_photo-image').setAttribute('src', 'data:image/png;base64,' + data);
        document.getElementById('fbdemandsideform-aadhar_front_photo').setAttribute('value', data);
    }

    function takePictureAadharBack(outputFunction) {
        if (typeof AndroidDevice !== "undefined") {
            AndroidDevice.takePicture(outputFunction);
        }
    }

    function imageDataAadharBack(data) {
        document.getElementById('aadhar_back_photo-image').setAttribute('src', 'data:image/png;base64,' + data);
        document.getElementById('fbdemandsideform-aadhar_back_photo').setAttribute('value', data);
    }

</script>
<?php
$gp_option = ['placeholder' => 'ग्राम पंचायत', 'multiple' => FALSE];
if ($model->gram_panchayat_code) {

    $gp_option = ['placeholder' => 'ग्राम पंचायत', 'multiple' => FALSE, 'disabled' => 'disabled'];
}
$form = ActiveMobileForm::begin([
            'id' => 'fd-section',
            'options' => ['class' => 'form-horizontal', 'enctype' => 'multipart/form-data'],
            'enableAjaxValidation' => true,
            'enableClientValidation' => false,
        ]);
?>

<div class='card'>
    <div class="col-lg-12">
        <div class="text-center"> 
            <h3>
                <?= $this->title ?>
            </h3>
        </div>
    </div>
    <div class="col-lg-12">

        <div class='card-body'>
            <?php if (in_array($model->fd_section_qno, ['10a1', '10a2', '10a3', '10a4', '10a5', '10a6', '10a7', '10a8'])) { ?> 
                <h4>
                    A. यूजर का व्यक्तिगत परिचय
                </h4>
            <?php } ?>
            <?php if ($model->fd_section_qno == '10a1') { ?> 
                <div class='card'>
                    <div class="col-lg-12">    
                        <?=
                        $form->field($model, 'name', [
                            'labelOptions' => ['class' => 'bold_lable']
                        ])->textInput(['readonly' => false])->label('A1. नाम');
                        ?> 
                    </div>
                </div>
                <div class='card'>
                    <div class="col-lg-12">    
                        <?=
                        $form->field($model, 'mobile_no', [
                            'labelOptions' => ['class' => 'bold_lable']
                        ])->textInput(['readonly' => true, 'type' => 'number', 'pattern' => "[1-9]{1}[0-9]{9}"])->label('A2. मोबाइल नंबर');
                        ?>
                        <?=
                        $form->field($model, 'phone_type', [
                            'labelOptions' => ['class' => 'bold_lable']
                        ])->radioList($model->phone_type_option, $option);
                        ?> 
                    </div>
                </div>
            <?php } ?>
            <?php if ($model->fd_section_qno == '10a2') { ?> 
                <div class='card'>
                    <div class="col-lg-12">
                        <label class="bold_lable">A3. आधार कार्ड:</label>
                        <button type="button" class="btn btn-primary btn-sm mt-2" onClick="takePictureAadharFront('imageDataAadharFront')">
                            <i class="fal fa-camera"></i> आधार फ्रंट फोटो अपलोड करें
                        </button>

                        <?= $form->field($model, 'aadhar_front_photo')->hiddenInput()->label('') ?>
                        <img id="aadhar_front_photo-image" src="" class="img-responsive" width="200" height="300" />
                    </div>
                    <div class="col-lg-12">    
                        <?=
                        $form->field($model, 'aadhar_number', [
                            'labelOptions' => ['class' => 'bold_lable']
                        ])->textInput()->label('आधार नंबर');
                        ?>
                        <?= $form->field($model, 'aadhar_agree')->checkbox(['tabindex' => '4']) ?>
                    </div>


                </div>
            <?php } ?>

            <?php if ($model->fd_section_qno == '10a2a') { ?> 
                <div class='card'>
                    <div class="col-lg-12">    
                        <label class="bold_lable">A3 .आधार कार्ड:</label>
                        <div class="col-lg-12">
                            <button type="button" class="btn btn-primary btn-sm mt-2" onClick="takePictureAadharBack('imageDataAadharBack')">
                                <i class="fal fa-camera"></i> आधार पीछे फोटो अपलोड करें
                            </button>

                            <?= $form->field($model, 'aadhar_back_photo')->hiddenInput()->label('') ?>
                            <img id="aadhar_back_photo-image" src="" class="img-responsive" width="200" height="300" />
                        </div>
                    </div>
                <?php } ?>
                <?php if ($model->fd_section_qno == '10a3') { ?> 
                    <div class='card'>
                        <div class="col-lg-12">    
                            <?=
                            $form->field($model, 'principal_occupation', [
                                'labelOptions' => ['class' => 'bold_lable']
                            ])->checkboxList($model->principal_occupation_option)->label("A4. आपका प्रमुख व्यवसाय (एक से ज़्यादा उत्तर पर टिक कर सकते हैं) <button asrc='/images/audio/assessment/pre/user_1/User ka vivran A4.aac' toggle='start' class='play' value='$model->fd_section_qno' type='button'><i style='color:red' class='fal fa fa-volume-up'></i></button>")
                            ?>
                            <?=
                            $form->field($model, 'principal_occupation99_text', [
                                'template' => '{input}{error}',
                            ])->textInput(['maxlength' => true])->label('')
                            ?>
                        </div>
                    </div>
                <?php } ?>
                <?php if ($model->fd_section_qno == '10a4') { ?> 
                    <div class='card'>
                        <div class="col-lg-12">    
                            <?=
                            $form->field($model, 'important_high_speed_internet', [
                                'labelOptions' => ['class' => 'bold_lable']
                            ])->checkboxList($model->important_high_speed_internet_option)->label("A5. आपके व्यवसाय में हाई स्पीड इंटरनेट का कितना महत्व है? <button asrc='/images/audio/assessment/pre/user_1/User ka vivran A5.aac' toggle='start' class='play' value='$model->fd_section_qno' type='button'><i style='color:red' class='fal fa fa-volume-up'></i></button>")
                            ?>
                        </div>
                    </div>
                <?php } ?>
                <?php if ($model->fd_section_qno == '10a5') { ?>
                    <div class='card'>
                        <div class="col-lg-12">    
                            <?=
                            $form->field($model, 'closest_your_residence', [
                                'labelOptions' => ['class' => 'bold_lable']
                            ])->checkboxList($model->closest_your_residence_option)->label("A6. निम्न में से क्या क्या आपके आवास के नज़दीक है (50 से 100 मीटर के अंदर) <button asrc='/images/audio/assessment/pre/user_1/User ka vivran A6.aac' toggle='start' class='play' value='$model->fd_section_qno' type='button'><i style='color:red' class='fal fa fa-volume-up'></i></button>")
                            ?>
                        </div>
                    </div>
                <?php } ?>
                <?php if ($model->fd_section_qno == '10a6') { ?>
                    <div class='card'>
                        <div class="col-lg-12">    
                            <?=
                            $form->field($model, 'which_township_mohalla_residence_id', [
                                'labelOptions' => ['class' => 'bold_lable']
                            ])->radioList($model->which_township_mohalla_residence_id_option, $option)->label("A7. गाँव में आपका आवास कैसी बस्ती/ मोहल्ला में स्थित है <button asrc='/images/audio/assessment/pre/user_1/User ka vivran A7.aac' toggle='start' class='play' value='$model->fd_section_qno' type='button'><i style='color:red' class='fal fa fa-volume-up'></i></button>")
                            ?>  
                        </div>
                    </div>
                <?php } ?>
                <?php if ($model->fd_section_qno == '10a7') { ?>
                    <div class='card'>
                        <div class="col-lg-12">    
                            <?=
                            $form->field($model, 'category_consider_financially_id', [
                                'labelOptions' => ['class' => 'bold_lable']
                            ])->radioList($model->category_consider_financially_id_option, $option)->label("A8. आर्थिक दृष्टिकोण से आप स्वयं को किस श्रेणी में मानते हैं <button asrc='/images/audio/assessment/pre/user_1/User ka vivran A8.aac' toggle='start' class='play' value='$model->fd_section_qno' type='button'><i style='color:red' class='fal fa fa-volume-up'></i></button>")
                            ?>  
                        </div>
                    </div>
                <?php } ?>
                <?php if ($model->fd_section_qno == '10a8') { ?>
                    <div class="card">
                        <div class="col-lg-12"> 
                            <?php
                            echo $form->field($model, 'gram_panchayat_code')->label('ग्राम पंचायत')->widget(kartik\select2\Select2::classname(), [
                                'data' => $model->gp_option,
                                'size' => Select2::MEDIUM,
                                'options' => $gp_option,
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]);
                            ?> 
                        </div>     
                    </div>
                <?php } ?>
                <?php if (in_array($model->fd_section_qno, ['10b1', '10b2', '10b3', '10b4'])) { ?> 
                    <h4>
                        B. पारिवारिक विवरण
                    </h4>
                <?php } ?>
                <?php if ($model->fd_section_qno == '10b1') { ?>
                    <div class='card'>
                        <div class="col-lg-12">    
                            <?=
                            $form->field($model, 'social_class_id', [
                                'labelOptions' => ['class' => 'bold_lable']
                            ])->radioList($model->social_class_id_option, $option)->label("B1. सामाजिक वर्ग <button asrc='/images/audio/assessment/pre/user_1/User ka vivran B1.aac' toggle='start' class='play' value='$model->fd_section_qno' type='button'><i style='color:red' class='fal fa fa-volume-up'></i></button>")
                            ?>  
                        </div>
                    </div>
                <?php } ?>
                <?php if ($model->fd_section_qno == '10b2') { ?>
                    <div class='card'>
                        <div class="col-lg-12">    
                            <?=
                            $form->field($model, 'occupation_family_head_household', [
                                'labelOptions' => ['class' => 'bold_lable']
                            ])->checkboxList($model->occupation_family_head_household_option)->label("B2. पारिवारिक/ परिवार के मुखिया  का व्यवसाय (एक से ज़्यादा उत्तर पर टिक कर सकते हैं) <button asrc='/images/audio/assessment/pre/user_1/User ka vivran B2.aac' toggle='start' class='play' value='$model->fd_section_qno' type='button'><i style='color:red' class='fal fa fa-volume-up'></i></button>");
                            ?>
                        </div>
                    </div>
                <?php } ?>
                <?php if ($model->fd_section_qno == '10b3') { ?>
                    <div class="card">
                        <div class="col-lg-12">
                            <label class="bold_lable">B3. परिवार का ढाँचा (उम्र के दृष्टि से) <?php echo "<button asrc='/images/audio/assessment/pre/user_1/User ka vivran B3.aac' toggle='start' class='play' value='$model->fd_section_qno' type='button'><i style='color:red' class='fal fa fa-volume-up'></i></button>"; ?></label>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th  class="bg-success-900">उम्र-वर्ग (वर्ष )</th> 
                                        <th class="bg-success-900">महिला</th>  
                                        <th class="bg-success-900">पुरुष</th>  
                                    </tr>
                                </thead>
                                <tbody>

                                    <tr>
                                        <td>5 से कम</td> 
                                        <td><?= $form->field($model, 'female_less5y')->textInput(['type' => 'number', 'min' => 0, 'max' => 10])->label(''); ?></td>  
                                        <td> <?= $form->field($model, 'male_less5y')->textInput(['type' => 'number', 'min' => 0, 'max' => 10])->label(''); ?></td>  
                                    </tr>
                                    <tr>
                                        <td>6 से 16</td> 
                                        <td><?= $form->field($model, 'female_6to16y')->textInput(['type' => 'number', 'min' => 0, 'max' => 10])->label(''); ?></td>  
                                        <td> <?= $form->field($model, 'male_6to16y')->textInput(['type' => 'number', 'min' => 0, 'max' => 10])->label(''); ?></td>  
                                    </tr>
                                    <tr>
                                        <td>17 से 25</td> 
                                        <td><?= $form->field($model, 'female_17to25y')->textInput(['type' => 'number', 'min' => 0, 'max' => 10])->label(''); ?></td>  
                                        <td> <?= $form->field($model, 'male_17to25y')->textInput(['type' => 'number', 'min' => 0, 'max' => 10])->label(''); ?></td>  
                                    </tr>
                                    <tr>
                                        <td>26 से 50</td> 
                                        <td><?= $form->field($model, 'female_26to50y')->textInput(['type' => 'number', 'min' => 0, 'max' => 10])->label(''); ?></td>  
                                        <td> <?= $form->field($model, 'male_26to50y')->textInput(['type' => 'number', 'min' => 0, 'max' => 10])->label(''); ?></td>  
                                    </tr>
                                    <tr>
                                        <td>51 से 65</td> 
                                        <td><?= $form->field($model, 'female_51to65y')->textInput(['type' => 'number', 'min' => 0, 'max' => 10])->label(''); ?></td>  
                                        <td> <?= $form->field($model, 'male_51to65y')->textInput(['type' => 'number', 'min' => 0, 'max' => 10])->label(''); ?></td>  
                                    </tr>
                                    <tr>
                                        <td>66 या ज़्यादा</td> 
                                        <td><?= $form->field($model, 'female_gr65y')->textInput(['type' => 'number', 'min' => 0, 'max' => 10])->label(''); ?></td>  
                                        <td> <?= $form->field($model, 'male_gr65y')->textInput(['type' => 'number', 'min' => 0, 'max' => 10])->label(''); ?></td>  
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                <?php } ?>
                <?php if ($model->fd_section_qno == '10b4') { ?>
                    <div class='card'>
                        <div class="col-lg-12">    
                            <?=
                            $form->field($model, 'family_structure_edu_health_live', [
                                'labelOptions' => ['class' => 'bold_lable']
                            ])->checkboxList($model->family_structure_edu_health_live_option)->label("B4. परिवार का ढाँचा (शिक्षा स्वास्थ्य तथा आजीविका के दृष्टि से) परिवार में निम्न संकेतकों के आधार पर टिक करें <button asrc='/images/audio/assessment/pre/user_1/User ka vivran B4.aac' toggle='start' class='play' value='$model->fd_section_qno' type='button'><i style='color:red' class='fal fa fa-volume-up'></i></button>");
                            ?>
                        </div>
                    </div>
                <?php } ?>
                <?php if (in_array($model->fd_section_qno, ['10c1', '10c2', '10c3', '10c4', '10c5'])) { ?>
                    <h4>
                        C. आकांक्षात्मक पहलू/ भविष्यदृश्य
                    </h4>
                <?php } ?>
                <?php if ($model->fd_section_qno == '10c1') { ?>
                    <div class='card'>
                        <div class="col-lg-12"> 
                            <label class="bold_lable">C1. आपके परिवार में कितने सदस्य ऐसे है जो अगले 2-4 वर्ष में निम्न स्वरूप में हो सकते हैं <?php echo "<button asrc='/images/audio/assessment/pre/user_1/User ka vivran C1.aac' toggle='start' class='play' value='$model->fd_section_qno' type='button'><i style='color:red' class='fal fa fa-volume-up'></i></button>"; ?></label>
                            <?= $form->field($model, 'family_following_form_24years1')->textInput(['type' => 'number', 'min' => 0, 'max' => 10]); ?>
                            <?= $form->field($model, 'family_following_form_24years2')->textInput(['type' => 'number', 'min' => 0, 'max' => 10]); ?>
                            <?= $form->field($model, 'family_following_form_24years3')->textInput(['type' => 'number', 'min' => 0, 'max' => 10]); ?>
                            <?= $form->field($model, 'family_following_form_24years4')->textInput(['type' => 'number', 'min' => 0, 'max' => 10]); ?>
                            <?= $form->field($model, 'family_following_form_24years5')->textInput(['type' => 'number', 'min' => 0, 'max' => 10]); ?>
                            <?= $form->field($model, 'family_following_form_24years6')->textInput(['type' => 'number', 'min' => 0, 'max' => 10]); ?>
                            <?= $form->field($model, 'family_following_form_24years7')->textInput(['type' => 'number', 'min' => 0, 'max' => 10]); ?>
                            <?= $form->field($model, 'family_following_form_24years8')->textInput(['type' => 'number', 'min' => 0, 'max' => 10]); ?>
                            <?= $form->field($model, 'family_following_form_24years99')->textInput(['type' => 'number', 'min' => 0, 'max' => 10]); ?>
                            <?php
                            $form->field($model, 'family_following_form_24years', [
                                'labelOptions' => ['class' => 'bold_lable']
                            ])->checkboxList($model->family_following_form_24years_option)->label("C1. आपके परिवार में कितने सदस्य ऐसे है जो अगले 2-4 वर्ष में निम्न स्वरूप में हो सकते हैं <button asrc='/images/audio/assessment/pre/user_1/User ka vivran C1.aac' toggle='start' class='play' value='$model->fd_section_qno' type='button'><i style='color:red' class='fal fa fa-volume-up'></i></button>")
                            ?>
                        </div>
                    </div>
                <?php } ?>
                <?php if ($model->fd_section_qno == '10c2') { ?>
                    <div class="card">
                        <div class="col-lg-12">
                            <label class="bold_lable">C2. परिवार में कितने सदस्य है जो अगले 2-4 वर्ष में परिवार के आर्थिक प्रगति/ समृद्धि में सहायक हो सकेंगे? <?php echo "<button asrc='/images/audio/assessment/pre/user_1/User ka vivran C2.aac' toggle='start' class='play' value='$model->fd_section_qno' type='button'><i style='color:red' class='fal fa fa-volume-up'></i></button>"; ?></label>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th  class="bg-success-900">संख्या</th> 
                                        <th class="bg-success-900">महिला</th>  
                                        <th class="bg-success-900">पुरुष</th>  
                                    </tr>
                                </thead>
                                <tbody>

                                    <tr>
                                        <td>1</td> 
                                        <td><?= $form->field($model, 'female_help1')->textInput(['type' => 'number', 'min' => 0, 'max' => 5])->label(''); ?></td>  
                                        <td> <?= $form->field($model, 'male_help1')->textInput(['type' => 'number', 'min' => 0, 'max' => 5])->label(''); ?></td>  
                                    </tr>
                                    <tr>
                                        <td>2</td> 
                                        <td><?= $form->field($model, 'female_help2')->textInput(['type' => 'number', 'min' => 0, 'max' => 5])->label(''); ?></td>  
                                        <td> <?= $form->field($model, 'male_help2')->textInput(['type' => 'number', 'min' => 0, 'max' => 5])->label(''); ?></td>  
                                    </tr>
                                    <tr>
                                        <td>2 से ज़्यादा</td> 
                                        <td><?= $form->field($model, 'female_helpgr2')->textInput(['type' => 'number', 'min' => 0, 'max' => 10])->label(''); ?></td>  
                                        <td> <?= $form->field($model, 'male_helpgr2')->textInput(['type' => 'number', 'min' => 0, 'max' => 10])->label(''); ?></td>  
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php } ?>
                <?php if ($model->fd_section_qno == '10c3') { ?>
                    <div class='card'>
                        <div class="col-lg-12">    
                            <?=
                            $form->field($model, 'what_can_government_help', [
                                'labelOptions' => ['class' => 'bold_lable']
                            ])->checkboxList($model->what_can_government_help_option)->label("C3 इन सदस्यों में निहित संभावना को साकार करने के लिए सरकार आपकी क्या क्या मदद कर सकती है <button asrc='/images/audio/assessment/pre/user_1/User ka vivran C3.aac' toggle='start' class='play' value='$model->fd_section_qno' type='button'><i style='color:red' class='fal fa fa-volume-up'></i></button>")
                            ?>
                            <?=
                            $form->field($model, 'what_can_government_help99_text', [
                                'template' => '{input}{error}',
                            ])->textInput(['maxlength' => true])->label('')
                            ?>
                        </div>
                    </div>
                <?php } ?>
                <?php if ($model->fd_section_qno == '10c4') { ?>
                    <div class='card'>
                        <div class="col-lg-12">    
                            <?=
                            $form->field($model, 'your_family_financially_capable_id', [
                                'labelOptions' => ['class' => 'bold_lable']
                            ])->radioList($model->your_family_financially_capable_id_option)->label("C4. आपको अपने परिवार को आर्थिक रूप से पूर्णतः सक्षम बनाने के लिए न्यूनतम कितना मासिक आय की अपेक्षा है <button asrc='/images/audio/assessment/pre/user_1/User ka vivran C4.aac' toggle='start' class='play' value='$model->fd_section_qno' type='button'><i style='color:red' class='fal fa fa-volume-up'></i></button>");
                            ?>
                        </div>
                    </div>
                <?php } ?>
                <?php if ($model->fd_section_qno == '10c5') { ?>
                    <div class='card'>
                        <div class="col-lg-12">    
                            <?=
                            $form->field($model, 'for_monthly_income_expect_id', [
                                'labelOptions' => ['class' => 'bold_lable']
                            ])->radioList($model->for_monthly_income_expect_id_option)->label("C5. आप द्वारा अपेक्षित मासिक आय के लिए आप <button asrc='/images/audio/assessment/pre/user_1/User ka vivran C5.aac' toggle='start' class='play' value='$model->fd_section_qno' type='button'><i style='color:red' class='fal fa fa-volume-up'></i></button>");
                            ?>
                        </div>
                    </div>
                <?php } ?>
                <div class="form-group text-center">
                    <div style="display: none">
                        <?= $form->field($model, 'fd_section_qno')->hiddenInput()->label('') ?> 
                        <?= $form->field($model, 'fd_section')->hiddenInput(['value' => $section])->label('') ?> 
                        <?= $form->field($model, 'user_id')->hiddenInput()->label('') ?>
                        <?= $form->field($model, 'id')->hiddenInput()->label('') ?>
                    </div>    
                    <?= Html::submitButton('सेव (save)', ['class' => 'btn btn-small btn-info', 'name' => 'save_b', 'id' => 'save_b']) ?>
                    <a href="<?= '/online/fb/form' ?>" class="btn btn-dark"><i class="fal fa fa-arrow-left" aria-hidden="true"></i><span> वापस</span> </a> 
                </div>     
            </div>
        </div>    
    </div> 
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
<?php
$style1 = <<< CSS
 .card {
    margin-bottom: 5px !important;
}
.bold_lable {
  font-weight: bold !important;  
}
CSS;
$this->registerCss($style1);
?>
<?php
$style = <<< CSS
 .form-group {
  margin-bottom: 0.5rem !important;
}     
CSS;
$this->registerCss($style);
?>
<?php
$js = <<<JS
    $(document).ready(function() { 
       
        $(".field-fbdemandsideform-principal_occupation99_text").css("display","none");
        $(".field-fbdemandsideform-what_can_government_help99_text").css("display","none");
    $("#fbdemandsideform-principal_occupation").on("change", function() {
            ApCheck=[];
            $("input[name='FbdemandsideForm[principal_occupation][]']:checked").each(function() {
             ApCheck.push($(this).val());
             console.log(ApCheck);
             if(ApCheck.includes('99')) {
            $(".field-fbdemandsideform-principal_occupation99_text").css("display","block");
           }else {
            $(".field-fbdemandsideform-principal_occupation99_text").css("display","none");
            $("#fbdemandsideform-principal_occupation99_text").val('');
           }
            });  
       }); 
        
        $("#fbdemandsideform-what_can_government_help").on("change", function() {
            ApCheck=[];
            $("input[name='FbdemandsideForm[what_can_government_help][]']:checked").each(function() {
             ApCheck.push($(this).val());
             console.log(ApCheck);
             if(ApCheck.includes('99')) {
            $(".field-fbdemandsideform-what_can_government_help99_text").css("display","block");
           }else {
           $(".field-fbdemandsideform-what_can_government_help99_text").css("display","none");
              $("#fbdemandsideform-what_can_government_help99_text").val('');
           }
            });  
       }); 
    
    });         
JS;
$this->registerJs($js);
?>
