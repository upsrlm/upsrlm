<?php

namespace bc\models\master;

use Yii;

/**
 * This is the model class for table "block_bmmu".
 *
 * @property int $id
 * @property int|null $block_code
 * @property string|null $block_name
 * @property string|null $district_name
 * @property string|null $bmmu
 * @property int|null $updated_at
 */
class BlockBmmu extends \bc\modules\selection\models\BcactiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'block_bmmu';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb() {
        return Yii::$app->get('dbbc');
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['block_code', 'updated_at'], 'integer'],
            [['bmmu'], 'string'],
            [['block_name', 'district_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'block_code' => 'Block Code',
            'block_name' => 'Block Name',
            'district_name' => 'District Name',
            'bmmu' => 'Bmmu',
            'updated_at' => 'Updated At',
        ];
    }

}
