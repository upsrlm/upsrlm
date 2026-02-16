<?php

namespace common\models\dynamicdb\cbo_detail;

class CboDetailactiveRecord extends \yii\db\ActiveRecord {

    public static function getDb() {
        return \yii::$app->dbcbodetail;    //getModule('ccm2015')->db;
    }

}
