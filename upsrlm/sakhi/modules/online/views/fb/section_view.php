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
                <div class="panel-content">
                    <?php
                    echo $this->render('section' . $model->fd_section . '_view', [
                        'model' => $model->fb_demand_side_model,
                        'name' => $model->fd_section_name,
                    ])
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$style = <<< CSS
 .subheader {
  margin-bottom: 0.2rem !important;
}
CSS;
$this->registerCss($style);
?>

