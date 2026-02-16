<?php

use yii\helpers\Html;
?>

<div class="subheader">
    <h1 class="subheader-title">
        पदाधिकारीयों एवं सदस्यों का विवरण  
        <?= Html::a('<span class="fal fa-times"></span>', ['/shg/default/removemember?shgid=' . $model->shg_member_model->cbo_shg_id . '&shgmemberid=' . $model->shg_member_model->id], [
                                    'class' => '',
                                    'data-pjax' => "0",
                                    'class' => 'btn btn-sm btn-danger float-right',
                                    'data' => [
                                        'confirm' => 'क्या आप निश्चित रूप से इस सदस्य को हटा रहे हैं ?',
                                        'method' => 'post',
                                    ],
                        ]); ?>   
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