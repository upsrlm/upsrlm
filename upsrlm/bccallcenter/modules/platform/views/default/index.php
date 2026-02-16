<?php

use yii\widgets\Pjax;
use yii\bootstrap4\Modal;

$this->title = 'Today Progress';
?>


<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>
                    <?= $this->title ?>
                </h2>
                <div class="panel-toolbar">

                    <button class="btn btn-panel waves-effect waves-themed" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                    <button class="btn btn-panel waves-effect waves-themed" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                </div>
            </div>
            <div class="panel-container show">
                <div class="panel-content">
                    <?php echo $this->render('_tiles', ['model' => $searchModel]);?>
                    <?php
                    Pjax::begin([
                        'id' => 'grid-data',
                        'enablePushState' => FALSE,
                        'enableReplaceState' => FALSE,
                        'timeout' => false,
                    ]);
                    ?>
                    <?php //echo $this->render('_search', ['model' => $searchModel]); 
                    ?>
                    <?php if ($prioritydataProvider->models) : ?>
                        <h2>Priority Calls</h2>
                        <?= $this->render('_maingrid', ['dataProvider' => $prioritydataProvider, 'scheaduletimevisible' => true]) ?>
                        <hr>
                    <?php endif; ?>

                    <?php
                    Modal::begin([
                        'headerOptions' => ['id' => 'modalHeader'],
                        'id' => 'modal',
                        'size' => 'modal-xl',
                        'clientOptions' => [
                            'backdrop' => 'static',
                            'keyboard' => false,
                        ],
                    ]);
                    echo "<div id='imagecontent'></div>";
                    Modal::end();
                    ?>     
                    <?php Pjax::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$css = <<<cs
 @media (min-width: 992px) {
  .modal-dialog {
    max-width: 90% !important;
  }
  .modal-dialog table th, .modal-dialog table td {
        padding: 0rem !important;
  } 
      
}
cs;
$this->registerCss($css);
?>
<?php
$js = <<<JS
$(function () {        
    $('.popb').click(function(){
        $('#imagecontent').html('');
        $('#modal').modal('show')
         .find('#imagecontent')
         .load($(this).attr('value'));
          document.getElementById('modalHeader').innerHTML = '' + $(this).attr('title') + '<i class="fal fa-times glyphicon glyphicon-remove icon-arrow-right pull-right" data-dismiss="modal" style="cursor : pointer;color:red"></i>';     
        });
});  
        
JS;
$this->registerJs($js);
?> 
<?php
$this->registerJs(
        '
function init_click_handlers(){
jQuery.noConflict();
  $(".popb").click(function(e) {
             $("#imagecontent").html("");
            var fID = $(this).closest("tr").data("key");
            $("#modal").modal("show")
         .find("#imagecontent")
         .load($(this).attr("value"));
        });
       

}

init_click_handlers(); //first run
$("#grid-data").on("pjax:success", function() {
  init_click_handlers(); //reactivate links in grid after pjax update
});

');
?>