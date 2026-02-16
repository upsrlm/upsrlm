<?php

namespace common\models\dynamicdb\mopup;

class MopupactiveRecord extends \yii\db\ActiveRecord {

    public static function getDb() {
        return \yii::$app->dbmopuplog;
    }

}
