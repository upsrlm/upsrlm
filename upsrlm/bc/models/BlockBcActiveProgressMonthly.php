<?php

namespace bc\models;

use Yii;
use bc\models\master\MasterGramPanchayat;

/**
 * This is the model class for table "block_bc_active_progress_monthly".
 *
 * @property int $id
 * @property int $district_code
 * @property int $block_code
 * @property int $no_of_gp
 * @property int $bc_active
 * @property int $no_of_transaction
 * @property float $transaction_amount
 * @property float $commission_amount
 * @property int|null $month_id
 */
class BlockBcActiveProgressMonthly extends BcactiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'block_bc_active_progress_monthly';
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
            [['district_code', 'block_code'], 'required'],
            [['district_code', 'block_code', 'no_of_gp', 'bc_active', 'no_of_transaction', 'month_id'], 'integer'],
            [['transaction_amount', 'commission_amount'], 'number'],
            [['block_code', 'month_id'], 'unique', 'targetAttribute' => ['block_code', 'month_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'district_code' => 'District Code',
            'block_code' => 'Block Code',
            'no_of_gp' => 'No Of Gp',
            'bc_active' => 'Bc Active',
            'no_of_transaction' => 'No Of Transaction',
            'transaction_amount' => 'Transaction Amount',
            'commission_amount' => 'Commission Amount',
            'month_id' => 'Month ID',
        ];
    }

    public function beforeSave($insert) {
        if ($this->block_code != NULL) {
            $this->no_of_gp = MasterGramPanchayat::find()->select(['id'])->where(['block_code' => $this->block_code, 'status' => 1])->count();
        }

        return parent::beforeSave($insert);
    }
}
