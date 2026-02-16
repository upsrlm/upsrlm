<?php

/* @var $this \yii\web\View */
/* @var $content string */

echo $this->renderFile(
    Yii::getAlias('@common/themes/smartadmin/views/layouts/main_cbo.php'),
    ['content' => $content]
);
