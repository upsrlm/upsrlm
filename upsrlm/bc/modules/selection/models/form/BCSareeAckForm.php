<?php

namespace bc\modules\selection\models\form;

use Yii;
use bc\modules\selection\models\SrlmBcApplication;
use bc\modules\selection\models\BcProvidedSaree;
use yii\db\Expression;
use common\helpers\FileHelpers;

/**
 * BCSareeAckForm is the model behind the BcProvidedSaree
 * @author Habibur Rahman <rahman.kld@gmail.com>
 */
class BCSareeAckForm extends \yii\base\Model {

    public $id;
    public $bc_application_id;
    public $srlm_bc_selection_user_id;
    public $district_code;
    public $block_code;
    public $gram_panchayat_code;
    public $saree1_provided;
    public $saree1_provided_date;
    public $saree1_provided_by;
    public $saree1_provided_datetime;
    public $saree1_acknowledge;
    public $get_saree1_date;
    public $get_saree1_packed_new;
    public $get_saree1_quality;
    public $get_saree1_quality_no_1;
    public $get_saree1_quality_no_2;
    public $get_saree1_quality_no_3;
    public $get_saree1_quality_no_4;
    public $get_saree1_quality_no_other;
    public $get_saree1_quality_no_other_text;
    public $get_saree1_quality_photo;
    public $saree1_acknowledge_datetime;
    public $saree2_provided;
    public $saree2_provided_date;
    public $saree2_provided_by;
    public $saree2_provided_datetime;
    public $saree2_acknowledge;
    public $get_saree2_date;
    public $get_saree2_packed_new;
    public $get_saree2_quality;
    public $get_saree2_quality_no_1;
    public $get_saree2_quality_no_2;
    public $get_saree2_quality_no_3;
    public $get_saree2_quality_no_4;
    public $get_saree2_quality_no_other;
    public $get_saree2_quality_no_other_text;
    public $get_saree2_quality_photo;
    public $saree2_acknowledge_datetime;
    public $saree;
    public $get_saree_quality_no;
    public $created_by;
    public $updated_by;
    public $created_at;
    public $updated_at;
    public $status;
    public $bc_model;
    public $bc_saree_model;

    public function __construct($bc_model) {
        $this->bc_model = $bc_model;
        $this->bc_application_id = $this->bc_model->id;
        $this->srlm_bc_selection_user_id=$this->bc_model->srlm_bc_selection_user_id;
        if ($this->bc_model->bcsaree != null) {
            $this->bc_saree_model = $this->bc_model->bcsaree;
            if ($this->bc_saree_model->saree1_acknowledge) {
                $this->saree1_acknowledge = $this->bc_saree_model->saree1_acknowledge;
                if ($this->bc_saree_model->saree1_acknowledge == 1) {
                    
                }
            }
            if ($this->bc_saree_model->saree2_acknowledge) {
                $this->saree2_acknowledge = $this->bc_saree_model->saree2_acknowledge;
            }
        } else {
            $this->bc_saree_model = new BcProvidedSaree();
            $this->bc_saree_model->bc_application_id = $this->bc_model->id;
            $this->bc_saree_model->srlm_bc_selection_user_id = $this->bc_model->srlm_bc_selection_user_id;
            $this->bc_saree_model->district_code = $this->bc_model->district_code;
            $this->bc_saree_model->block_code = $this->bc_model->block_code;
            $this->bc_saree_model->gram_panchayat_code = $this->bc_model->gram_panchayat_code;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['bc_application_id'], 'required'],
            [['saree'], 'required'],
            [['bc_application_id', 'srlm_bc_selection_user_id', 'district_code', 'block_code', 'gram_panchayat_code', 'saree1_provided', 'saree1_provided_by', 'saree1_acknowledge', 'get_saree1_quality', 'get_saree1_quality_no_1', 'get_saree1_quality_no_2', 'get_saree1_quality_no_3', 'get_saree1_quality_no_4', 'get_saree1_quality_no_other', 'saree2_provided', 'saree2_provided_by', 'saree2_acknowledge', 'get_saree2_quality', 'get_saree2_quality_no_1', 'get_saree2_quality_no_2', 'get_saree2_quality_no_3', 'get_saree2_quality_no_4', 'get_saree2_quality_no_other', 'created_by', 'updated_by', 'created_at', 'updated_at', 'status'], 'integer'],
            [['saree1_provided_date', 'saree1_provided_datetime', 'get_saree1_date', 'saree1_acknowledge_datetime', 'saree2_provided_date', 'saree2_provided_datetime', 'get_saree2_date', 'saree2_acknowledge_datetime'], 'safe'],
            [['get_saree1_packed_new', 'get_saree2_packed_new'], 'string', 'max' => 1],
            [['get_saree1_quality_no_other_text', 'get_saree2_quality_no_other_text'], 'string', 'max' => 255],
            [['get_saree1_quality_photo', 'get_saree2_quality_photo'], 'string', 'max' => 10000000],
            ['saree1_acknowledge', 'required', 'on' => ['1'], 'when' => function ($model) {
                    return $model->saree == 1;
                }, 'message' => 'चुने', 'whenClient' => "function (attribute, value) {
                  return $('#saree').val() == '1';
            }"],
            ['get_saree1_date', 'required', 'on' => ['1'], 'when' => function ($model) {
                    return $model->saree == 1 and $model->saree1_acknowledge == 1;
                }, 'message' => 'दिनांक चुने', 'whenClient' => "function (attribute, value) {
                  return $('#saree').val() == '1' && $('#saree1_acknowledge').val() == '1';
            }"],
            ['get_saree1_packed_new', 'required', 'on' => ['1'], 'when' => function ($model) {
                    return $model->saree == 1 and $model->saree1_acknowledge == 1;
                }, 'message' => 'चुने', 'whenClient' => "function (attribute, value) {
                  return $('#saree').val() == '1' && $('#saree1_acknowledge').val() == '1';
            }"],
            ['get_saree1_quality', 'required', 'on' => ['1'], 'when' => function ($model) {
                    return $model->saree == 1 and $model->saree1_acknowledge == 1;
                }, 'message' => 'चुने', 'whenClient' => "function (attribute, value) {
                  return $('#saree').val() == '1' && $('#saree1_acknowledge').val() == '1';
            }"],
            ['saree2_acknowledge', 'required', 'on' => ['2'], 'when' => function ($model) {
                    return $model->saree == 2;
                }, 'message' => 'चुने', 'whenClient' => "function (attribute, value) {
                  return $('#saree').val() == '2';
            }"],
            ['get_saree2_date', 'required', 'on' => ['2'], 'when' => function ($model) {
                    return $model->saree == 2 and $model->saree2_acknowledge == 1;
                }, 'message' => 'दिनांक चुने', 'whenClient' => "function (attribute, value) {
                  return $('#saree').val() == '2' && $('#saree2_acknowledge').val() == '1';
            }"],
            ['get_saree2_packed_new', 'required', 'on' => ['2'], 'when' => function ($model) {
                    return $model->saree == 2 and $model->saree2_acknowledge == 1;
                }, 'message' => 'चुने', 'whenClient' => "function (attribute, value) {
                  return $('#saree').val() == '2' && $('#saree2_acknowledge').val() == '1';
            }"],
            ['get_saree2_quality', 'required', 'on' => ['2'], 'when' => function ($model) {
                    return $model->saree == 2 and $model->saree2_acknowledge == 1;
                }, 'message' => 'चुने', 'whenClient' => "function (attribute, value) {
                  return $('#saree').val() == '2' && $('#saree2_acknowledge').val() == '1';
            }"],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'bc_application_id' => 'Name',
            'srlm_bc_selection_user_id' => 'Selection User ID',
            'district_code' => 'District',
            'block_code' => 'Block',
            'gram_panchayat_code' => 'Gram Panchayat',
            'saree1_provided' => 'Saree1 Provided',
            'saree1_provided_date' => 'Saree1 Provided Date',
            'saree1_provided_by' => 'Saree1 Provided By',
            'saree1_provided_datetime' => 'Saree1 Provided Datetime',
            'saree1_acknowledge' => 'क्या आपने बीसी सखी यूनिफ़ॉर्म साड़ी 1 प्राप्त की',
            'get_saree1_date' => 'बीसी सखी यूनिफ़ॉर्म साड़ी 1 प्राप्त दिनांक',
            'get_saree1_packed_new' => 'क्या आपको सही ढंग से पैक किया हुआ नया साड़ी मिला',
            'get_saree1_quality' => 'क्या साड़ी की क्वालिटी अच्छी है?',
            'get_saree1_quality_no_1' => 'साड़ी के कपड़े की क्वालिटी अच्छी नहीं है। साड़ी का मटेरीयल सिन्थेटिक है, सूती नहीं है।',
            'get_saree1_quality_no_2' => 'साड़ी में जो बुनाई है, उसके धागे निकल रहे है ।',
            'get_saree1_quality_no_3' => 'धुलने के बाद साड़ी का रंग हल्का हो गया है ।',
            'get_saree1_quality_no_4' => 'साड़ी की लंबाई कम है ।',
            'get_saree1_quality_no_other' => 'अन्य कोई',
            'get_saree1_quality_no_other_text' => 'अन्य',
            'get_saree1_quality_photo' => 'बीसी सखी यूनिफ़ॉर्म साड़ी 1 फ़ोटो',
            'saree1_acknowledge_datetime' => 'Saree1 Acknowledge Datetime',
            'saree2_provided' => 'Saree2 Provided',
            'saree2_provided_date' => 'Saree2 Provided Date',
            'saree2_provided_by' => 'Saree2 Provided By',
            'saree2_provided_datetime' => 'Saree2 Provided Datetime',
            'saree2_acknowledge' => 'क्या आपने बीसी सखी यूनिफ़ॉर्म साड़ी 2 प्राप्त की',
            'get_saree2_date' => 'बीसी सखी यूनिफ़ॉर्म साड़ी 2 प्राप्त दिनांक',
            'get_saree2_packed_new' => 'क्या आपको सही ढंग से पैक किया हुआ नया साड़ी मिला',
            'get_saree2_quality' => 'क्या साड़ी की क्वालिटी अच्छी है?',
            'get_saree2_quality_no_1' => 'साड़ी के कपड़े की क्वालिटी अच्छी नहीं है। साड़ी का मटेरीयल सिन्थेटिक है, सूती नहीं है।',
            'get_saree2_quality_no_2' => 'साड़ी में जो बुनाई है, उसके धागे निकल रहे है ।',
            'get_saree2_quality_no_3' => 'धुलने के बाद साड़ी का रंग हल्का हो गया है ।',
            'get_saree2_quality_no_4' => 'साड़ी की लंबाई कम है ।',
            'get_saree2_quality_no_other' => 'अन्य कोई',
            'get_saree2_quality_no_other_text' => 'अन्य',
            'get_saree2_quality_photo' => 'बीसी सखी यूनिफ़ॉर्म साड़ी 2 फ़ोटो',
            'saree2_acknowledge_datetime' => 'Saree2 Acknowledge Datetime',
            'get_saree_quality_no' => 'अगर नहीं तो, संकेत करें -',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }

    public function save() {
        if ($this->saree == 1) {
            $this->bc_saree_model->saree1_acknowledge = $this->saree1_acknowledge;
            $this->bc_saree_model->saree1_acknowledge_datetime = new Expression('NOW()');
            if ($this->saree1_acknowledge == 1) {
                $this->bc_saree_model->get_saree1_date = $this->get_saree1_date;
                $this->bc_saree_model->get_saree1_packed_new = $this->get_saree1_packed_new;
                $this->bc_saree_model->get_saree1_quality = $this->get_saree1_quality;
                if ($this->bc_saree_model->get_saree1_quality == 2) {
                    $this->bc_saree_model->get_saree1_quality_no_1 = $this->get_saree1_quality_no_1;
                    $this->bc_saree_model->get_saree1_quality_no_2 = $this->get_saree1_quality_no_2;
                    $this->bc_saree_model->get_saree1_quality_no_3 = $this->get_saree1_quality_no_3;
                    $this->bc_saree_model->get_saree1_quality_no_4 = $this->get_saree1_quality_no_4;
                    $this->bc_saree_model->get_saree1_quality_no_other = $this->get_saree1_quality_no_other;
                }
                if (isset(\Yii::$app->request->post()['BCSareeAckForm']['get_saree1_quality_photo']) and \Yii::$app->request->post()['BCSareeAckForm']['get_saree1_quality_photo']) {
                    $APPLICATION_FORM_FILE_FOLDER = Yii::$app->params['bcdatapath'];
                    $APPLICATION_FORM_FILE_FOLDER = $APPLICATION_FORM_FILE_FOLDER . "bcselection/bcprofile/";

                    if (!file_exists($APPLICATION_FORM_FILE_FOLDER . $this->srlm_bc_selection_user_id)) {
                        mkdir($APPLICATION_FORM_FILE_FOLDER . $this->srlm_bc_selection_user_id);
                        chmod($APPLICATION_FORM_FILE_FOLDER . $this->srlm_bc_selection_user_id, 0777);
                    }
                    $APPLICATION_FORM_FILE_FOLDER=$APPLICATION_FORM_FILE_FOLDER . $this->srlm_bc_selection_user_id;
                    $content = base64_decode(\Yii::$app->request->post()['BCSareeAckForm']['get_saree1_quality_photo']);
                    $im = imagecreatefromstring($content);
                    $image_name = 'saree1_photo_' . uniqid() . '.jpg';
                    $this->bc_saree_model->get_saree1_quality_photo = $image_name;
                    if ($im !== false) {
                        header('Content-Type: image/jpeg');
                        imagejpeg($im, $APPLICATION_FORM_FILE_FOLDER . '/' . $image_name);
                        chmod($APPLICATION_FORM_FILE_FOLDER . '/' . $image_name, 0777);
                        try {
                            $file = new FileHelpers();
                            $file->file_path = $APPLICATION_FORM_FILE_FOLDER;
                            $file->file_name = $image_name;
                            $file->upload();
                        } catch (\Exception $ex) {
                            
                        }
                        imagedestroy($im);
                    }
                }
            }
        }
        if ($this->saree == 2) {
            $this->bc_saree_model->saree2_acknowledge = $this->saree2_acknowledge;
            $this->bc_saree_model->saree2_acknowledge_datetime = new Expression('NOW()');
            if ($this->saree2_acknowledge == 1) {
                $this->bc_saree_model->get_saree2_date = $this->get_saree2_date;
                $this->bc_saree_model->get_saree2_packed_new = $this->get_saree2_packed_new;
                $this->bc_saree_model->get_saree2_quality = $this->get_saree2_quality;
                if ($this->bc_saree_model->get_saree2_quality == 2) {
                    $this->bc_saree_model->get_saree2_quality_no_1 = $this->get_saree2_quality_no_1;
                    $this->bc_saree_model->get_saree2_quality_no_2 = $this->get_saree2_quality_no_2;
                    $this->bc_saree_model->get_saree2_quality_no_3 = $this->get_saree2_quality_no_3;
                    $this->bc_saree_model->get_saree2_quality_no_4 = $this->get_saree2_quality_no_4;
                    $this->bc_saree_model->get_saree2_quality_no_other = $this->get_saree2_quality_no_other;
                }
                if (isset(\Yii::$app->request->post()['BCSareeAckForm']['get_saree2_quality_photo']) and \Yii::$app->request->post()['BCSareeAckForm']['get_saree2_quality_photo']) {
                    $APPLICATION_FORM_FILE_FOLDER = Yii::$app->params['bcdatapath'];
                    $APPLICATION_FORM_FILE_FOLDER = $APPLICATION_FORM_FILE_FOLDER . "bcselection/bcprofile/";

                    if (!file_exists($APPLICATION_FORM_FILE_FOLDER . $this->srlm_bc_selection_user_id)) {
                        mkdir($APPLICATION_FORM_FILE_FOLDER . $this->srlm_bc_selection_user_id);
                        chmod($APPLICATION_FORM_FILE_FOLDER . $this->srlm_bc_selection_user_id, 0777);
                    }
                    $APPLICATION_FORM_FILE_FOLDER=$APPLICATION_FORM_FILE_FOLDER . $this->srlm_bc_selection_user_id;
                    $content = base64_decode(\Yii::$app->request->post()['BCSareeAckForm']['get_saree2_quality_photo']);
                    $im = imagecreatefromstring($content);
                    $image_name = 'saree2_photo_' . uniqid() . '.jpg';
                    $this->bc_saree_model->get_saree2_quality_photo = $image_name;
                    if ($im !== false) {
                        header('Content-Type: image/jpeg');
                        imagejpeg($im, $APPLICATION_FORM_FILE_FOLDER . '/' . $image_name);
                        chmod($APPLICATION_FORM_FILE_FOLDER . '/' . $image_name, 0777);
                        try {
                            $file = new FileHelpers();
                            $file->file_path = $APPLICATION_FORM_FILE_FOLDER;
                            $file->file_name = $image_name;
                            $file->upload();
                        } catch (\Exception $ex) {
                            
                        }
                        imagedestroy($im);
                    }
                }
            }
        }
        $this->bc_saree_model->save();
        return $this->bc_saree_model;
    }

}
