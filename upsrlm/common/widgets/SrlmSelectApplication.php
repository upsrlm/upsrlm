<?php

namespace common\widgets;

use Yii;

/**
 * @author Habibur Rahman <rahman.kld@gmail.com>
 */
class SrlmSelectApplication extends \yii\base\Widget {
    public $model;
    /**
     * {@inheritdoc}
     */
    public function run() {
      return $this->render('selectapplication', [
                    'model' => $this->model,
        ]);  
    }

}
