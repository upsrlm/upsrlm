<?php

namespace common\models\dynamicdb\dbt;

class DbtactiveRecord extends \yii\db\ActiveRecord {

    public static function getDb() {
        return \yii::$app->dbcbo;
        //return \yii::$app->dbdbt;    //getModule('ccm2015')->db;
    }

}
