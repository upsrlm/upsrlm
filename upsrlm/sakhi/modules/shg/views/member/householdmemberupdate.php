<?php

use yii\helpers\Html;

$pagetitle = $this->title = 'सदस्य का विवरण';

$nextscneario = 'profile';
$file = '_householdmemberform_profile';
if ($model->scenario == 'bank') {
    $pagetitle = ' बैंक का विवरण';
    $file = '_householdmemberform_bank';
    $nextscneario = 'aadhar';
} else if ($model->scenario == 'aadhar') {
    $pagetitle = 'आधार विवरण';
    $file = '_householdmemberform_aadhar';
    $nextscneario = 'vote';
} else if ($model->scenario == 'vote') {
    $pagetitle = ' मतदाता कार्ड विवरण';
    $file = '_householdmemberform_vote';
} else {
    $nextscneario = 'bank';
}
?>
<div class="subheader">
    <h1 class="subheader-title">
        <?= $pagetitle ?>
        <?php //if ($model->shg_member_model->id && !isset($model->shg_member_model->user_id)) {
        ?>
        <?php
        //  \sakhi\widgets\RemoveButton::widget([
        //     'options' => [
        //         'value' => '/shg/member/remove?shgid=' . $model->shg_member_model->cbo_shg_id . '&shg_member_id=' . $model->shg_member_model->id,
        //     ],
        // ]); 
        ?>
        <?php // } 
        ?>
    </h1>
</div>


<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-container show">

                <div class="panel-content" id="scnearioform">
                    <?php

                    echo $this->render($file, [
                        'model' => $model,
                        'action_url' => "/shg/member/householdmemberupdate?shgid=" . $model->cbo_shg_id . "&dbt_household_id=" . $model->dbt_beneficiary_household_id . "&dbt_member_id=" . $model->dbt_member_model->id . "&scenario=" . $model->scenario
                    ])
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>


<?php
$js = <<<JS

function runformupdatefunction(data){
    let dbt_member_id = data.dbt_member_id;
    $("#scnearioform").load("/shg/member/householdmemberupdatecheck?shgid={$model->cbo_shg_id}&dbt_household_id={$model->dbt_beneficiary_household_id}&dbt_member_id="+dbt_member_id+"&scenario={$nextscneario}");      
}

JS;
$this->registerjs($js);
?>