<?php

namespace bc\modules\selection\models\form;

use Yii;
use yii\base\Model;
use common\models\User;
use common\models\base\GenralModel;
use bc\models\srlm\SrlmBcApplication;
use yii\helpers\ArrayHelper;

/**
 * DowloadCSVForm
 */
class DownloadCSVForm extends Model {

    public $start;
    public $end;
    public $total;

    public function init() {
        
    }

    /**
     * @return array the validation rules.
     */
    public function rules() {
        return [
            [['start', 'end'], 'required'],
            [['start', 'end'], 'integer'],
            [['start', 'end'], 'integer'],
            ['end', 'compare', 'compareAttribute' => 'start', 'operator' => '>=', 'message' => 'End point cant not be less than start point.'],
            ['start', 'integer', 'min' => 1, 'message' => 'Start point must be be greater than 0'],
            ['end', 'integer', 'min' => 1, 'message' => 'Start point must be be greater than 0']
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels() {
        return [
            'start' => 'Start point',
            'end' => 'End point',
        ];
    }

}
