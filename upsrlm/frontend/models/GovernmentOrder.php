<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "government_order".
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property string|null $date
 * @property string|null $issued_by
 * @property int $app
 * @property string|null $file
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int $status
 */
class GovernmentOrder extends \yii\db\ActiveRecord {

    public function behaviors() {
        return [
            [
                'class' => \yii\behaviors\BlameableBehavior::className(),
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
            ],
            [
                'class' => \yii\behaviors\TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => function() {
                    return time();
                },
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'government_order';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['title'], 'required'],
            [['title'], 'trim'],
            [['description'], 'string'],
            [['description'],'safe'],
            [['description'],'default','value'=>''],
            [['date'], 'safe'],
            [['app', 'created_by', 'updated_by', 'created_at', 'updated_at', 'status'], 'integer'],
            [['title'], 'string', 'max' => 1000],
            [['issued_by'], 'string', 'max' => 255],
            [['file'], 'string', 'max' => 500],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'description' => 'Description',
            'date' => 'Date',
            'issued_by' => 'Issued By',
            'app' => 'App',
            'file' => 'File',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }

    public function beforeSave($insert) {

        if ($this->date != null and $this->date != '') {
            $this->date = \Yii::$app->formatter->asDatetime($this->date, "php:Y-m-d");
        }

        return parent::beforeSave($insert);
    }

    public function getGoapp() {
        $array = [2 => 'BC Sakhi', 3 => 'CBO', 0 => 'Other'];
        return isset($array[$this->app]) ? $array[$this->app] : '';
    }

}
