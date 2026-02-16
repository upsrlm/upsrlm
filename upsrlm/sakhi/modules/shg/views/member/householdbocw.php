<?php

use yii\helpers\Html;

$this->title = 'बीओसीडब्ल्यू पंजीकरण संख्या';
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
                    if ($model->household_model->bocw ==1) {
                        echo $this->render('_householdbocw_view', ['model' => $model->household_model]);
                    } else {
                        echo $this->render('_householdbocw_form', [
                            'model' => $model,
                        ]);
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>