<?php

use yii\helpers\Html;

//$this->title = 'Update CLF/ क्लस्टर लेवल फेडरेशन/ क्लस्टर स्तरीय संकुल : ' . $model->name_of_clf;
//$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">

            <div class="panel-container show">
                <div class="panel-content">
                    <h1>सम्बद्ध VOs को लिंक करें</h1>

                    <?=
                    $this->render('_addvoform', [
                        'model' => $model,
                    ])
                    ?>

                    <h1>सम्बद्ध VOs</h1>
                    <?php
                    if (isset($model->clf_model->vos)) {
                        foreach ($model->clf_model->vos as $vo) {
                            ?>
                            <div class="col-md-12 col-12">
                                <h6 class="text-primary"><?= $vo->name_of_vo ?> </h6>

                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>     
            </div>      
        </div>
    </div>      
</div>