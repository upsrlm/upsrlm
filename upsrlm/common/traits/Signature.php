<?php

namespace common\traits;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
/**
 * @author Habibur Rahman <rahman.kld@gmail.com>
 */
trait Signature 
{

    public function behaviors()
    {
        return [
            [
                'class' => BlameableBehavior::className(),
                'value' => \Yii::$app->request->isConsoleRequest ? 0 : NULL,
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
            ],
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' =>function(){
                    return time();
                },
            ],
        ];
    }
}
