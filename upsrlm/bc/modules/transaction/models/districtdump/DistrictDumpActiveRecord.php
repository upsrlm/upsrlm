<?php

namespace bc\modules\transaction\models\districtdump;

use Yii;

class DistrictDumpActiveRecord extends \yii\db\ActiveRecord
{
    public static $tablename; // bc_transaction_1

    /**
     * Dynamic District DB 
     *
     * @return void
     */
    public static function getDb()
    {
        return Yii::$app->getModule('transaction')->bctransactiondistrictbcdb;
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return static::$tablename;
    }

    /**
     * Set Dynamic Table Before Initilization
     *
     * @param [type] $tablename
     * @return void
     */
    public static function setTableName($tablename)
    {
        return static::$tablename = $tablename;
    }
}
