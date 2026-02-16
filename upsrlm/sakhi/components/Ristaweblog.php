<?php

namespace sakhi\components;

use yii;
use cbo\models\CboClfSearch;
use cbo\models\CboVoSearch;
use cbo\models\ShgSearch;
use cbo\models\CboClf;
use cbo\models\CboVo;
use cbo\models\Shg;
use sakhi\components\App;
use common\models\base\GenralModel;
use common\models\User;
use cbo\models\sakhi\RishtaWebLog;

class Ristaweblog extends \yii\base\Component {

    public $type;
    public $type_id;
    public $type_url;
    public $user_id;
    public $app_version;
    public $datetime;
    public $user_model;
    public $rishtaweblog_model;

    public function __construct($user_model=null) {
        $this->user_model = $user_model;
        $this->rishtaweblog_model = new \cbo\models\sakhi\RishtaWebLog();
    }

    public function save() {
        $user_model = $this->user_model;
        if ($this->user_model != null) {
            $this->rishtaweblog_model->type = $this->type;
            $this->rishtaweblog_model->type_id = $this->type_id;
            $this->rishtaweblog_model->type_url = $this->type_url;
            $this->rishtaweblog_model->user_id = $this->user_model->id;
            $this->rishtaweblog_model->app_version = $this->user_model->app_version;
            $this->rishtaweblog_model->datetime = date('Y-m-d H:i:s');

            $this->rishtaweblog_model->save();
        }
        return $this;
    }

}
