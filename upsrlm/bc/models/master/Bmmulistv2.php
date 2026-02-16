<?php

namespace bc\models\master;

use Yii;

/**
 * This is the model class for table "bmmulistv2".
 *
 * @property int $s_no
 * @property string|null $District
 * @property string|null $Block
 * @property string|null $Professional_Name
 * @property string|null $Professional_Designation
 * @property string|null $Contact_No
 * @property int $status
 */
class Bmmulistv2 extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bmmulistv2';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['s_no'], 'required'],
            [['s_no', 'status'], 'integer'],
            [['District'], 'string', 'max' => 19],
            [['Block', 'Professional_Name'], 'string', 'max' => 29],
            [['Professional_Designation'], 'string', 'max' => 17],
            [['Contact_No'], 'string', 'max' => 23],
            [['s_no'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            's_no' => 'S No',
            'District' => 'District',
            'Block' => 'Block',
            'Professional_Name' => 'Professional Name',
            'Professional_Designation' => 'Professional Designation',
            'Contact_No' => 'Contact No',
            'status' => 'Status',
        ];
    }
}
