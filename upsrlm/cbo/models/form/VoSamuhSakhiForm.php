<?php

namespace cbo\models\form;

use Yii;
use yii\helpers\ArrayHelper;
use app\models\UserModel;
use common\models\master\MasterRole;
use cbo\models\CboVo;
use cbo\models\Shg;
use common\models\base\GenralModel;
use yii\web\UploadedFile;

/**
 * VoSamuhSakhiForm is the model behind the CboVo
 * @author Habibur Rahman <rahman.kld@gmail.com>
 */
class VoSamuhSakhiForm extends \yii\base\Model {

    public $id;
    public $samuh_sakhi_name;
    public $samuh_sakhi_age;
    public $samuh_sakhi_cbo_shg_id;
    public $samuh_sakhi_mobile_no;
    public $samuh_sakhi_mobile_type;
    public $samuh_sakhi_social_category;
    public $samuh_sakhi_detail_by;
    public $samuh_sakhi_detail_date;
    public $created_by;
    public $updated_by;
    public $created_at;
    public $updated_at;
    public $status;
    public $cast_option = [];
    public $mobile_type_option = [];
    public $shg_option = [];
    public $vo_model;

    public function __construct($vo_model) {
        $this->vo_model = $vo_model;
        $this->shg_option = ArrayHelper::map(Shg::find()->where(['cbo_vo_id' => $this->vo_model->id])->all(), 'id', 'name_of_shg');
        $this->cast_option = ArrayHelper::map(\cbo\models\master\CboMasterCast::find()->all(), 'id', 'name_hi');
        $this->mobile_type_option = ArrayHelper::map(\cbo\models\master\CboMasterPhoneType::find()->all(), 'id', 'name_hi');

        if ($this->vo_model != null) {
            $this->samuh_sakhi_name = $this->vo_model->samuh_sakhi_name;
            $this->samuh_sakhi_age = $this->vo_model->samuh_sakhi_age;
            $this->samuh_sakhi_cbo_shg_id = $this->vo_model->samuh_sakhi_cbo_shg_id;
            $this->samuh_sakhi_mobile_no = $this->vo_model->samuh_sakhi_mobile_no;
            $this->samuh_sakhi_mobile_type = $this->vo_model->samuh_sakhi_mobile_type;
            $this->samuh_sakhi_social_category = $this->vo_model->samuh_sakhi_social_category;
        }
    }

    public function rules() {
        return [
            [['samuh_sakhi_name'], 'required'],
            [['samuh_sakhi_age'], 'required'],
            [['samuh_sakhi_age'], 'number', 'min' => 15, 'max' => 99],
            [['samuh_sakhi_mobile_no'], 'required'],
            [['samuh_sakhi_mobile_no'], \common\validators\MobileNoValidator::className()],
            [['samuh_sakhi_mobile_type'], 'required'],
            [['samuh_sakhi_social_category'], 'required'],
            [['samuh_sakhi_cbo_shg_id'], 'required'],
            [['samuh_sakhi_name'], 'trim'],
            [['samuh_sakhi_age'], 'trim'],
            [['samuh_sakhi_age', 'samuh_sakhi_cbo_shg_id', 'samuh_sakhi_mobile_type', 'samuh_sakhi_social_category', 'samuh_sakhi_detail_by'], 'integer'],
            [['samuh_sakhi_detail_date'], 'safe'],
            [['samuh_sakhi_name'], 'string', 'min' => 2],
            [['samuh_sakhi_name'], 'string', 'max' => 255],
            [['samuh_sakhi_mobile_no'], 'string', 'max' => 15],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'samuh_sakhi_name' => 'समूह सखी का नाम',
            'samuh_sakhi_age' => 'आयु',
            'samuh_sakhi_cbo_shg_id' => 'जिस समूह की सदस्या हैं ',
            'samuh_sakhi_mobile_no' => 'मोबाइल नम्बर,',
            'samuh_sakhi_mobile_type' => 'मोबाइल फ़ोन का प्रकार ',
            'samuh_sakhi_social_category' => 'सामाजिक श्रेणी',
            'samuh_sakhi_detail_by' => 'Samuh Sakhi Detail By',
            'samuh_sakhi_detail_date' => 'Samuh Sakhi Detail Date',
        ];
    }

    public function save() {

        $this->vo_model->samuh_sakhi_name = $this->samuh_sakhi_name;
        $this->vo_model->samuh_sakhi_age = $this->samuh_sakhi_age;
        $this->vo_model->samuh_sakhi_cbo_shg_id = $this->samuh_sakhi_cbo_shg_id;
        $this->vo_model->samuh_sakhi_mobile_no = $this->samuh_sakhi_mobile_no;
        $this->vo_model->samuh_sakhi_mobile_type = $this->samuh_sakhi_mobile_type;
        $this->vo_model->samuh_sakhi_social_category = $this->samuh_sakhi_social_category;
        $this->vo_model->samuh_sakhi_detail_by = \Yii::$app->user->identity->id;
        $this->vo_model->samuh_sakhi_detail_date = new \yii\db\Expression('NOW()');
        if ($this->vo_model->save()) {
            return $this;
        } else {
            print_r($this->vo_model->getErrors());
        }
    }

}
