<?php

namespace common\models\dynamicdb\support\master;

use Yii;

/**
 * This is the model class for table "master_stakeholder".
 *
 * @property int|null $stakeholder_category_code
 * @property string|null $stakeholder_category_name
 * @property string|null $current_status
 */
class MasterSakeholder extends \common\models\dynamicdb\support\SupportDetailactiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'technosys_master_stakeholder';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['stakeholder_category_code'], 'integer'],
            [['stakeholder_category_name'], 'string', 'max' => 150],
            [['current_status'], 'string', 'max' => 1],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'stakeholder_category_code' => 'Stakeholder Category Code',
            'stakeholder_category_name' => 'Stakeholder Category Name',
            'current_status' => 'Current Status',
        ];
    }

}
