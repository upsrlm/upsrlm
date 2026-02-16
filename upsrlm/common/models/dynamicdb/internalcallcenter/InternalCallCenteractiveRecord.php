<?php

namespace common\models\dynamicdb\internalcallcenter;

class InternalCallCenteractiveRecord extends \yii\db\ActiveRecord {

    public static function getDb() {
        return \yii::$app->dbinternalcallcenter;    //getModule('ccm2015')->db;
    }

}
