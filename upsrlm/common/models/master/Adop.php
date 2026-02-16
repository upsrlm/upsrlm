<?php

namespace common\models\master;

use Yii;

/**
 * This is the model class for table "adop".
 *
 * @property int $id
 * @property int|null $sr_no
 * @property string|null $district
 * @property string|null $block
 * @property int|null $block_code
 * @property string|null $ado_nam
 * @property string|null $mobile_number
 * @property string|null $alt_mobile_number
 * @property string|null $whatsapp
 * @property string|null $alt_whatsapp
 * @property int|null $user_id
 * @property int|null $role
 */
class Adop extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ado_contact_details_04_12_2023';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('dbcbo');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sr_no', 'block_code', 'user_id', 'role'], 'integer'],
            [['district'], 'string', 'max' => 19],
            [['block'], 'string', 'max' => 37],
            [['ado_nam'], 'string', 'max' => 58],
            [['mobile_number'], 'string', 'max' => 13],
            [['alt_mobile_number'], 'string', 'max' => 17],
            [['whatsapp', 'alt_whatsapp'], 'string', 'max' => 12],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sr_no' => 'Sr No',
            'district' => 'District',
            'block' => 'Block',
            'block_code' => 'Block Code',
            'ado_nam' => 'Ado Nam',
            'mobile_number' => 'Mobile Number',
            'alt_mobile_number' => 'Alt Mobile Number',
            'whatsapp' => 'Whatsapp',
            'alt_whatsapp' => 'Alt Whatsapp',
            'user_id' => 'User ID',
            'role' => 'Role',
        ];
    }
}
