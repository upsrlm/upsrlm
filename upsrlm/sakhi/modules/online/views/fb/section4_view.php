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

        <div class='card-body'>

            <div class='card'>
                <div class="col-lg-12">    
                     <label class="bold_lable">3.1 क्या स्मार्टफ़ोन/ टच-वाला मोबाइल फ़ोन के माध्यम से कृषि-संबंधी सुविधाएँ प्राप्त की जा सकते है</label>
                    <?= $model->getSec3agrirelatedfeaturesaccessedmobilehtml() ?> 
                </div>
            </div>


            <div class='card'>
                <div class="col-lg-12">    
                    <label class="bold_lable">3.2 अगर ऐसी सुविधा हैं/ हो, तो क्या इससे आपको फ़ायदा होगा?</label>
                    <?= $model->getSec3facilityavailablebenefityouhtml() ?> 
                </div>
            </div>


            <div class='card'>
                <div class="col-lg-12">    
                   <label class="bold_lable">3.3 अगर स्मार्टफ़ोन पर कृषि संबंधी सेवाओं की सुविधा दे जाती है, तो निम्न में से किन किन सुविधा में आप रुचि लेंगे?</label>
                    <?= $model->getSec3interestedagricultureprovidedsmartphoneshtml() ?> 
                </div>
            </div>


            <div class='card'>
                <div class="col-lg-12"> 
                   <?php
                    echo Html::activeLabel($model, "sec3_maximum_fee_agri_related_facilities_arranged", ['class' => 'bold_lable'])
                    ?>
                    <?= $model->getSec3maximumfeeagrirelatedfacilitiesarrangedf() ?> 
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
 