<?php

namespace bc\models;

use Yii;

/**
 * This is the model class for table "bc_goverment_report_block".
 *
 * @property int $id
 * @property string|null $date
 * @property int $state_code
 * @property string $state_name
 * @property int|null $division_code
 * @property string|null $division_name
 * @property int|null $district_code
 * @property string|null $district_name
 * @property int|null $block_code
 * @property string|null $block_name
 * @property int $operational
 * @property int $trained_and_certified
 * @property string $last_updated_on
 */
class BcGovermentReportBlock extends BcactiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'bc_goverment_report_block';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['date', 'last_updated_on'], 'safe'],
            [['state_code', 'division_code', 'district_code', 'block_code', 'operational', 'trained_and_certified'], 'integer'],
            [['last_updated_on'], 'safe'],
            [['state_name'], 'string', 'max' => 100],
            [['division_name'], 'string', 'max' => 155],
            [['district_name', 'block_name'], 'string', 'max' => 150],
            [['date', 'block_code'], 'unique', 'targetAttribute' => ['date', 'block_code']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'date' => 'Date',
            'state_code' => 'State Code',
            'state_name' => 'State Name',
            'division_code' => 'Division Code',
            'division_name' => 'Division Name',
            'district_code' => 'District Code',
            'district_name' => 'District Name',
            'block_code' => 'Block Code',
            'block_name' => 'Block Name',
            'operational' => 'Operational',
            'trained_and_certified' => 'Trained And Certified',
            'last_updated_on' => 'Last Updated On',
        ];
    }

    public function beforeSave($insert) {

        $this->last_updated_on = new \yii\db\Expression('NOW()');

        return parent::beforeSave($insert);
    }

    public static function getTotal($provider, $columnName) {
        $total = 0;

        foreach ($provider as $item) {
            $total += $item[$columnName];
        }

        return $total;
    }

    public function getBlock() {
        return $this->hasOne(master\MasterBlock::className(), ['block_code' => 'block_code']);
    }

    public function getDistrict() {
        return $this->hasOne(master\MasterDistrict::className(), ['district_code' => 'district_code']);
    }

    public function getDiv() {
        return $this->hasOne(master\MasterDivision::className(), ['division_code' => 'division_code']);
    }

    public function getPredata() {
        $date = new \DateTime($this->date);
        $date->modify('-1 day');
        $predate = $date->format('Y-m-d');
        return $this->hasOne(BcGovermentReportBlock::className(), ['block_code' => 'block_code'])->andWhere(['=', 'date', $predate]);
    }
    public function getIconop() {
        $icon = '';
       
        if ($this->change_operational == 0) {
            $icon = '<i class="fal fa fa-arrow-right"></i>';
        }
        if ($this->change_operational > 0) {
             $icon = '<i class="fal fa fa-arrow-up" style="color:green"></i>';
        }
        if ($this->change_operational < 0) {
             $icon = '<i class="fal fa fa-arrow-down" style="color:red"></i>';
        }
        return $icon;
    }

    public function getIconts() {
        $icon = '';
     
        if ($this->change_trained_and_certified == 0) {
            $icon = '<i class="fal fa fa-arrow-right"></i>';
        }
        if ($this->change_trained_and_certified > 0) {
             $icon = '<i class="fal fa fa-arrow-up" style="color:green"></i>';
        }
        if ($this->change_trained_and_certified < 0) {
             $icon = '<i class="fal fa fa-arrow-down" style="color:red"></i>';
        }
        return $icon;
    }
}
