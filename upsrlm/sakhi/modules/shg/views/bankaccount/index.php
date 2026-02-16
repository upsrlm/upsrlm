<?php

use yii\helpers\Html;

$this->title = 'SHG बैंक खातों का विवरण';
$app = new \sakhi\components\App();
?>
<div class="subheader mb-2">
    <h1 class="subheader-title">
        बैंक खातों का विवरण   
        <?php if ($app->checkAccess('shg', Yii::$app->user->identity, '/shg/bankaccount/update', ['shgid' => $shgid])) { ?>
            <a href="/shg/bankaccount/update?shgid=<?= $shgid ?>" class="text-right btn btn-info btn-sm float-right"><i class="fal fa-plus"></i></a>
        <?php } ?>
    </h1>
</div>
जोड़े गए बैंक : <?= $totalbank; ?>
<?php foreach ($dataProvider->getModels() as $key => $model) { ?>
    <div class="card mb-2">
        <div class="card-body">
            <h5 class="card-title">बैंक का नाम : <?= $model->name_of_bank ?></h5>
            <p class="card-text">बैंक का खाता संख्या :  <?= $model->bank_account_no_of_the_shg ?> <br>
            </p>    
            <small class="text-muted">
                <?php if ($app->checkAccess('shg', Yii::$app->user->identity, '/shg/bankaccount/update', ['shgid' => $model->cbo_shg_id])) { ?>  
                    <?=
                    Html::a('<span class="fal fa-edit"> बैंक विवरण अपडेट करें </span>', ['/shg/bankaccount/update?shgid=' . $model->cbo_shg_id . '&shg_bank_id=' . $model->id], [
                        'data-pjax' => "0",
                        'class' => 'btn btn-sm btn-info float-right',
                    ]) . ' ';
                    ?>
                <?php } ?>
            </small>
        </div>
    </div>
<?php } ?>
