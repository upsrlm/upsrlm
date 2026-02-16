<?php
$this->title = 'Call Detail';

?>

<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-container show">
                <div class="panel-content">
                    <?php
                    if ($model->rishtashgmemberdetail) {
                        echo $this->render('@dbtcallcenter/modules/platform/views/default/_memberprofile', ['model' => $model->rishtashgmemberdetail]);
                    }
                    ?>

                    <?= $this->render('@dbtcallcenter/modules/platform/views/default/_callhistory', ['dataProvider' => $dataProvider]); ?>
                </div>
            </div>
        </div>
    </div>
</div>