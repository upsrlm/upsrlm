<?php

namespace common\models\dynamicdb\support;

class SupportDetailactiveRecord extends \yii\db\ActiveRecord {

    public static function getDb() {
        return \yii::$app->dbbc;    //getModule('ccm2015')->db;
    }

}
