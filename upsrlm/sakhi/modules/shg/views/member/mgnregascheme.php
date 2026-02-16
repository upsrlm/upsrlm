<?php

use yii\helpers\Html;

$this->title = 'मनरेगा योजना आवेदन पत्र';
?>

<div class="subheader">
    <h1 class="subheader-title">
        <?= $this->title ?>
    </h1>
</div>


<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-container show">
                <div class="panel-content">
                    <?php
                    if ($model->scheme_model->status == 1 || $model->scheme_model->status == 0) {
                        if ($model->scheme_model->current_mgnrega_beneficiary_interested_work == 2) {
                            echo $this->render('_mgnregascheme_view', ['model' => $model->scheme_model]);
                        } else {
                            if ($model->scenario == 'formcomplete') {
                                echo $this->render('_mgnregascheme_submit_form', [
                                    'model' => $model,
                                ]);
                            } else if ($model->scenario == 'setp_current') {
                                echo $this->render('_mgnregascheme_current_form', [
                                    'model' => $model,
                                ]);
                            } else {
                                echo $this->render('_mgnregaschemeform', [
                                    'model' => $model,
                                ]);
                            }
                        }
                    } else {
                        echo $this->render('_mgnregascheme_view', ['model' => $model->scheme_model]);
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>