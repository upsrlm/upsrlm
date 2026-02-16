<?php

use yii\helpers\Html;
use common\models\dynamicdb\cbo_detail\dbt\DbtBeneficiaryMember;
use common\models\dynamicdb\cbo_detail\dbt\DbtBeneficiaryHousehold;

$app = new \sakhi\components\App();
$this->title = 'SHG के पदाधिकारीयों एवं सदस्यों का विवरण ';
?>
<div class="subheader">
    <h1 class="subheader-title">
        <?= $this->title ?>
    </h1>
</div>
<p class="subheader mb-2">
    SHG का नाम : <?= $shg_model->name_of_shg ?>
</p>

<div class="subheader mb-3">
    कुल सदस्य : <?= $memberlimit ?><br>
    जोड़ें गये सदस्यों का विवरण : <?= $totalmember; ?>
    <h5 class="ml-2 subheader-title">
        <?php if ($memberlimit > $totalmember) { ?>
            <?php if ($app->checkAccess('shg', Yii::$app->user->identity, '/shg/member/update', ['shgid' => $shgid])) { ?>
                <a href="/shg/member/update?shgid=<?= $shgid ?>" class="float-right btn btn-info"><i class="fal fa-plus"> समूह के अन्य सदस्य जोड़ें </i></a>
            <?php } ?>
        <?php } ?>
    </h5>
</div>
<div class="subheader mb-3">
    <h5 class="subheader-title">
        <?php if ($totalmember and \common\models\dynamicdb\cbo_detail\RishtaShgMember::find()->where(['cbo_shg_id' => $shgid, 'status' => 1, 'suggest_wada_sakhi' => 1])->count() >= '0') { ?>
            <?php if ($app->checkAccess('shg', Yii::$app->user->identity, '/shg/member/suggestwadasakhi', ['shgid' => $shgid])) { ?>
                <a href="/shg/member/suggestwadasakhi?shgid=<?= $shgid ?>" class="btn btn-info"><i class="fal fa-lightbulb-o">अपने समूह से समूह सखी बनने योग्य सबसे उपयुक्त किसी एक सदस्य को मनोनीत/ चयन करें</i></a>
            <?php } ?>
        <?php } ?>
    </h5>
</div>
<?php foreach ($dataProvider->getModels() as $key => $model) {
    $household= DbtBeneficiaryHousehold::find()->where(['rishta_shg_member_id'=>$model->id])->one();
    $house_hold_id=0;
    if($household!=null){
      $house_hold_id=$household->id;  
    }
    
    ?>
    <div class="card mb-2">
        <div class="card-body">
            <h5 class="card-title">सदस्य का नाम : <?= $model->name ?></h5>
            <p class="card-text">सदस्य का मोबाइल न0 : <?= $model->mobile ?> <br>
                समूह में पद : <?= isset($model->shgrole->role) ? $model->shgrole->role_hindi : '' ?><br>
                परिवार के कुल सदस्य : <?= DbtBeneficiaryMember::find()->select(['id'])->where(['dbt_beneficiary_household_id' => $house_hold_id])->count() ?>
            </p>
            <small class="text-muted">
                <?php
                if ($app->checkAccess('shg', Yii::$app->user->identity, '/shg/member/verifychairperson', ['shgid' => $model->cbo_shg_id])) {
                    if ($model->role == \cbo\models\CboMasterMemberDesignation::SHG_CHAIRPERSON and $model->shg->verify_over_all == 0 and $model->shg->verify_chaire_person == 0 and $model->shg->getProrole() == 0) {
                        //                        echo Html::a('<span class="fal fa-check">सत्यापित करें</span>', ['/shg/member/verifychairperson?shgid=' . $model->cbo_shg_id . '&shg_member_id=' . $model->id], [
                        //                            'data-pjax' => "0",
                        //                            'class' => 'btn btn-sm btn-info float-left',
                        //                        ]) . ' ' . ' ';
                    }
                }
                ?>
                <?php
                if ($app->checkAccess('shg', Yii::$app->user->identity, '/shg/member/verifysecretary', ['shgid' => $model->cbo_shg_id])) {
                    if ($model->role == \cbo\models\CboMasterMemberDesignation::SHG_SECRETARY and $model->shg->verify_over_all == 0 and $model->shg->verify_chaire_person == 2 and $model->shg->verify_secretary == 0 and $model->shg->getSeorole() == 0) {
                        //                        echo Html::a('<span class="fal fa-check">सत्यापित करें</span>', ['/shg/member/verifysecretary?shgid=' . $model->cbo_shg_id . '&shg_member_id=' . $model->id], [
                        //                            'data-pjax' => "0",
                        //                            'class' => 'btn btn-sm btn-info float-left',
                        //                        ]) . ' ' . ' ';
                    }
                }
                ?>
                <?php
                if ($app->checkAccess('shg', Yii::$app->user->identity, '/shg/member/verifytreasurer', ['shgid' => $model->cbo_shg_id])) {
                    if ($model->role == \cbo\models\CboMasterMemberDesignation::SHG_TREASURER and $model->shg->verify_over_all == 0 and $model->shg->verify_secretary == 2 and $model->shg->verify_treasurer == 0 and $model->shg->getTrorole() == 0) {
                        //                        echo Html::a('<span class="fal fa-check">सत्यापित करें</span>', ['/shg/member/verifytreasurer?shgid=' . $model->cbo_shg_id . '&shg_member_id=' . $model->id], [
                        //                            'data-pjax' => "0",
                        //                            'class' => 'btn btn-sm btn-info float-left',
                        //                        ]) . ' ' . ' ';
                    }
                }
                ?>

                <?php if ($app->checkAccess('shg', Yii::$app->user->identity, '/shg/member/update', ['shgid' => $model->cbo_shg_id])) { ?>
                    <?php
                    '' .
                        Html::a('<span class="fal fa-edit">अपडेट करें</span>', ['/shg/member/update?shgid=' . $model->cbo_shg_id . '&shg_member_id=' . $model->id], [
                            'data-pjax' => "0",
                            'class' => 'btn btn-sm btn-info float-left',
                        ]) . ' ';
                    ?>
                <?php } ?>
                <?php
                if ($app->checkAccess('shg', Yii::$app->user->identity, '/shg/member/officebearers', ['shgid' => $model->cbo_shg_id])) {
                    if (!in_array($model->role, [0, 1, 2, 3])) {
                ?>

                        <?=
                        Html::a('<span class="fal fa-edit"> विशिष्ट सूचनाएँ</span>', ['/shg/member/officebearers?shgid=' . $model->cbo_shg_id . '&shg_member_id=' . $model->id], [
                            'data-pjax' => "0",
                            'class' => 'btn btn-sm btn-primary float-right',
                        ]) . ' ';
                        ?>
                <?php
                    }
                }
                ?>
                <?php
                if ($app->checkAccess('shg', Yii::$app->user->identity, '/shg/member/scheme', ['shgid' => $model->cbo_shg_id])) {
                ?>
                    <?php
                    echo Html::a('<span class="fal fa-star"> परिवार के सदस्य</span>', ['/shg/member/scheme?shgid=' . $model->cbo_shg_id . '&shg_member_id=' . $model->id], [
                        'data-pjax' => "0",
                        'class' => 'btn btn-sm btn-info float-left',
                    ]) . ' ' . ' ';

                    ?>
                <?php

                }
                ?>
            </small>
        </div>
    </div>
<?php } ?>