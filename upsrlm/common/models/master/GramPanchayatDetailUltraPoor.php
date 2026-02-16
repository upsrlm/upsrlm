<?php

namespace common\models\master;

use Yii;
use common\models\master\GramPanchayatDetailUltraPoorHistory;

/**
 * This is the model class for table "gram_panchayat_detail_ultra_poor".
 *
 * @property int $id
 * @property int $gram_panchayat_code
 * @property string $gram_panchayat_name
 * @property int $gram_pardhan
 * @property int $gram_pardhan_user_id
 * @property int $gram_pardhan_contact
 * @property int $gram_pardhan_login
 * @property int $gram_pardhan_add_no_user
 * @property int $gram_pardhan_go_sent
 * @property int $gram_pardhan_go_contact
 * @property int $sahayak
 * @property int $sahayak_user_id
 * @property int $sahayak_contact
 * @property int $sahayak_login
 * @property int $sahayak_add_no_user
 * @property int $sahayak_go_sent
 * @property int $sahayak_go_contact
 * @property int $no_of_user
 * @property int $no_of_user_login
 * @property int $gp_user_login
 * @property int $hhs_enumerated
 * @property int $hhs_enumerated_old
 * @property int $hhs_enumerated_mopup
 * @property int $gram_pardhan_return_hhs
 * @property int $gram_pardhan_verify_hhs
 * @property int $gram_pardhan_remain_verification
 * @property int $hhs_in_save_mode
 * @property int $hhs_shg_member
 * @property int $digital_hhs_attempt
 * @property int $digital_hhs_remain_attempt
 * @property int $digital_hhs_verified
 * @property int $digital_hhs_unverified
 * @property int $digital_hhs_has_smartphone
 * @property int $digital_hhs_wrong_mobile_no
 * @property int $digital_hhs_wrong_mobile_no_does_not_exist
 * @property int $gp_covert_urban
 * @property int|null $updated_at
 * @property int $status
 */
class GramPanchayatDetailUltraPoor extends \common\models\dynamicdb\cbo\CboactiveRecord {

    public function behaviors() {
        return [
            [
                'class' => \yii\behaviors\TimestampBehavior::className(),
                'createdAtAttribute' => false,
                'updatedAtAttribute' => 'updated_at',
                'value' => function () {
                    return time();
                },
            ],
        ];
    }

    public static function tableName() {
        return 'gram_panchayat_detail_ultra_poor';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['gram_panchayat_code', 'gram_panchayat_name'], 'required'],
            [['gram_panchayat_code', 'gram_pardhan', 'gram_pardhan_user_id', 'gram_pardhan_contact', 'gram_pardhan_login', 'gram_pardhan_add_no_user', 'no_of_user', 'no_of_user_login', 'hhs_enumerated', 'hhs_enumerated_old', 'hhs_enumerated_mopup', 'gram_pardhan_return_hhs', 'gram_pardhan_verify_hhs', 'gram_pardhan_remain_verification', 'hhs_in_save_mode', 'digital_hhs_attempt', 'digital_hhs_remain_attempt', 'digital_hhs_verified', 'digital_hhs_unverified', 'digital_hhs_has_smartphone', 'digital_hhs_wrong_mobile_no', 'digital_hhs_wrong_mobile_no_does_not_exist', 'gp_covert_urban', 'hhs_shg_member', 'updated_at', 'status'], 'integer'],
            [['gram_panchayat_name'], 'string', 'max' => 132],
            [['gram_panchayat_code'], 'unique'],
            [['sahayak', 'sahayak_user_id', 'sahayak_contact', 'sahayak_login', 'sahayak_add_no_user', 'gram_pardhan_go_sent', 'sahayak_go_sent', 'sahayak_go_contact', 'gram_pardhan_go_contact', 'gp_user_login'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'gram_panchayat_code' => 'Gram Panchayat Code',
            'gram_panchayat_name' => 'Gram Panchayat Name',
            'gram_pardhan' => 'Gram Pardhan',
            'gram_pardhan_login' => 'Gram Pardhan Login',
            'gram_pardhan_add_no_user' => 'Gram Pardhan Add No User',
            'no_of_user' => 'No Of User',
            'no_of_user_login' => 'No Of User Login',
            'hhs_enumerated' => 'Hhs Enumerated',
            'hhs_enumerated_old' => 'Hhs Enumerated Old',
            'hhs_enumerated_mopup' => 'Hhs Enumerated Mopup',
            'gram_pardhan_return_hhs' => 'Gram Pardhan Return Hhs',
            'gram_pardhan_verify_hhs' => 'Gram Pardhan Verify Hhs',
            'gram_pardhan_remain_verification' => 'Gram Pardhan Remain Verification',
            'hhs_in_save_mode' => 'Hhs In Save Mode',
            'digital_hhs_attempt' => 'Digital Hhs Attempt',
            'digital_hhs_remain_attempt' => 'Digital Hhs Remain Attempt',
            'digital_hhs_verified' => 'Digital Hhs Verified',
            'digital_hhs_unverified' => 'Digital Hhs Unverified',
            'digital_hhs_has_smartphone' => 'Digital Hhs Has Smartphone',
            'digital_hhs_wrong_mobile_no' => 'Digital Hhs Wrong Mobile No',
            'digital_hhs_wrong_mobile_no_does_not_exist' => 'Digital Hhs Wrong Mobile No Does Not Exist',
            'gp_covert_urban' => 'Gp Covert Urban',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }

    public function beforeSave($insert) {

        if ($this->gram_pardhan_contact) {
            $this->gram_pardhan_go_contact = 1;
        }

        if ($this->gram_pardhan_go_sent) {
            $this->gram_pardhan_go_contact = 1;
        }
        if ($this->sahayak_contact) {
            $this->sahayak_go_contact = 1;
        }

        if ($this->sahayak_go_sent) {
            $this->sahayak_go_contact = 1;
        }
        return parent::beforeSave($insert);
    }

    public function afterSave($insert, $changedAttributes) {
        $cdate = new \DateTime('NOW', new \DateTimeZone('Asia/Kolkata'));
        $h = $cdate->format('H');
        $date = date('Y-m-d');
        if ($h >= 0 and $h <= 10) {
            $date = date('Y-m-d', strtotime('-1 day', strtotime(date("Y-m-d"))));
        }
        $attribute = $this;
        try {
            $model = GramPanchayatDetailUltraPoorHistory::find()->where(['date' => $date, 'gram_panchayat_code' => $this->gram_panchayat_code])->one();
            if ($model == null) {
                $model = new GramPanchayatDetailUltraPoorHistory();
            }
            $model->setAttributes($this->attributes);
            $model->date = $date;

            if ($model->save()) {
                
            } else {
//                print_r($model->getErrors());
            }
        } catch (\Exception $ex) {
//            print_r($ex->getMessage());
        }


        return true;
    }

    public function getVillage() {
        return $this->hasMany(MasterVillage::className(), ['gram_panchayat_code' => 'gram_panchayat_code']);
    }

    public function getDistrict() {
        return $this->hasOne(MasterDistrict::className(), ['district_code' => 'district_code']);
    }

    public function getBlock() {
        return $this->hasOne(MasterBlock::className(), ['block_code' => 'block_code']);
    }

    public function getGp() {
        return $this->hasOne(MasterGramPanchayat::className(), ['gram_panchayat_code' => 'gram_panchayat_code']);
    }
    public function getPardhan() {
        return $this->hasOne(\common\models\User::className(), ['id' => 'gram_pardhan_user_id']);
    }

    public static function getTotal($provider, $columnName, $search = null) {
        $total = 0;
        $query = GramPanchayatDetailUltraPoor::find()->select(['id', 'gram_pardhan_add_no_user', 'no_of_user', 'no_of_user_login', 'hhs_enumerated_old', 'hhs_enumerated_mopup', 'gram_pardhan_return_hhs', 'gram_pardhan_verify_hhs', 'gram_pardhan_remain_verification'])->where(['=', GramPanchayatDetailUltraPoor::getTableSchema()->fullName . '.status', 1]);
        $query->joinWith(['gp', 'block']);
       
        if ($search->aspirational != '') {
            $query->andWhere([MasterBlock::getTableSchema()->fullName . '.aspirational' => $search->aspirational]);
        }
        if (isset($search->district_code) and $search->district_code != '') {
            $query->andWhere([GramPanchayatDetailUltraPoor::getTableSchema()->fullName . '.district_code' => $search->district_code]);
        }
        if (isset($search->block_code) and $search->block_code != '') {
            $query->andWhere([GramPanchayatDetailUltraPoor::getTableSchema()->fullName . '.block_code' => $search->block_code]);
        }
        if (isset($search->gram_panchayat_code) and $search->gram_panchayat_code != '') {
            $query->andWhere([GramPanchayatDetailUltraPoor::getTableSchema()->fullName . '.gram_panchayat_code' => $search->gram_panchayat_code]);
        }
        if (isset($search->gram_pardhan) and $search->gram_pardhan != '') {
            $query->andWhere(['gram_pardhan' => $search->gram_pardhan]);
        }
        if (isset($search->gram_pardhan_login) and $search->gram_pardhan_login != '') {
            $query->andWhere(['gram_pardhan_login' => $search->gram_pardhan_login]);
        }
        if (isset($search->gram_pardhan_add_no_user) and $search->gram_pardhan_add_no_user != '') {
            if ($search->gram_pardhan_add_no_user == 0) {
                $query->andWhere([GramPanchayatDetailUltraPoor::getTableSchema()->fullName . '.gram_pardhan_add_no_user' => 0]);
            }
            if ($search->gram_pardhan_add_no_user == 1) {
                $query->andWhere(['>', GramPanchayatDetailUltraPoor::getTableSchema()->fullName . '.gram_pardhan_add_no_user', 0]);
            }
        }
        if (isset($search->no_of_user_login) and $search->no_of_user_login != '') {
            if ($search->no_of_user_login == 0) {
                $query->andWhere([GramPanchayatDetailUltraPoor::getTableSchema()->fullName . '.no_of_user_login' => 0]);
            }
            if ($search->no_of_user_login == 1) {
                $query->andWhere(['>', GramPanchayatDetailUltraPoor::getTableSchema()->fullName . '.no_of_user_login', 0]);
            }
        }
        if (isset($search->hhs_enumerated_mopup) and $search->hhs_enumerated_mopup != '') {
            if ($search->hhs_enumerated_mopup == 0) {
                $query->andWhere([GramPanchayatDetailUltraPoor::getTableSchema()->fullName . '.hhs_enumerated_mopup' => 0]);
            }
            if ($search->hhs_enumerated_mopup == 1) {
                $query->andWhere(['>', GramPanchayatDetailUltraPoor::getTableSchema()->fullName . '.hhs_enumerated_mopup', 0]);
            }
        }
        if ($search->gram_pardhan_sahayak != '') {
            if ($search->gram_pardhan_sahayak == 0) {
                $query->andWhere([GramPanchayatDetailUltraPoor::getTableSchema()->fullName . '.gram_pardhan' => 0]);
                $query->andWhere([GramPanchayatDetailUltraPoor::getTableSchema()->fullName . '.sahayak' => 0]);
            }
            if ($search->gram_pardhan_sahayak == 1) {
                $query->andWhere(['or',
                    [GramPanchayatDetailUltraPoor::getTableSchema()->fullName . '.gram_pardhan' => 1],
                    [GramPanchayatDetailUltraPoor::getTableSchema()->fullName . '.sahayak' => 1]
                ]);
            }
        }
        if ($search->gram_pardhan_sahayak_login != '') {
            if ($search->gram_pardhan_sahayak_login == 0) {
                $query->andWhere([GramPanchayatDetailUltraPoor::getTableSchema()->fullName . '.gram_pardhan_login' => 0]);
                $query->andWhere([GramPanchayatDetailUltraPoor::getTableSchema()->fullName . '.sahayak_login' => 0]);
            }
            if ($search->gram_pardhan_sahayak_login == 1) {
                $query->andWhere(['or',
                    [GramPanchayatDetailUltraPoor::getTableSchema()->fullName . '.gram_pardhan_login' => 1],
                    [GramPanchayatDetailUltraPoor::getTableSchema()->fullName . '.sahayak_login' => 1]
                ]);
            }
        }
        if ($search->gram_pardhan_verify_hhs != '') {
            if ($search->gram_pardhan_verify_hhs == 0) {
                $query->andWhere([GramPanchayatDetailUltraPoor::getTableSchema()->fullName . '.gram_pardhan_verify_hhs' => 0]);
            }
            if ($search->gram_pardhan_verify_hhs == 1) {
                $query->andWhere(['>', GramPanchayatDetailUltraPoor::getTableSchema()->fullName . '.gram_pardhan_verify_hhs', 0]);
            }
        }
         if ($search->gram_pardhan_verify_hhs_group != '') {
            if ($search->gram_pardhan_verify_hhs_group == '0') {
                $query->andWhere(['between', GramPanchayatDetailUltraPoor::getTableSchema()->fullName . '.gram_pardhan_verify_hhs', '0', '0']);
            } elseif ($search->gram_pardhan_verify_hhs_group == '1') {
                $query->andWhere(['between', GramPanchayatDetailUltraPoor::getTableSchema()->fullName . '.gram_pardhan_verify_hhs', '1', '9']);
            } else if ($search->gram_pardhan_verify_hhs_group == '2') {
                $query->andWhere(['between', GramPanchayatDetailUltraPoor::getTableSchema()->fullName . '.gram_pardhan_verify_hhs', '10', '25']);
            } else if ($search->gram_pardhan_verify_hhs_group == '3') {
                $query->andWhere(['>', GramPanchayatDetailUltraPoor::getTableSchema()->fullName . '.gram_pardhan_verify_hhs', '25']);
            }
        }
        if ($columnName == 'name') {
            $name = 'Uttar Pradesh';
            if (isset($search->district_code) and $search->district_code != '') {
                $model = MasterDistrict::find()->where(['district_code' => $search->district_code])->one();
                if ($model != null) {
                    $name .= ' : ' . $model->district_name;
                }
            }
            if (isset($search->block_code) and $search->block_code != '') {
                $model1 = MasterBlock::find()->where(['block_code' => $search->block_code])->one();
                if ($model1 != null) {
                    $name .= ' : ' . $model1->block_name;
                }
            }
            if (isset($search->gram_panchayat_code) and $search->gram_panchayat_code != '') {
                $model1 = MasterGramPanchayat::find()->where(['gram_panchayat_code' => $search->gram_panchayat_code])->one();
                if ($model1 != null) {
                    $name .= ' : ' . $model1->gram_panchayat_name;
                }
            }
            return $name;
        }
        if ($columnName == 'gram_pardhan') {
            $query->andWhere(['gram_pardhan' => 1]);
            $total = $query->count();
        }
        if ($columnName == 'gram_pardhan_contact') {
            $query->andWhere(['gram_pardhan_contact' => 1]);
            $total = $query->count();
        }
        if ($columnName == 'gram_pardhan_go_contact') {
            $query->andWhere(['gram_pardhan_go_contact' => 1]);
            $total = $query->count();
        }
        if ($columnName == 'gram_pardhan_login') {
            $query->andWhere(['gram_pardhan_login' => 1]);
            $total = $query->count();
        }
        if ($columnName == 'gram_pardhan_add_no_user') {

            $total = $query->sum('gram_pardhan_add_no_user');
        }
        if ($columnName == 'sahayak') {
            $query->andWhere(['sahayak' => 1]);
            $total = $query->count();
        }
        if ($columnName == 'sahayak_go_contact') {
            $query->andWhere(['sahayak_go_contact' => 1]);
            $total = $query->count();
        }

        if ($columnName == 'sahayak_login') {
            $query->andWhere(['sahayak_login' => 1]);
            $total = $query->count();
        }
        if ($columnName == 'sahayak_add_no_user') {

            $total = $query->sum('sahayak_add_no_user');
        }
        if ($columnName == 'no_of_user') {

            $total = $query->sum('no_of_user');
        }
        if ($columnName == 'no_of_user_login') {

            $total = $query->sum('no_of_user_login');
        }
        if ($columnName == 'hhs_enumerated') {

            $total = $query->sum('hhs_enumerated');
        }
        if ($columnName == 'hhs_enumerated_old') {

            $total = $query->sum('hhs_enumerated_old');
        }
        if ($columnName == 'hhs_enumerated_mopup') {
            $total = $query->sum('hhs_enumerated_mopup');
        }
        if ($columnName == 'gram_pardhan_return_hhs') {
            $total = $query->sum('gram_pardhan_return_hhs');
        }
        if ($columnName == 'gram_pardhan_verify_hhs') {
            $total = $query->sum('gram_pardhan_verify_hhs');
        }
        if ($columnName == 'gram_pardhan_remain_verification') {
            $total = $query->sum('gram_pardhan_remain_verification');
        }
        return $total;
    }
}
