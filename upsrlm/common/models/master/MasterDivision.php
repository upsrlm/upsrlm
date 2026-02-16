<?php

namespace common\models\master;

use Yii;

/**
 * This is the model class for table "master_division".
 *
 * @property int $id
 * @property int $division_code
 * @property string $division_name
 * @property string $division_headquarter
 */
class MasterDivision extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'master_division';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['division_code', 'division_name', 'division_headquarter'], 'required'],
            [['division_code'], 'integer'],
            [['division_name'], 'string', 'max' => 150],
            [['division_headquarter'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'division_code' => 'Division Code',
            'division_name' => 'Division Name',
            'division_headquarter' => 'Division Headquarter',
        ];
    }
    public function getDistrict() {
        return $this->hasMany(MasterDistrict::className(), ['division_code' => 'division_code'])->orderBy('district_name asc');
    }
}
