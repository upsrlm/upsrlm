<?php

use yii\helpers\Html;

$app = new \sakhi\components\App();
$this->title = 'SHG धन प्राप्ति का विवरण';
?>
<div class="subheader">
    <h1 class="subheader-title">
        <?= $fundtype->fund_type ?>
    </h1>
    <?php if ($app->checkAccess('shg', Yii::$app->user->identity, '/shg/funds/update', ['shgid' => $shg_model->cbo_shg_id])) { ?>
        <a href="/shg/funds/update?shgid=<?= $shg_model->cbo_shg_id ?>&fund_type=<?= $fundtype->id ?>" class="btn btn-primary btn-sm float-right"><i class="fal fa-plus"></i></a>
    <?php } ?>
</div>
<div class="subheader mb-2">
    कुल प्राप्त राशि : रु <?= $total_amount_received ?>
</div>
<div class="subheader mb-2">
    प्राप्त राशि की संख्या : <?= $number_of_ammount_received ?>
</div>

<?php
if ($models) {
    foreach ($models as $key => $model) {
        ?>
        <div class="card mb-2">
            <div class="card-body">
                <h5 class="card-title">
                    <?php if ($app->checkAccess('shg', Yii::$app->user->identity, '/shg/funds/update', ['shgid' => $shg_model->cbo_shg_id])) { ?>
                        <?= $model->receivedfrom ?> <a href="/shg/funds/update?shgid=<?= $shg_model->cbo_shg_id ?>&shg_fund_received_id=<?= $model->id ?>&fund_type=<?= $fundtype->id ?>" class="btn btn-primary btn-sm float-right"><i class="fal fa-edit"></i></a>
                    <?php } ?>
                </h5>
                <p class="card-text">Amount Received : रु <?= $model->amount_received ?></p>
                <p class="card-text"><small class="text-muted">Date of Receipt : <?= $model->date_of_receipt ?></small></p>
            </div>
        </div>
        <?php
    }
}?>