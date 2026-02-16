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
                    <?php
                    echo Html::activeLabel($model, "sec4_can_you_do_mobile_banking_service", ['class' => 'bold_lable'])
                    ?> 
                    <?= $model->sec4canyoudomobilebankingservicef ?>
                </div>
            </div>


            <div class='card'>
                <div class="col-lg-12">    
                    <?php
                    echo Html::activeLabel($model, "sec4_avg_visit_bank_atm_in_month", ['class' => 'bold_lable'])
                    ?> 
                    <?= $model->sec4avgvisitbankatminmonthf ?>
                </div>
            </div>


            <div class='card'>
                <div class="col-lg-12">    
                    <?php
                    echo Html::activeLabel($model, "sec4_easy_access_to_banking_services", ['class' => 'bold_lable'])
                    ?>  
                    <?= $model->sec4easyaccesstobankingservicesf ?>
                </div>
            </div>


            <div class='card'>
                <div class="col-lg-12"> 
                    <label class="bold_lable">4.4 वित्तीय सेवा के लिए क्या मोबाइल पर निम्न सुविधा प्राप्त होने पर क्या आपके समय और ऊर्जा की वचत होगी?</label>
                    <?php
                    echo '<br/>' . Html::activeLabel($model, "sec4_loan_application", ['class' => 'bold_lable'])
                    ?>
                    <?= $model->getYesnoideaf('sec4_loan_application') ?>

                    <?php
                    echo Html::activeLabel($model, "sec4_Intimation_debt_any_other_receipt", ['class' => 'bold_lable'])
                    ?>
                    <?= $model->getYesnoideaf('sec4_Intimation_debt_any_other_receipt') ?>

                    <?php
                    echo Html::activeLabel($model, "sec4_step_wise_information_financial_process_bank", ['class' => 'bold_lable'])
                    ?>
                    <?= $model->getYesnoideaf('sec4_step_wise_information_financial_process_bank') ?>

                    <?php
                    echo Html::activeLabel($model, "sec4_transaction_details_bank_account", ['class' => 'bold_lable'])
                    ?>
                    <?= $model->getYesnoideaf('sec4_transaction_details_bank_account') ?>
                    <?php
                    echo Html::activeLabel($model, "sec4_insurance_application", ['class' => 'bold_lable'])
                    ?>
                    <?= $model->getYesnoideaf('sec4_insurance_application') ?>
                    <?php
                    echo Html::activeLabel($model, "sec4_all_payments_made_by_you", ['class' => 'bold_lable'])
                    ?>
                    <?= $model->getYesnoideaf('sec4_all_payments_made_by_you') ?>
                    <?php
                    echo Html::activeLabel($model, "sec4_schemes_benefits_updates", ['class' => 'bold_lable'])
                    ?>
                    <?= $model->getYesnoideaf('sec4_schemes_benefits_updates') ?>
                    <?php
                    echo Html::activeLabel($model, "sec4_buy_sell_on_ecommerce_platform", ['class' => 'bold_lable'])
                    ?>
                    <?= $model->getYesnoideaf('sec4_buy_sell_on_ecommerce_platform') ?>
                    <?php
                    echo Html::activeLabel($model, "sec4_knowledge_financial_literacy_money_management", ['class' => 'bold_lable'])
                    ?>
                    <?= $model->getYesnoideaf('sec4_knowledge_financial_literacy_money_management') ?>


                </div>
            </div>


            <div class='card'>
                <div class="col-lg-12">    
                    <?php
                    echo Html::activeLabel($model, "sec4_bc_sakhi_gram_panchayat", ['class' => 'bold_lable'])
                    ?>
                    <?= $model->getYesnof('sec4_bc_sakhi_gram_panchayat') ?>
                    <?php
                    echo Html::activeLabel($model, "sec4_yes_bc_sakhi_gram_panchayat", ['class' => 'bold_lable'])
                    ?>
                    <?= $model->getYesnof('sec4_yes_bc_sakhi_gram_panchayat') ?>
                    <?php
                    echo Html::activeLabel($model, "sec4_transaction_failure_bc_sakhi", ['class' => 'bold_lable'])
                    ?>
                    <?= $model->getYesnof('sec4_transaction_failure_bc_sakhi') ?>
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
 