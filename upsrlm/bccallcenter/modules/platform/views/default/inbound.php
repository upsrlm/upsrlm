<?php

use yii\widgets\Pjax;

$this->title = 'Today progress';
$inbounduser = \common\models\dynamicdb\internalcallcenter\platform\CallingUserInbound::find()->where(['user_id' => Yii::$app->user->identity->id])->one();
$onbreak = 0;
$onbreak_title = 'Start Reciving Call';
$breakbtnclass = 'btn btn-info mr-3';
if ($inbounduser && $inbounduser->sarv_agent_id) {
    if ($inbounduser->sarv_status == 1) {
        $onbreak = 1;
        $onbreak_title = 'Stop Reciving Call';
        $breakbtnclass = 'btn btn-warning mr-3';
    }
}
?>

<div class="row" id="callsbox">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">
            
            <div class="panel-hdr">
                <h2>
                    <?= $this->title ?>
                </h2>
                <div class="panel-toolbar">
                    <?php
                    if ($inbounduser && $inbounduser->sarv_agent_id) {
                    ?>
                        <a href="/platform/default/inboundbreak?status=<?= !$onbreak ?>" class="<?= $breakbtnclass ?>"><?= $onbreak_title ?></a>
                    <?php } ?>
                    <button id="reloads" class="btn btn-primary"><i class="fal fa-refresh"></i>Reload Calls</button>
                </div>
            </div>
            <div class="panel-container show">
                <?php echo $this->render('_tiles_ibd', ['model' => []]);?>
                <div class="panel-content" id="inbound_content">
                    <?= $this->render('_inbound_content', ['dataProvider' => $dataProvider,]) ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$js = <<<JS
    let queryselected = false;
    $("#inbound_content").load("/platform/default/inbound");      
    const targetNode = document.querySelector("#inbound_content");
    const observerOptions = {
        childList: true,
        attributes: true,
        subtree: true
    }

    const observer = new MutationObserver(function(mutations, observer) {
        if(queryselected==false){
            initial = setTimeout(function(){
                $("#inbound_content").load("/platform/default/inbound");
            }, 7000);
        }
    });
        
    observer.observe(targetNode, observerOptions);

JS;
$this->registerjs($js);
?>