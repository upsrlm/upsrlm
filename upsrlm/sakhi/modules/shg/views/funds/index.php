<?php

use yii\helpers\Html;

$app = new \sakhi\components\App();
$this->title = 'SHG धन प्राप्ति का विवरण';
?>
<div class="subheader mb-3">
    <h1 class="subheader-title">
        धन प्राप्ति का विवरण   
    </h1>
</div>
<?php
if ($fundtypes) {
    foreach ($fundtypes as $key => $fundtype) {
        ?>
        <?php if ($app->checkAccess('shg', Yii::$app->user->identity, '/shg/funds/fundlist', ['shgid' => $shg_model->cbo_shg_id])) { ?>
            <a href="/shg/funds/fundlist?shgid=<?= $shg_model->cbo_shg_id ?>&fund_id=<?= $key ?>">
                <div class="card bg-primary text-white text-center p-3 mb-2">
                    <blockquote class="blockquote mb-0">
                        <p><?= $fundtype ?></p>
                    </blockquote>
                </div>
            </a>
        <?php } ?>
        <?php
    }
}?>