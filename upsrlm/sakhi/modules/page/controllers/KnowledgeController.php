<?php

namespace sakhi\modules\page\controllers;

use yii\web\Controller;

/**
 * Default controller for the `page` module
 */
class KnowledgeController extends Controller {

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionCard1() {
        return $this->render('card1');
    }

    public function actionCard2() {
        return $this->render('card2');
    }

    public function actionCard3() {
        return $this->render('card4');
    }

    public function actionCard4() {
        return $this->render('card4');
    }

    public function actionCard5() {
        return $this->render('card5');
    }

    public function actionCard6() {
        return $this->render('card6');
    }

    public function actionCard7() {
        return $this->render('card7');
    }

    public function actionCard8() {
        $cards = [
            '/images/flash/card8/1.jpg',
            '/images/flash/card8/2.jpg',
            '/images/flash/card8/3.jpg',
            '/images/flash/card8/4.jpg',
            '/images/flash/card8/5.jpg',
            '/images/flash/card8/6.jpg',
            '/images/flash/card8/7.jpg',
            '/images/flash/card8/8.jpg',
            '/images/flash/card8/9.jpg',
            '/images/flash/card8/10.jpg',
            '/images/flash/card8/11.jpg',
            '/images/flash/card8/12.jpg',
            '/images/flash/card8/13.jpg',
            '/images/flash/card8/14.jpg',
            '/images/flash/card8/15.jpg',
            '/images/flash/card8/16.jpg',
            '/images/flash/card8/17.jpg',
            '/images/flash/card8/18.jpg',
            '/images/flash/card8/19.jpg',
            '/images/flash/card8/20.jpg',
            '/images/flash/card8/21.jpg',
            '/images/flash/card8/22.jpg',
            '/images/flash/card8/23.jpg',
            '/images/flash/card8/24.jpg',
            '/images/flash/card8/25.jpg',
            '/images/flash/card8/26.jpg',
            '/images/flash/card8/27.jpg',
            '/images/flash/card8/28.jpg',
            '/images/flash/card8/29.jpg',
            '/images/flash/card8/30.jpg',
            '/images/flash/card8/31.jpg',
            '/images/flash/card8/32.jpg',
        ];
        return $this->render('card8',['cards'=>$cards]);
    }

    public function actionCard9() {
        return $this->render('card9');
    }

}
