<?php

namespace app\models\form;

use Yii;
use yii\helpers\ArrayHelper;
use yii\base\Model;
use app\models\base\GenralModel;
use app\models\RelationUserBdoBlock;
use app\models\UserModel;
use app\models\master\MasterRole;

/**
 * BDOForm is the model behind the User
 * @author Habibur Rahman <rahman.kld@gmail.com>
 */
class BDOForm extends Model {

    public $id;
    public $name;
    public $username;
    public $password;
    public $email;
    public $role;
    public $mobile_no;
    public $block_code;
    public $created_at;
    public $created_by;
    public $updated_at;
    public $updated_by;
    public $status;
    public $user_model;
    public $block_model;
    public $role_option = [];
    public $block_option = [];
    public static $usernameRegexp = '/^[-a-zA-Z0-9_\.@]+$/';

    public function __construct($user_model = null) {

        $this->role = MasterRole::ROLE_BDO;
        $this->block_option = \app\models\base\GenralModel::nfsaoptionblockdistrict($this);
        $this->user_model = Yii::createObject([
                    'class' => UserModel::className()
        ]);
        if ($user_model != null) {
            $this->user_model = $user_model;
            $this->name = $this->user_model->name;
            $this->username = $this->user_model->username;
            $this->email = $this->user_model->email;
            $this->mobile_no = $this->user_model->mobile_no;
            $this->password = substr($this->user_model->upd, 3);
            $this->block_code = ArrayHelper::getColumn($this->user_model->blocks, 'block_code');
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
            [['mobile_no'], \app\validators\MobleNoValidator::className()],
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
                }, 'targetClass' => UserModel::className(), 'message' => \Yii::t('user', 'This login has already been taken'), 'targetAttribute' => 'username'],
            [['email'], 'unique', 'when' => function ($model, $attribute) {
                    return $this->user_model->$attribute != $model->$attribute;
                }, 'targetClass' => UserModel::className(), 'message' => \Yii::t('user', 'This email has already been taken'), 'targetAttribute' => 'email'],
            // password rules
            ['password', 'required', 'message' => 'Is required'],
            ['password', 'string', 'min' => 6, 'max' => 72],
            [['status'], 'default', 'value' => 1],
            [['role', 'block_code'], 'required', 'message' => 'Is requred'],
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
            'block_code' => 'Block',
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
        if ($this->user_model->isNewRecord) {
            $this->user_model->action_type = 1;
        } else {
            $this->user_model->action_type = 2;
        }
        if ($this->user_model->save()) {
            $condition = ['and',
                ['=', 'user_id', $this->user_model->id,],
            ];
            RelationUserBdoBlock::updateAll([
                'status' => '-1',
                    ], $condition);
            if (is_array($this->block_code)) {
                foreach ($this->block_code as $block_code) {
                    $user_block_model = RelationUserBdoBlock::find()->where(['block_code' => $block_code, 'user_id' => $this->user_model->id])->one();
                    if ($user_block_model == NULL) {
                        $user_block_model = new RelationUserBdoBlock();
                    }
                    $user_block_model->user_id = $this->user_model->id;
                    $user_block_model->block_code = $block_code;

                    $user_block_model->status = GenralModel::STATUS_ACTIVE;
                    if ($user_block_model->save()) {
                        
                    } else {
                        print_r($user_block_model->getErrors());
                        exit;
                    }
                }
            }

            return $this;
        }
    }

}
