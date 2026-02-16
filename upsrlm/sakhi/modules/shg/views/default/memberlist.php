<?php
use yii\helpers\Html;
?>
<div class="subheader">
    <h1 class="subheader-title">
        पदाधिकारीयों एवं सदस्यों का विवरण     
    </h1>
</div>
<div class="subheader mb-2">
    कुल सदस्य : <?=$memberlimit ?>
</div>
<div class="subheader mb-3">
    सदस्यों का विवरण : <?=$totalmember;?>
    <h5 class="subheader-title">
        <?php if($memberlimit >$totalmember){ ?> <a href="/shg/default/addmember?shgid=<?= $shgid ?>" class="float-right btn btn-info"><i class="fal fa-plus"></i></a> <?php }?>
    </h5>
</div>
<?php
foreach($dataProvider->getModels() as $key=>$model){ ?>
    <div class="card mb-2">
        <div class="card-body">
            <h5 class="card-title">सदस्य का नाम : <?=$model->name?></h5>
            <p class="card-text">सदस्य का मोबाइल न0 :  <?=$model->mobile?> <br>
            समूह में पद : <?=isset($model->officebearesrs->shgrole->role) ?$model->officebearesrs->shgrole->role :'' ?>
            </p>    
            <small class="text-muted">
                <?= Html::a('<span class="fal fa-edit"></span>', ['/shg/default/updatemember?shgid=' . $model->cbo_shg_id . '&shgmemberid=' . $model->id], [
                                    'data-pjax' => "0",
                                    'class' => 'btn btn-sm btn-info float-left',
                                ]) . ' '; ?>

                <?= Html::a('<span class="fal fa-edit"> विशिष्ट सूचनाएँ</span>', ['/shg/default/officebearers?shgid=' . $model->cbo_shg_id . '&shgmemberid=' . $model->id], [
                    'data-pjax' => "0",
                    'class' => 'btn btn-sm btn-primary float-right',
                ]) . ' ';
                ?>
                </small>
        </div>
    </div>
<?php }?>
