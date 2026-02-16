<?php

namespace backend\models\form;

use Yii;
use yii\helpers\ArrayHelper;
use yii\base\Model;
use common\models\base\GenralModel;
use common\models\RelationUserDivision;
use common\models\User;
use common\models\master\MasterRole;

/**
 * DivisionCommisnorForm is the model behind the User
 * @author Habibur Rahman <rahman.kld@gmail.com>
 */
class DivisionCommisnorForm extends Model {

    public $id;
    public $name;
    public $username;
    public $password;
    public $email;
    public $role;
    public $mobile_no;
    public $division_code;
    public $created_at;
    public $created_by;
    public $updated_at;
    public $updated_by;
    public $status;
    public $user_model;
    public $block_model;
    public $role_option = [];
    public $division_option = [];
    public static $usernameRegexp = '/^[-a-zA-Z0-9_\.@]+$/';

    public function __construct($user_model = null) {
        $this->role = MasterRole::ROLE_DM;
        $this->division_option = GenralModel::nfsaoptiondivision($this);
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
            $this->division_code = ArrayHelper::getColumn($this->user_model->division, 'division_code');
        }
    }

    /**
     * @return array the validation rules.
     */
    public function rules() {
        return [
            [['created_at', 'created_by'], 'safe'],
            [['name'], 'required', 'message' => 'Is requred'],
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
            [['status'], 'default', 'value' => 1],
            [['role', 'division_code'], 'required', 'message' => 'Is requred'],
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
            'email' => 'Email',
            'master_role_id' => 'Role',
            'division_code' => 'Division',
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
        if ($this->user_model->isNewRecord) {
            $this->user_model->action_type = 1;
        } else {
            $this->user_model->action_type = 2;
        }
        if ($this->user_model->save()) {
            $condition = ['and',
                ['=', 'user_id', $this->user_model->id,],
            ];
            RelationUserDivision::updateAll([
                'status' => '-1',
                    ], $condition);
            try {
                \common\models\dynamicdb\bc\RelationUserDivision::updateAll([
                    'status' => '-1',
                        ], $condition);
            } catch (\Exception $ex) {
                
            }
            if (is_array($this->division_code)) {
                foreach ($this->division_code as $division_code) {
                    $user_division_model = RelationUserDivision::find()->where(['division_code' => $division_code, 'user_id' => $this->user_model->id])->one();
                    if ($user_division_model == NULL) {
                        $user_division_model = new RelationUserDivision();
                    }
                    $user_division_model->user_id = $this->user_model->id;
                    $user_division_model->division_code = $division_code;

                    $user_division_model->status = GenralModel::STATUS_ACTIVE;
                    if ($user_division_model->save()) {
                        
                    } else {
                        print_r($user_division_model->getErrors());
                        exit;
                    }
                }
            }

            return $this;
        }
    }

}
