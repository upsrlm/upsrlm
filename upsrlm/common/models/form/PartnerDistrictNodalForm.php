<?php

namespace common\models\form;

use Yii;
use yii\helpers\ArrayHelper;
use yii\base\Model;
use common\models\base\GenralModel;
use common\models\RelationUserDistrict;
use common\models\User;
use common\models\master\MasterRole;
use common\models\UserProfile;

/**
 * PartnerDistrictNodalForm is the model behind the User
 * @author Habibur Rahman <rahman.kld@gmail.com>
 */
class PartnerDistrictNodalForm extends Model {

    public $id;
    public $name;
    public $username;
    public $password;
    public $email;
    public $role;
    public $mobile_no;
    public $district_code;
    public $master_partner_bank_id;
    public $created_at;
    public $created_by;
    public $updated_at;
    public $updated_by;
    public $status;
    public $user_model;
    public $profile_model;
    public $block_model;
    public $role_option = [];
    public $district_option = [];
    public $bank_option;
    public static $usernameRegexp = '/^[-a-zA-Z0-9_\.@]+$/';

    public function __construct($user_model = null) {
        $this->bank_option=\bc\modules\selection\models\base\GenralModel::partner_bank_option();
        $this->role = MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL;
        $this->district_option = GenralModel::nfsaoptiondistrict($this);
        $this->user_model = Yii::createObject([
                    'class' => User::className()
        ]);
        if ($user_model != null) {
            $this->user_model = $user_model;
            $this->name = $this->user_model->name;
            $this->username = $this->user_model->username;
            $this->email = $this->user_model->email;
            $this->mobile_no = $this->user_model->mobile_no;
            $this->role = $this->user_model->role;
            $this->password = substr($this->user_model->upd, 3);
            $this->district_code = ArrayHelper::getColumn($this->user_model->districts, 'district_code');
            $this->status = $this->user_model->status;
            $this->master_partner_bank_id = $user_model->master_partner_bank_id;
        }
    }

    /**
     * @return array the validation rules.
     */
    public function rules() {
        return [
            [['created_at', 'created_by'], 'safe'],
            [['name'], 'required', 'message' => 'Is requred'],
            [['master_partner_bank_id'], 'required', 'message' => 'Is requred'],
            [['name'], 'trim'],
            [['mobile_no'], 'required', 'message' => 'Is requred'],
            [['mobile_no'], \common\validators\MobileNoValidator::className()],
            ['username', 'trim'],
            ['username', 'required', 'message' => 'Is required'],
            ['username', 'match', 'pattern' => static::$usernameRegexp],
            ['username', 'string', 'min' => 3, 'max' => 255],
            // email rules
            ['email', 'trim'],
            ['email', 'required', 'message' => 'Is required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            [['username'], 'unique', 'when' => function ($model, $attribute) {
                    return $this->user_model->$attribute != $model->$attribute;
                }, 'targetClass' => User::className(), 'message' => 'This login has already been taken', 'targetAttribute' => 'username'],
            [['email'], 'unique', 'when' => function ($model, $attribute) {
                    return $this->user_model->$attribute != $model->$attribute;
                }, 'targetClass' => User::className(), 'message' => 'This email has already been taken', 'targetAttribute' => 'email'],
            // password rules
            ['password', 'required', 'message' => 'Is required'],
            ['password', 'string', 'min' => 6, 'max' => 72],
            [['status'], 'default', 'value' => 10],
            [['role', 'district_code'], 'required', 'message' => 'Is requred'],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'username' => 'Login',
            'password' => 'Password',
            'master_partner_bank_id' => 'Partner agency',
            'email' => 'Email',
            'master_role_id' => 'Role',
            'district_code' => 'District',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'status' => 'Status',
        ];
    }

    public function save() {
        if (!$this->validate()) {
            return false;
        }


        $this->user_model->name = $this->name;
        $this->user_model->mobile_no = $this->mobile_no;
        $this->user_model->username = $this->username;
        $this->user_model->role = $this->role;
        $this->user_model->email = $this->email;
        $this->user_model->password = $this->password;
        $this->user_model->setPassword($this->password);
        $this->user_model->setUpd($this->password);
        $this->user_model->status = $this->status;
        if ($this->user_model->isNewRecord) {
            $this->user_model->action_type = 1;
        } else {
            $this->user_model->action_type = 2;
        }
        if ($this->user_model->save()) {
            $this->profile_model = UserProfile::findOne(['user_id' => $this->user_model->id]);
            if ($this->district_code) {
                if ($this->profile_model == null)
                    $this->profile_model = new UserProfile();

                $this->profile_model->user_id = $this->user_model->id;
                $bank_model = $this->master_partner_bank_id;
                $this->profile_model->master_partner_bank_id = $this->master_partner_bank_id;
                $this->profile_model->save();
            }
            $condition = ['and',
                ['=', 'user_id', $this->user_model->id,],
            ];
            RelationUserDistrict::updateAll([
                'status' => '-1',
                    ], $condition);
            try {
//                $command = \Yii::$app->dbbc->createCommand(
//                        'UPDATE db1.users, db2.cards SET users.account_id = cards.account_id WHERE cards.id = users.card_id'
//                );
//                $command->execute();
                \common\models\dynamicdb\bc\RelationUserDistrict::updateAll([
                    'status' => '-1',
                        ], $condition);
            } catch (\Exception $ex) {
                
            }
            if (is_array($this->district_code)) {
                foreach ($this->district_code as $district_code) {
                    $user_district_model = RelationUserDistrict::find()->where(['district_code' => $district_code, 'user_id' => $this->user_model->id])->one();
                    if ($user_district_model == NULL) {
                        $user_district_model = new RelationUserDistrict();
                    }
                    $user_district_model->user_id = $this->user_model->id;
                    $user_district_model->district_code = $district_code;

                    $user_district_model->status = GenralModel::STATUS_ACTIVE;
                    if ($user_district_model->save()) {
                        
                    } else {
                        print_r($user_district_model->getErrors());
                        exit;
                    }
                }
            }

            return $this;
        }
    }
}
