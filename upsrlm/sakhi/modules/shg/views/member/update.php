<?php

use yii\helpers\Html;
?>

<div class="subheader">
    <h1 class="subheader-title">
        पदाधिकारीयों एवं सदस्यों का विवरण
        <?php if ($model->shg_member_model->id && !isset($model->shg_member_model->user_id)) {
        ?>
            <?= \sakhi\widgets\RemoveButton::widget([
                'options' => [
                    'value' => '/shg/member/remove?shgid=' . $model->shg_member_model->cbo_shg_id . '&shg_member_id=' . $model->shg_member_model->id,
                ],
            ]); ?>
        <?php  } ?>
    </h1>
</div>


<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-container show">
                <div class="panel-content">
                    <?=
                    $this->render('_memberform', [
                        'model' => $model,
                    ])
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>