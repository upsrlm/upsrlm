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

$this->title = 'Field Associate';
$app = new \sakhi\components\App();
?>
<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">

            <div class="panel-container show">
                <div class="panel-content">
                    <?php
                    foreach ($bc_model->associate as $model) {

                        $bank = \bc\models\master\MasterPartnerBank::findOne($model->master_partner_bank_id)
                        ?> 
                        <div class="card">
                            <div class='card'>
                                <div class="col-lg-12">  
                                    <label for="applicationform-training">Field Officer Name</label>
                                    <div class="form-group"><?= isset($model->name_of_the_field_officer) ? $model->name_of_the_field_officer : '' ?></div>

                                </div>
                            </div>


                            <div class='card'>
                                <div class="col-lg-12">  
                                    <label for="applicationform-training">Bank Partner Name</label>
                                    <div class="form-group"><?= isset($bank) ? $bank->bank_name : '' ?></div>

                                </div>
                            </div>
                            <div class='card'>
                                <div class="col-lg-12">  
                                    <label for="applicationform-training">Gender</label>
                                    <div class="form-group"><?= $model->gen ?></div>

                                </div>
                            </div>
                            <div class='card'>
                                <div class="col-lg-12">  
                                    <label for="applicationform-training">Age</label>
                                    <div class="form-group"><?= $model->age ?></div>

                                </div>
                            </div>
                            <div class='card'>
                                <div class="col-lg-12">  
                                    <label for="applicationform-training">Designation</label>
                                    <div class="form-group"><?= $model->designation ?></div>

                                </div>
                            </div>


                            <div class='card'>
                                <div class="col-lg-12">  
                                    <label for="applicationform-training">Mobile No.</label>
                                    <div class="form-group"><?= $model->mobile_no ?></div>

                                </div>
                            </div> 

                            <div class='card'>
                                <div class="col-lg-12">  
                                    <label for="applicationform-training">Alternate Mobile No. </label>
                                    <div class="form-group"><?= $model->alternate_mobile_no ?></div>

                                </div>
                            </div> 
                            <div class='card'>
                                <div class="col-lg-12">  
                                    <label for="applicationform-training">Whatsapp No. </label>
                                    <div class="form-group"><?= $model->whatsapp_no ?></div>

                                </div>
                            </div>
                            <div class='card'>
                                <div class="col-lg-12">  
                                    <label for="applicationform-training">Name Of Supervisor</label>
                                    <div class="form-group"><?= $model->name_of_supervisor ?></div>

                                </div>
                            </div> 

                            <div class='card'>
                                <div class="col-lg-12">  
                                    <label for="applicationform-training">Designation Of Supervisor </label>
                                    <div class="form-group"><?= $model->designation_of_supervisor ?></div>

                                </div>
                            </div> 
                            <div class='card'>
                                <div class="col-lg-12">  
                                    <label for="applicationform-training">Mobile No Of Supervisor </label>
                                    <div class="form-group"><?= $model->mobile_no_of_supervisor ?></div>

                                </div>
                            </div>
                            <div class='card'>
                                <div class="col-lg-12">  
                                    <label for="applicationform-training">Profile Photo</label>
                                    <div style='padding: 0.5rem 0.875rem; border: 1px solid #E5E5E5; border-radius: 4px;'>
                                        <?= $model->photo_profile != null ? '<span class="profile-picture">
                                        <img width="220px" height="220px" src="' . $model->getImageUrl("photo_profile") . '" data-src="' . $model->getImageUrl("photo_profile") . '"  class="lozad" title="प्रोफाइल फोटो "/>
                                        </span> ' : '-' ?>
                                    </div>
                                </div>
                            </div>
                            <div class='card'>
                                <div class="col-lg-12">  
                                    <label for="applicationform-training">Company letter</label>
                                    <div style='padding: 0.5rem 0.875rem; border: 1px solid #E5E5E5; border-radius: 4px;'>
                                        <?= $model->company_letter != null ? '<span class="profile-picture">
                                        <img width="220px" height="220px" src="' . $model->getImageUrl("company_letter") . '" data-src="' . $model->getImageUrl("company_letter") . '"  class="lozad" title="Company letter"/>
                                        </span> ' : '-' ?>  
                                    </div>
                                </div>
                            </div>
                            
                            <div class='card'>
                                <div class="col-lg-12">  
                                    <label for="applicationform-training" class="text-danger">Company bank account no.where BCs make payment for handheld equipment</label>
                                    <div class="form-group"><?= $model->bank_account_number ?></div>

                                </div>
                            </div>
                        </div>    

<?php } ?>

                </div>
            </div>
        </div>
    </div>
</div>