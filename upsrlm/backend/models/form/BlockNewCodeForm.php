<?php

namespace backend\models\form;

use Yii;
use yii\helpers\ArrayHelper;
use yii\base\Model;
use common\models\base\GenralModel;
use common\models\RelationUserDistrict;
use common\models\User;
use common\models\master\MasterRole;

/**
 * BlockNewCodeForm is the model behind the User
 * @author Habibur Rahman <rahman.kld@gmail.com>
 */
class BlockNewCodeForm extends Model {

    public $id;
    public $new_block_code;
    public $new_block_name;
    public $block_model1;
    public $block_model2;

    public function __construct($block_model) {
        $this->block_model1 = $block_model;
        $this->new_block_code = $this->block_model1->new_block_code;
        $this->new_block_name = $this->block_model1->new_block_name;
        $this->block_model2 = \bc\models\master\MasterBlock::findOne(['block_code' => $this->block_model1->block_code]);
    }

    /**
     * @return array the validation rules.
     */
    public function rules() {
        return [
            [['new_block_code', 'new_block_name'], 'required', 'message' => 'Is requred'],
            [['new_block_code', 'new_block_name'], 'trim'],
            
            [['new_block_code'], 'unique', 'when' => function ($model, $attribute) {
                    return $this->block_model1->$attribute != $model->$attribute;
                }, 'targetClass' => \common\models\master\MasterBlock::className(), 'message' => 'This New List Block Code has already been taken'],
            [['new_block_code'], 'integer'],
            [['new_block_name'], 'string', 'max' => 50],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'new_block_code' => 'New List Block Code',
            'new_block_name' => 'New List Block Name',
        ];
    }

    public function save() {
        if (!$this->validate()) {
            return false;
        }
        $this->block_model1->new_block_code = $this->new_block_code;
        $this->block_model1->new_block_name = $this->new_block_name;
        $this->block_model2->new_block_code = $this->new_block_code;
        $this->block_model2->new_block_name = $this->new_block_name;
        if ($this->block_model1->update() and $this->block_model2->update()) {
            return $this;
        }
        return $this;
    }

}
