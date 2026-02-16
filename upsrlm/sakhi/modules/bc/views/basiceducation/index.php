<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\master\MasterRole;
use yii\widgets\ListView;
use yii\widgets\Pjax;

$app = new \sakhi\components\App();
$this->title = 'Basic Education/ शिक्षा';
?>
<div class="row margin-set">
    <div class="col-xl-12 p-0">
        <div id="panel-1" class="panel">
        <div class="card-title mb-0 p-2 border-bottom">
                <h2 class="mb-0 "><?= $this->title ?></h2>   
            </div>
            
            <div class="panel-container show">
                <div class="panel-content px-0 panel-content_cstm-2">
                    <?php
                    Pjax::begin([
                        'id' => 'grid-data',
                        'enablePushState' => FALSE,
                        'enableReplaceState' => FALSE,
                        'timeout' => false,
                    ]);
                    ?>
                    <?php
                    echo ListView::widget([
                        'dataProvider' => $dataProvider,
                        'pager' => [
                            'class' => \yii\bootstrap4\LinkPager::class,
                            'prevPageLabel' => '<span class="fal fa-arrow-left"></span>',
                            'nextPageLabel' => '<span class="fal fa-arrow-right"></span>',
                            'maxButtonCount' => 3,
                        ],
                        'itemView' => '_view',
                    ]);
                    ?>
                    <?php Pjax::end(); ?>  


                </div>
            </div>
        </div>
    </div>
</div>