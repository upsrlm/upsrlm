<?php

namespace bc\models;

class BcactiveRecord extends \yii\db\ActiveRecord {

    public static function getDb() {
        return \yii::$app->dbbc;    //getModule('ccm2015')->db;
    }

}
