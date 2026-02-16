<?php

namespace bc\modules\transaction\models\dump;

use Yii;

class DumpActiveRecord extends \yii\db\ActiveRecord
{
    /**
     * Database Connection
     *
     * @return void
     */
    public static function getDb()
    {
        return Yii::$app->getModule('transaction')->bctransactiondump;
    }
}
