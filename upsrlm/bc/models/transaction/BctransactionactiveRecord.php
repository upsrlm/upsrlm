<?php

namespace bc\models\transaction;

class BctransactionactiveRecord extends \yii\db\ActiveRecord {

    public static function getDb() {
        return \yii::$app->dbbctransaction;    //getModule('ccm2015')->db;
    }

}