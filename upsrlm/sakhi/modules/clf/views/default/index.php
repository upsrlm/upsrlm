<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use common\models\master\MasterRole;
use cbo\models\CboClf;
use yii\widgets\ListView;

$this->title = "क्लस्टर लेवल फेडरेशन";
$this->params['breadcrumbs'][] = $this->title;
?>
<h1 ><?= $this->title ?></h1>
<div class="panel panel-default">
    <div class='panel-body'>
        <?php
        echo ListView::widget([
            'dataProvider' => $dataProvider,
            'summary' => 'कुल {totalCount} CLF। ',
            'itemView' => '_view',
        ]);
        ?>

    </div>
</div>
