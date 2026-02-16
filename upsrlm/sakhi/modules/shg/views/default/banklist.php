<?php
use yii\helpers\Html;
?>
<div class="subheader mb-2">
    <h1 class="subheader-title">
    बैंक खातों का विवरण   
        <a href="/shg/default/bankdetail?shgid=<?= $shg_model->id ?>" class="text-right btn btn-info btn-sm float-right"><i class="fal fa-plus"></i></a>
    </h1>
</div>
जोड़े गए बैंक : <?=$totalbank;?>
<?php
foreach($dataProvider->getModels() as $key=>$model){ ?>
    <div class="card mb-2">
        <div class="card-body">
            <h5 class="card-title">बैंक का नाम : <?=$model->name_of_bank?></h5>
            <p class="card-text">बैंक का खाता संख्या :  <?=$model->bank_account_no_of_the_shg?> <br>
            </p>    
            <small class="text-muted">
                <?= Html::a('<span class="fal fa-edit"> बैंक विवरण अपडेट करें </span>', ['/shg/default/bankdetail?shgid=' . $model->cbo_shg_id . '&bankid=' . $model->id], [
                                    'data-pjax' => "0",
                                    'class' => 'btn btn-sm btn-info float-right',
                                ]) . ' ';
                ?>
                </small>
        </div>
    </div>
<?php }?>
