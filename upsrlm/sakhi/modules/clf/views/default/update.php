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
                    <h1><?= Html::encode($this->title) ?></h1>

                    <?=
                    $this->render('_basicform', [
                        'model' => $model,
                    ])
                    ?>
                </div>
            </div>    

        </div>
    </div>
</div>