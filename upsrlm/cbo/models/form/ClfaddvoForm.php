<?php

namespace cbo\models\form;

use Yii;
use yii\helpers\ArrayHelper;
use cbo\models\CboClf;
use cbo\models\CboVo;
use yii\base\Model;
use yii\web\UploadedFile;

/**
 * ClfaddvoForm is the model behind the CboClfVo
 * @author Habibur Rahman <rahman.kld@gmail.com>
 */
class ClfaddvoForm extends \yii\base\Model {

    public $id;
    public $cbo_clf_id;
    public $name_of_clf;
    public $cbo_vo_ids;
    public $created_at;
    public $created_by;
    public $updated_at;
    public $updated_by;
    public $status;
    public $clf_model;
    public $vo_option = [];

    public function __construct($clf_model) {
        $this->clf_model = $clf_model;
        $this->cbo_clf_id = $this->clf_model->id;
        $this->cbo_vo_ids = \yii\helpers\ArrayHelper::getColumn($this->clf_model->vos, 'cbo_vo_id');
        $all_vos = CboVo::find()->where(['block_code' => $this->clf_model->block_code, 'dummy_column' => \Yii::$app->user->identity->dummy_column])->andWhere(['is', 'cbo_clf_id', new \yii\db\Expression('null')])->orderBy('gram_panchayat_name asc')->all();
        $this->vo_option = ArrayHelper::map($all_vos, 'id', function($model) {
                    return $model->name_of_vo . ' (' . $model->block_name . ')' . ' (' . $model->gram_panchayat_name . ')';
                });
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['cbo_clf_id', 'cbo_vo_ids'], 'required'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'cbo_clf_id' => 'CLF/ क्लस्टर लेवल फेडरेशन/ क्लस्टर स्तरीय संकुल',
            'cbo_vo_ids' => 'Village Organization/ विलेज आर्गेनाइजेशन (ग्राम संगठन)',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }

    public function save() {
        try {

            if (isset($this->cbo_vo_ids) and is_array($this->cbo_vo_ids)) {
                foreach ($this->cbo_vo_ids as $cbo_vo_id) {
                    if ($cbo_vo_id) {
                        $clf_vo = CboVo::find()->where(['id' => $cbo_vo_id])->one();
                        if ($clf_vo != null) {
                            $clf_vo->cbo_clf_id = $this->clf_model->id;
                            $clf_vo->save();
                        }
                    }
                }
            }
            return $this;
        } catch (\Exception $ex) {
            print_r($ex->getMessage());
        }
    }

}
