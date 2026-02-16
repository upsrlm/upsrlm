<?php

namespace bc\modules\selection\models\form;

use Yii;
use yii\base\Model;
use common\models\User;
use bc\modules\selection\models\BcMissing;
use bc\modules\selection\models\SrlmBcApplication;
use bc\modules\selection\models\BcUnwillingRsetis;
use yii\helpers\ArrayHelper;
use yii\db\Expression;

class MissingCommentForm extends Model {

    public $id;
    public $comment;
    public $bc_missing_model;

    public function __construct($bc_missing_model) {
        $this->bc_missing_model = $bc_missing_model;
        if ($this->bc_missing_model != NULL) {
            $this->comment = $this->bc_missing_model->comment;
        }
    }

    public function rules() {
        return [
            [['comment'], 'required', 'message' => 'Is required'],
            [['comment'], 'string', 'max' => 500],
        ];
    }

    public function attributeLabels() {
        return [
            'id' => 'ID',
            'comment' => 'Comment',
        ];
    }

    public function save() {

        $this->bc_missing_model->setAttributes([
            'comment' => $this->comment,
        ]);

        if ($this->bc_missing_model->save()) {

            return $this->bc_missing_model;
        } else {

            return false;
        }
    }

}
