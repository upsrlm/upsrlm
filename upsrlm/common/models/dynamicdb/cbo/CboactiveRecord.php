<?php

namespace common\models\dynamicdb\cbo;

class CboactiveRecord extends \yii\db\ActiveRecord {

    public static function getDb() {
        return \yii::$app->dbcbo;    //getModule('ccm2015')->db;
    }

}
