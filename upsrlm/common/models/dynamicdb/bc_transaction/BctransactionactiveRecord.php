<?php

namespace common\models\dynamicdb\bc_transaction;

class BctransactionactiveRecord extends \yii\db\ActiveRecord {

    public static function getDb() {
        return \yii::$app->dbbctransaction;    //getModule('ccm2015')->db;
    }

}