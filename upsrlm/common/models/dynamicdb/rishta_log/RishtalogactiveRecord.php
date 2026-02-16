<?php

namespace common\models\dynamicdb\rishta_log;

class RishtalogactiveRecord extends \yii\db\ActiveRecord {

    public static function getDb() {
        return \yii::$app->dbrishtalog;
    }

}
