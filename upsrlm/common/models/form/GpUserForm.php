<?php

namespace common\models\form;

use Yii;
use yii\helpers\ArrayHelper;
use yii\base\Model;
use common\models\base\GenralModel;
use common\models\UserSearch;
use common\models\master\MasterRole;
use common\models\User;

/**
 * GpUserForm is the model behind the User
 * @author Habibur Rahman <rahman.kld@gmail.com>
 */
class GpUserForm extends Model {

    public $id;
    public $name;
    public $username;
    public $password;
    public $email;
    public $enumerate;
    public $target;
    public $gram_panchayat_code;
    public $user_enu_model;
    public $role;
    public $mobile_no;
    public $created_at;
    public $created_by;
    public $updated_at;
    public $updated_by;
    public $status;
    public $profile_status = 1;
    public $login_by_otp;
    public $user_model;
    public $block_model;
    public $role_option = [];
    public static $usernameRegexp = '/^[-a-zA-Z0-9_\.@]+$/';

    public function __construct($user_model = null) {
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
            $this->profile_status = $this->user_model->profile_status;
            $this->login_by_otp = $this->user_model->login_by_otp;
        }

        $this->role_option = [
            MasterRole::ROLE_GP_SAACHIV => 'ग्राम पंचायत सचिव',
            MasterRole::ROLE_GP_SAHAYAK => 'ग्राम पंचायत सहायक',
            MasterRole::ROLE_GP_ROJGAR_SEVAK => 'ग्राम रोज़गार सेवक',
            MasterRole::ROLE_GP_SAFAI_KARMI => 'ग्राम स्वच्छता कर्मी',
            MasterRole::ROLE_ULTRA_POOR_ENUMERATOR => 'सीएसओ यूजर',
        ];
    }

    /**
     * @return array the validation rules.
     */
    public function rules() {
        return [
            [['created_at', 'created_by'], 'safe'],
            [['name'], 'required', 'message' => 'Is requred'],
            [['enumerate'], 'required', 'on' => ['add'], 'message' => 'Is requred'],
            [['target'], 'required', 'on' => ['add'], 'message' => 'Is requred'],
            [['gram_panchayat_code'], 'required', 'on' => ['add'], 'message' => 'Is requred'],
            [['name'], 'trim'],
            // [['mobile_no'], 'required', 'message' => 'Is requred'],
            [['mobile_no', 'username'], \common\validators\InmobilenoValidator::className()],
            ['username', 'trim'],
            ['username', 'required', 'message' => 'Is required'],
            ['username', 'match', 'pattern' => static::$usernameRegexp],
            ['username', 'string', 'min' => 3, 'max' => 255],
            // email rules
            ['email', 'trim'],
            ['enumerate', 'safe'],
            ['target', 'safe'],
            //['email', 'required', 'message' => 'Is required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            [['username'], 'unique', 'when' => function ($model, $attribute) {
                    return $this->user_model->$attribute != $model->$attribute;
                }, 'targetClass' => User::className(), 'message' => 'यह मोबाइल नंबर पहले ही ले लिया गया है', 'targetAttribute' => 'username'],
            [['email'], 'unique', 'when' => function ($model, $attribute) {
                    return $this->user_model->$attribute != $model->$attribute;
                }, 'targetClass' => User::className(), 'message' => 'This email has already been taken', 'targetAttribute' => 'email'],
            // password rules
            // ['password', 'required', 'message' => 'Is required'],
            ['password', 'string', 'min' => 6, 'max' => 72],
            [['status'], 'default', 'value' => 10],
            [['role',], 'required', 'message' => 'Is requred'],
            ['profile_status', 'safe'],
            ['profile_status', 'default', 'value' => 1],
            ['login_by_otp', 'default', 'value' => 2],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'name' => 'नाम',
            'username' => 'मोबाइल नंबर',
            'password' => 'Password',
            'email' => 'Email',
            'role' => 'Role',
            'target'=>'टारगेट',
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
        $this->user_model->status = User::STATUS_ACTIVE;
        $this->user_model->profile_status = $this->profile_status;
        $this->user_model->login_by_otp = $this->login_by_otp;
        if ($this->user_model->isNewRecord) {
            $this->user_model->action_type = 1;
        } else {
            $this->user_model->action_type = 2;
        }
        if ($this->user_model->save()) {
            return $this;
        }
    }

}
