<?php

use yii\widgets\Pjax;

$this->title = 'Calling Platform';
?>

<?php
Pjax::begin([
    'id' => 'grid-data',
    'enablePushState' => FALSE,
    'enableReplaceState' => FALSE,
    'timeout' => false,
]);
?>
<?= $this->render('_search', ['model' => $searchModel]); ?>

<?= $this->render('_tiles', ['model' => $searchModel]); ?>

<div class="row">
    <div class="col-xl-9">
        <?= $this->render('_chart', ['model' => $searchModel]); ?>
    </div>
    <div class="col-xl-3">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>Scneario Coverage </h2>
            </div>
            <div class="panel-container show">
                <div class="panel-content">
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-3">
        <?= $this->render('_district_covered', ['model' => $searchModel]); ?>
    </div>
    <div class="col-xl-9">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>Total Completed Calls</h2>
            </div>
            <div class="panel-container show">
                <div class="panel-content">
                    <?= $this->render('_maingrid', ['dataProvider' => $dataProvider]) ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php Pjax::end(); ?>