<?php

namespace bc\modules\transaction\models\summary;

use Yii;

class SummaryActiveRecord extends \yii\db\ActiveRecord
{
    public static function getDb()
    {
        return Yii::$app->getModule('transaction')->bctransactionsummary;
    }
}
