<?php

use yii\helpers\Html;
?>
<div class="row margin-set">
    <div class="col-xl-12 p-0 clf-form">
        <div class="panel panel-default">
            <div class='panel-body p-0'>
                <div class="panel-content" id="scnearioform">
                    <?php
                    echo $this->render('group' . $model->group, [
                        'model' => $model,
                        'title' => $model->title,
                        'action_url' => "/bc/grievance/report?bcid=" . $model->bc_model->id . "&group=" . $model->group
                    ])
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$js = <<<JS

function runformupdatefunction(data){
    
}
JS;
$this->registerjs($js);
?>


