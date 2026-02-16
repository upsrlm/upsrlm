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
                    echo Html::activeLabel($model, "sec1_use_any_elearning_app_portal", ['class' => 'bold_lable'])
                    ?>
                    <?= $model->getYesnof('sec1_use_any_elearning_app_portal') ?>
                    <?php if ($model->sec1_use_any_elearning_app_portal == 1) { ?>
                        <?php
                        echo Html::activeLabel($model, "sec1_yes_which_elearning_product_use", ['class' => 'bold_lable']) . '<br/>';
                        ?>
                        <?= $model->sec1_yes_which_elearning_product_use ?>  
                        <?php
                        echo '<br/>' . Html::activeLabel($model, "sec1_how_much_annual_subscription", ['class' => 'bold_lable']) . '<br/>';
                        ?>
                        <?= $model->sec1_how_much_annual_subscription ?>  
                    <?php } ?>
                </div>
            </div>

            <?php if ($model->sec1_use_any_elearning_app_portal == 2) { ?>
                <div class='card'>
                    <div class="col-lg-12">    
                        <?php
                        echo Html::activeLabel($model, "sec1_if_not_why", ['class' => 'bold_lable']) . '<br/>';
                        ?>
                        <?= $model->getSec1ifnotwhyf() ?>    
                    </div>
                </div>
            <?php } ?>

            <div class='card'>
                <div class="col-lg-12">    
                    <?php
                    echo Html::activeLabel($model, "sec1_whether_school_teachers_using_elearning_product", ['class' => 'bold_lable'])
                    ?>
                    <?= $model->getYesnof('sec1_whether_school_teachers_using_elearning_product') ?>
                    <?php if ($model->sec1_whether_school_teachers_using_elearning_product == 1) { ?>
                        <?php
                        echo Html::activeLabel($model, "sec1_yes_whether_school_teachers_using_elearning_product_name", ['class' => 'bold_lable']) . '<br/>';
                        ?>
                        <?= $model->sec1_yes_whether_school_teachers_using_elearning_product_name ?>  
                        <?php
                        echo '<br/>' . Html::activeLabel($model, "sec1_yes_whether_school_teachers_using_elearning_product_subscri", ['class' => 'bold_lable']) . '<br/>';
                        ?>
                        <?= $model->sec1_yes_whether_school_teachers_using_elearning_product_subscri ?>   
                    <?php } ?>
                </div>
            </div>

            <?php if ($model->sec1_whether_school_teachers_using_elearning_product == 2) { ?>
                <div class='card'>
                    <div class="col-lg-12"> 
                        <?php
                        echo Html::activeLabel($model, "sec1_no_whether_school_teachers_using_elearning_product", ['class' => 'bold_lable']) . '<br/>';
                        ?>
                        <?= $model->getSec1nowhetherf() ?>   

                    </div>
                </div>
            <?php } ?>

            <div class='card'>
                <div class="col-lg-12">    
                    <?php
                    echo Html::activeLabel($model, "sec1_elearning_facility_improve_education", ['class' => 'bold_lable']) . '<br/>';
                    ?>
                    <?= $model->sec1elearningfacilityimproveeducationf ?> 
                </div>
            </div>
            <div class='card'>
                <div class="col-lg-12">    
                    <?php
                    echo Html::activeLabel($model, "sec1_yes_elearning_facility_improve_education_min_cost", ['class' => 'bold_lable']) . '<br/>';
                    ?>
                    <?= $model->sec1yeselearningfacilityimproveeducationmincostf ?>    
                </div>
            </div>
            <div class='card'>
                <div class="col-lg-12">    
                    <?php
                    echo Html::activeLabel($model, "sec1_part_of_cost_borne_by_government", ['class' => 'bold_lable']) . '<br/>';
                    ?>
                    <?= $model->sec1partofcostbornebygovernmentf ?>   
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
 