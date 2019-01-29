<?php
/**
 * Created by PhpStorm.
 * User: trina
 * Date: 18-9-18
 * Time: 下午5:21
 */

namespace app\controllers;


use app\controllers\common\BaseController;

class TestController extends BaseController
{
    public function actionPageOne()
    {
        return $this->render('page-one');
    }

    public function actionPageTwo()
    {
        return $this->render('page-two');
    }

    public function actionPageThree()
    {
        return $this->render('page-three');
    }

    public function actionPageFour()
    {
        return $this->render('page-four');
    }
}