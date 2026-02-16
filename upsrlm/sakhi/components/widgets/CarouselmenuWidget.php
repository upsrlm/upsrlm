<?php

namespace sakhi\components\widgets;

use yii;
use yii\base\Widget;
use yii\helpers\Html;

class CarouselmenuWidget extends Widget {

    public $active_url;
    public $display = TRUE;
    public $clfid;
    public $shgid;
    public $void;
    public $theme_base_url;

    public function init() {
        $this->RegisterJss();
    }

    public function run() {
        if (isset($_REQUEST['clfid'])) {
            $this->clfid = $_REQUEST['clfid'];
        }
        if (isset($_REQUEST['shgid'])) {
            $this->shgid = $_REQUEST['shgid'];
        }
        if (isset($_REQUEST['void'])) {
            $this->void = $_REQUEST['void'];
        }
        if ($this->display) {
            $this->active_url = explode('/', \Yii::$app->request->url);
            return $this->render('carouselmenu', [
                        'url' => isset($this->active_url[1]) ? $this->active_url[1] : '',
                        'clfid' => $this->clfid,
                        'shgid' => $this->void,
                        'voidl' => $this->void,
                        'theme_base_url' => $this->theme_base_url,
            ]);
        }
    }

    public function RegisterJss() {

        $view = $this->getView();

        $JS = <<<JS
         var owl = $('.owl-carousel');
            owl.owlCarousel({
                loop: false,
                nav: true,
                dots: false,
                navText: [
                "<i class='fa fa-caret-left'></i>",
                "<i class='fa fa-caret-right'></i>"
                ],
                margin: 10,
                responsive: {
                    320: {
                        items: 3
                    },

                    575: {
                        items: 4
                    },

                    767: {
                        items: 4
                    },

                }
            });
JS;
        $view->registerJS($JS);
    }

}

?>