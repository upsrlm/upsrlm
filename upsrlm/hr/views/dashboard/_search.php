<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\widgets\Pjax;
use kartik\widgets\DepDrop;
use kartik\widgets\Select2;
use common\models\base\GenralModel;
use common\models\User;
use common\models\master\MasterRole;

$request = explode('?', Yii::$app->request->url);
$request_url = rtrim($request[0], '/');
//echo $request_url;
?>
<div class="row">
    <div class="col-xl-2 col-md-4 mb-2">
    <?php

echo $form->field($model, 'role')->widget(Select2::classname(), [
    'data' => [MasterRole::ROLE_BMMU => 'BMMU', MasterRole::ROLE_DMMU => 'DMMU', MasterRole::ROLE_SMMU => 'SMMU'],
    'options' => ['placeholder' => 'Select role', 'style' => 'width:200px'],
    'pluginOptions' => [
        'allowClear' => true
    ],
])->label('Role');
?>
    </div>
    <div class="col-xl-3 col-md-6">
    <?= Html::submitButton('Search', ['class' => 'btn  btn-sm btn-info ', 'style' => 'margin-left:10px; padding:7px 20px;']) ?>
    </div>
</div>


<?= $form->field($model, 'page')->hiddenInput()->label(false) ?>

<?php

$css = <<<cs
 .select2-selection__rendered {
    width: 200px !important;
}
cs;
$this->registerCss($css);
?>


