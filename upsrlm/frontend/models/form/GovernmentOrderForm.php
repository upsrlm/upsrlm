<?php

namespace frontend\models\form;

use Yii;
use frontend\models\GovernmentOrder;
use yii\base\Model;

/**
 * GovernmentOrderForm is the model behind the GovernmentOrder
 * @author Habibur Rahman <rahman.kld@gmail.com>
 */
class GovernmentOrderForm extends Model {

    /**
     * {@inheritdoc}
     */
    public $id;
    public $title;
    public $description;
    public $date;
    public $issued_by;
    public $app;
    public $file;
    public $updated_by;
    public $created_by;
    public $updated_at;
    public $created_at;
    public $status;
    public $government_order_model;
    public $isNew;
    public $app_option = [];
    public $base_path;

    /**
     * {@inheritdoc}
     */
    public function __construct($model = null) {
        $this->base_path = Yii::$app->params['basepath'] . 'frontend/web/uploads/government_order';
        $this->app_option = [2 => 'BC Sakhi', 3 => 'CBO', 0 => 'Other'];
        $this->government_order_model = \Yii::createObject([
                    'class' => GovernmentOrder::className()
        ]);

        $this->isNew = true;
        if ($model != null) {
            $this->isNew = false;
            $this->government_order_model = $model;
            $this->id = $this->government_order_model->id;
            $this->title = $this->government_order_model->title;
            $this->description = $this->government_order_model->description;
            $this->date = $this->government_order_model->date != NULL ? \Yii::$app->formatter->asDatetime($this->government_order_model->date, "php:d-m-Y") : '';
            $this->issued_by = $this->government_order_model->issued_by;
            $this->file = $this->government_order_model->file;
            $this->app = $this->government_order_model->app;
        }
    }

    public function rules() {
        return [
            [['title'], 'required'],
            [['title'], 'trim'],
            [['description'], 'string'],
            [['description'], 'safe'],
            [['description'], 'default', 'value' => ''],
            [['date'], 'required'],
            [['date'], 'date', 'format' => 'php:d-m-Y'],
            [['app'], 'required'],
            [['app', 'created_by', 'updated_by', 'created_at', 'updated_at', 'status'], 'integer'],
            [['title'], 'string', 'max' => 1000],
            [['issued_by'], 'string', 'max' => 255],
            [['issued_by'], 'required'],
            [['issued_by'], 'trim'],
            [['file'], 'required', 'on' => ['create']],
            [['file'], 'file', 'skipOnEmpty' => true, 'extensions' => 'pdf'],
            [['file'], 'file', 'maxSize' => 1024 * 1024 * 2, 'tooBig' => 'Limit is 2MB'],
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

}
