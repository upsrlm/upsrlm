<?php

use kartik\tabs\TabsX;
use sakhi\widgets\ActiveMobileForm;
use yii\helpers\Html;

$this->title = 'FB';
?>
<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-container show">
                <div class="panel-content">

                    <?php
                    $items = [];
                    foreach ($model->section_option as $key => $value) {
                        $id = $key;
                        $name = $value;
                        $model_json = json_encode($model);
                        array_push($items, [
                            'label' => " $name",
                            'content' => $this->render('section' . $key, [
                                'model' => $model,
                                'column_id' => 'id_' . $id,
                                'name' => $name,
                                'section' => $id,
                            ])
                        ]);
                    }

                    echo TabsX::widget([
                        'items' => $items,
                        'position' => TabsX::POS_ABOVE,
                        'encodeLabels' => false
                    ]);
                    ?>


                </div>
            </div>
        </div>
    </div>