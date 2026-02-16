<?php

use yii\helpers\Html;

$app = new \sakhi\components\App();
$this->title = $household->rishtashgmember->name . ' के परिवार के सदस्यों का विवरण';
?>

<h2><?= $this->title ?></h2>

<div class="subheader mb-2">
    SHG का नाम : <?= $shg_model->name_of_shg ?><br>
    परिवार के कुल सदस्य : <?= $totalmember ?><br>
    बीओसीडब्ल्यू पंजीकरण संख्या : <?= $household->bocw_reg_no != null ? $household->bocw_reg_no : '' ?>
</div>
<div class="subheader mb-3">
    <h5 class="subheader-title">
        <?php if ($app->checkAccess('shg', Yii::$app->user->identity, '/shg/member/mgnregascheme', ['shgid' => $shg_model->id])) { ?>
            <a href="/shg/member/mgnregascheme?shgid=<?= $shg_model->id ?>&dbt_household_id=<?= $household->id ?>" class="float-right btn btn-primary mb-2"><i class="fal fa-edit"> मनरेगा योजना</i></a>
        <?php } ?>
        <?php if ($app->checkAccess('shg', Yii::$app->user->identity, '/shg/member/bocw', ['shgid' => $shg_model->id]) and $household->bocw_reg_no == null) { ?>    
            <a href="/shg/member/bocw?shgid=<?= $shg_model->id ?>&dbt_household_id=<?= $household->id ?>" class="float-right btn btn-primary mb-2"><i class="fal fa-edit"> बीओसीडब्ल्यू पंजीकरण संख्या</i></a>
        <?php } ?>
        <?php if ($app->checkAccess('shg', Yii::$app->user->identity, '/shg/member/householdmemberupdate', ['shgid' => $shg_model->id])) { ?>      
            <a href="/shg/member/householdmemberupdate?shgid=<?= $shg_model->id ?>&dbt_household_id=<?= $household->id ?>" class="float-right btn btn-info"><i class="fal fa-plus"> परिवार के अन्य सदस्य को जोड़ें </i></a>
        <?php } ?>
    </h5>
</div>
<?php foreach ($dataProvider->models as $key => $model) { ?>
    <div class="card mb-2">
        <div class="card-body">
            <h5 class="card-title">सदस्य का नाम : <?= $model->name ?></h5>
            <p class="card-text">सदस्य का मोबाइल न0 : <?= $model->mobile ?> <br>
                लिंग: <?= $model->genderlabel ? $model->genderlabel->name_hi : '' ?><br>
                सदस्य विवरण: <?= $model->profilecomplete ?><br>
                आधार विवरण: <?= $model->aadharcomplete ?><br>
                बैंक का विवरण: <?= $model->bankcomplete ?><br>
                मतदाता कार्ड विवरण: <?= $model->votercomplete ?><br>
            </p>
            <small class="text-muted">
                <?php if ($app->checkAccess('shg', Yii::$app->user->identity, '/shg/member/householdmemberupdate', ['shgid' => $shg_model->id])) { ?>      
                    <?=
                    '' .
                    Html::a('<span class="fal fa-edit">अपडेट करें</span>', ['/shg/member/householdmemberupdate', 'shgid' => $model->cbo_shg_id, 'dbt_household_id' => $household->id, 'dbt_member_id' => $model->id], [
                        'data-pjax' => "0",
                        'class' => 'btn btn-sm btn-info float-left',
                    ]) . ' ';
                    ?>
                <?php } ?>  
                <?php if ($app->checkAccess('shg', Yii::$app->user->identity, '/shg/member/bocw', ['shgid' => $shg_model->id]) and $household->bocw_reg_no) { ?>  
                    <?php
                    echo Html::a('<span class="fal fa-edit"> बीओसीडब्ल्यू मांग आवेदन भरें</span>', ['/shg/member/bocwform', 'shgid' => $model->cbo_shg_id, 'dbt_household_id' => $household->id, 'dbt_member_id' => $model->id], [
                        'data-pjax' => "0",
                        'class' => 'btn btn-sm btn-info float-left',
                    ]) . ' ';
                    ?>
                <?php } ?>
                <?php
                if (isset($model->payments)) {
                    foreach ($model->payments as $payment) {
                        ?>
                        <?php if ($app->checkAccess('shg', Yii::$app->user->identity, '/shg/mgnrega/ackpayment', ['shgid' => $shg_model->id])) { ?>  
                            <?php
                            echo Html::a('<span class="fal fa-check-circle"> मनरेगा भुगतान पावती भरें</span>', ['/shg/mgnrega/ackpayment', 'shgid' => $model->cbo_shg_id, 'da_member_fto_ack_id' => $payment->id], [
                                'data-pjax' => "0",
                                'class' => 'btn btn-sm btn-info float-left',
                            ]) . ' ';
                            ?>
                        <?php } ?>
                    <?php
                    }
                }
                ?>
            </small>
        </div>
    </div>
<?php } ?>