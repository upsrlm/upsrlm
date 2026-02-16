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
<div class='card'>
    <div class="col-lg-12">
        <div class="text-center"> 
            <h3>
                <?= $this->title ?>
            </h3>
        </div>
    </div>
    <div class="col-lg-12">
        <div class='card'>
            <div class="col-lg-12">    
                <?php
                echo Html::activeLabel($model, "name", ['class' => 'bold_lable'])
                ?>
                <?= '<div>' . $model->name . '</div>' ?>
                <?php
                echo Html::activeLabel($model, "mobile_no", ['class' => 'bold_lable'])
                ?>
                <?= '<div>' . $model->mobile_no . '</div>' ?>
                <?php
                echo Html::activeLabel($model, "phone_type", ['class' => 'bold_lable'])
                ?>
                <?= '<div>' . $model->phonetypef . '</div>' ?>
            </div>
        </div>
        <div class='card'>
            <div class="col-lg-12">    
                <?php
                echo Html::activeLabel($model, "aadhar_number", ['class' => 'bold_lable'])
                ?>
                <?= '<p>' . $model->aadhar_number . '</p>' ?>

                <div class="col-lg-12">  
                    <label for="applicationform-training">आधार फ्रंट फोटो </label>
                    <div style='padding: 0.5rem 0.875rem; border: 1px solid #E5E5E5; border-radius: 4px;'>
                        <?= $model->aadhar_front_photo != null ? '<span class="profile-picture">
                                        <img width="220px" height="220px" src="' . $model->aadhar_front_photo_url . '" data-src="' . $model->aadhar_front_photo_url . '"  class="lozad" title="आधार फ्रंट फोटो"/>
                                        </span> ' : '-' ?>
                    </div>
                    <div class="col-lg-12">  
                        <label for="applicationform-training">आधार बैक फोटो  </label>
                        <div style='padding: 0.5rem 0.875rem; border: 1px solid #E5E5E5; border-radius: 4px;'>
                            <?= $model->aadhar_back_photo != null ? '<span class="profile-picture">
                                        <img width="220px" height="220px" src="' . $model->aadhar_back_photo_url . '" data-src="' . $model->aadhar_back_photo_url . '"  class="lozad" title="आधार बैक फोटो"/>
                                        </span> ' : '-' ?>  
                        </div>

                    </div>
                </div>
            </div>        
            <div class='card-body'>
                <div class='card'>
                    <div class="col-lg-12">    
                        <label class="bold_lable" name="principal_occupation">A4. आपका प्रमुख व्यवसाय (एक से ज़्यादा उत्तर पर टिक कर सकते हैं)</label>
                        <?= $model->getPrincipaloccupationhtml() ?>   
                    </div>
                </div>
                <div class='card'>
                    <div class="col-lg-12">    
                        <label class="bold_lable" name="important_high_speed_internet">A5. आपके व्यवसाय में हाई स्पीड इंटरनेट का कितना महत्व है?)</label>
                        <?= $model->getImportanthighspeedinternethtml() ?>   
                    </div>
                </div>
                <div class='card'>
                    <div class="col-lg-12">    
                        <?php
                        echo Html::activeLabel($model, "which_township_mohalla_residence_id", ['class' => 'bold_lable'])
                        ?>
                        <?= $model->whichtownshipmohallaresidenceidf ?>
                    </div>
                </div>
                <div class='card'>
                    <div class="col-lg-12">    
                        <?php
                        echo Html::activeLabel($model, "category_consider_financially_id", ['class' => 'bold_lable'])
                        ?>
                        <?= $model->categoryconsiderfinanciallyidf ?>
                    </div>
                </div>
                <div class='card'>
                    <div class="col-lg-12">    
                        <?php
                        echo Html::activeLabel($model, "gram_panchayat_code", ['class' => 'bold_lable'])
                        ?>
                        <?= '<p>' . $model->gram_panchayat_name . '</p>' ?>
                    </div>
                </div>
                <h3>
                    B. पारिवारिक विवरण
                </h3>
                <div class='card'>
                    <div class="col-lg-12">    
                        <label class="bold_lable" name="social_class_id">B1. सामाजिक वर्ग</label>
                        <?= $model->socialclassidf ?>   
                    </div>
                </div>
                <div class='card'>
                    <div class="col-lg-12">    
                        <label class="bold_lable" name="occupation_family_head_household">B2. पारिवारिक/ परिवार के मुखिया  का व्यवसाय (एक से ज़्यादा उत्तर पर टिक कर सकते हैं)</label>
                        <?= $model->getOccupationfamilyheadhouseholdhtml() ?>   
                    </div>
                </div>
                <div class='card'>
                    <div class="col-lg-12">    
                        <label class="bold_lable">B3. परिवार का ढाँचा (उम्र के दृष्टि से)</label>
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
                                    <td><?= $model->female_less5y ?></td>  
                                    <td> <?= $model->male_6to16y ?></td>  
                                </tr>
                                <tr>
                                    <td>6 से 16</td> 
                                    <td><?= $model->female_6to16y ?></td>  
                                    <td> <?= $model->male_6to16y ?></td>  
                                </tr>
                                <tr>
                                    <td>17 से 25</td> 
                                    <td><?= $model->female_17to25y ?></td>  
                                    <td> <?= $model->male_17to25y ?></td> 
                                </tr>
                                <tr>
                                    <td>26 से 50</td> 
                                    <td><?= $model->female_26to50y ?></td>  
                                    <td> <?= $model->male_26to50y ?></td> 
                                </tr>
                                <tr>
                                    <td>51 से 65</td> 
                                    <td><?= $model->female_51to65y ?></td>  
                                    <td> <?= $model->male_51to65y ?></td> 
                                </tr>
                                <tr>
                                    <td>66 या ज़्यादा</td> 
                                    <td><?= $model->female_gr65y ?></td>  
                                    <td> <?= $model->male_gr65y ?></td> 
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>


                <div class='card'>
                    <div class="col-lg-12">    
                        <label class="bold_lable" name="family_structure_edu_health_live">B4. परिवार का ढाँचा (शिक्षा स्वास्थ्य तथा आजीविका के दृष्टि से)</label>
                        <?= $model->getFamilystructureeduhealthlivehtml() ?>   
                    </div>
                </div>

                <h3>
                    C. आकांक्षात्मक पहलू/ भविष्यदृश्य
                </h3>
                <div class='card'>
                    <div class="col-lg-12">    
                        <label class="bold_lable" name="family_following_form_24years">C1. आपके परिवार में कितने सदस्य ऐसे है जो अगले 2-4 वर्ष में निम्न स्वरूप में हो सकते हैं</label>
                        <?= $model->getFamilyfollowingform24yearshtml() ?>  
                    </div>
                </div>


                <div class='card'>
                    <div class="col-lg-12"> 
                        <label class="bold_lable">C2. परिवार में कितने सदस्य है जो अगले 2-4 वर्ष में परिवार के आर्थिक प्रगति/ समृद्धि में सहायक हो सकेंगे?</label>
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
                                    <td><?= $model->female_help1 ?></td>  
                                    <td><?= $model->male_help1 ?></td>  
                                </tr>
                                <tr>
                                    <td>2</td> 
                                    <td><?= $model->female_help2 ?></td>  
                                    <td><?= $model->male_help2 ?></td>   
                                </tr>
                                <tr>
                                    <td>2 से ज़्यादा</td> 
                                    <td><?= $model->female_helpgr2 ?></td>  
                                    <td><?= $model->male_helpgr2 ?></td>   
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class='card'>
                    <div class="col-lg-12">    
                        <label class="bold_lable" name="what_can_government_help">C3 इन सदस्यों में निहित संभावना को साकार करने के लिए सरकार आपकी क्या क्या मदद कर सकती है ?</label>
                        <?= $model->getWhatcangovernmenthelphtml() ?>

                    </div>
                </div>
                <div class='card'>
                    <div class="col-lg-12">   
                        <?php
                        echo Html::activeLabel($model, "your_family_financially_capable_id", ['class' => 'bold_lable'])
                        ?>
                        <?= $model->yourfamilyfinanciallycapableidf ?>

                    </div>
                </div>

                <div class='card'>
                    <div class="col-lg-12">    
                        <?php
                        echo Html::activeLabel($model, "for_monthly_income_expect_id", ['class' => 'bold_lable'])
                        ?>
                        <?= $model->formonthlyincomeexpectidf ?>
                    </div>
                </div>

                <div class="form-group text-center">

                    <a href="<?= '/online/fb/form' ?>" class="btn btn-dark"><i class="fal fa fa-arrow-left" aria-hidden="true"></i><span> वापस</span> </a> 
                </div>     
            </div>
        </div>    
    </div>  

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
 