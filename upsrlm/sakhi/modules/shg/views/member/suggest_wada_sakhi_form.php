<?php

use yii\helpers\Html;
use yii\helpers\Url;
use sakhi\widgets\ActiveMobileForm;
use kartik\select2\Select2;
use kartik\widgets\DepDrop;
use kartik\date\DatePicker;
use kartik\widgets\FileInput;

$this->title = 'समूह सखी का सुझाव दें ';
$app = new \sakhi\components\App();
$option = [];
if ($model->samuh_sakhi_model != null) {
    $option = ['disabled' => true];
}
?>
<div class="card">
    <div class="col-lg-12">
        <div class="text-center"> हर समूह से ऐसा कोई एक सदस्य आवेदन कर सकते हैं, जिनके समूह सखी होने के योग्यता पर सभी अन्य सदस्यों को भरोसा व सहमति हो । एक <b>समूह सखी</b> को लगभग 10-25 समूहों के सदस्यों को, यानी कि लगभग 100 -300 समूह सदस्यों को स्वयं से जोड़ कर कार्य करना पढ़ सकता है । सखी को पूरे  ग्राम पंचायत में भ्रमण करना पड़ सकता है, और कभी कभी ब्लॉक ऑफ़िस भी जाना पड़ सकता है । इसलिए ये आवश्यक है कि वे भ्रमण के लिए व पूरा समय देने के लिए तैयार हों । हर समूह अपने सखी के उम्मीदवार के चयन करते समय इन बातों का ध्यान रखें ।
        </div>
    </div>
    <div class="col-lg-12">

        <div class='card-body'>
            <?php $form = ActiveMobileForm::begin(['id' => 'form-shg-suggest_wada_sakhi', 'enableAjaxValidation' => true, 'enableClientValidation' => false, 'options' => ['enctype' => 'multipart/form-data']]); ?>  
            <div class='card'>
                <div class="col-lg-12">    
                    <?= $form->field($model, 'sugest_wada_sakhi_member_id')->radioList($model->shg_members_option, ['separator' => '<br/>', 'itemOptions' => $option]); ?>  
                </div>
            </div> 

            <div class="form-group text-center">
                <?= $form->field($model, 'cbo_shg_id')->hiddenInput()->label('') ?> 
                <?php if ($app->checkAccess('shg', Yii::$app->user->identity, '/shg/member/suggestwadasakhi', ['shgid' => $model->cbo_shg_id]) and $model->samuh_sakhi_model == null) { ?>  
                    <?= Html::submitButton('सेव (save)', ['class' => 'btn btn-small btn-info', 'name' => 'save_b', 'id' => 'save_b']) ?>
                    <?php Html::submitButton('सबमिट (Submit)', ['class' => 'btn btn-small btn-info', 'name' => 'submit_b', 'id' => 'submit_b']) ?>   
                <?php } ?>
            </div>
            <?php ActiveMobileForm::end(); ?>
        </div>
    </div>    
</div>    
