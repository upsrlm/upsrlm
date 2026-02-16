<?php

use yii\helpers\Html;
?>
<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-container show">
                <div class="subheader" style="text-align: center">
                    <h1 class="subheader-title">
                        हाई स्पीड इंटरनेट परियोजना

                    </h1>
                </div>
                <div style="text-align: center">

                    <h6>
                        प्रूफ ऑफ़ कॉन्सेप्ट (राउंड 2) की प्रगति तथा सभी पायलट ग्राम पंचायतों में मॉडल सिस्टम का बेंचमार्क स्थिति का निर्धारण
                    </h6>
                </div>
                <div class="panel-content" id="scnearioform">
                    <?php
                    echo $this->render('section' . $model->fd_section, [
                        'model' => $model,
                        $model->fd_section,
                        'section' => $model->fd_section,
                        'name' => $model->fd_section_name,
                        'action_url' => "/online/fb/form-section?section=" . $model->fd_section . "&fd_section_qno=" . $model->fd_section_qno
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
<?php
$style = <<< CSS
 .subheader {
  margin-bottom: 0.2rem !important;
}
CSS;
$this->registerCss($style);
?>
<?php
$js = <<<JS
    $(document).ready(function() { 
        $(".play").on("click", function() {
            try {
            if($(this).attr('toggle')=='start'){
               $(this).attr('toggle','stop');
               new Audio($(this).attr('asrc')).play();
            }
            if($(this).attr('toggle')=='stop'){
               new Audio($(this).attr('asrc')).pause();
            }
            }
            catch(err) {
            }
         });   
    
    });         
JS;
$this->registerJs($js);
?>
