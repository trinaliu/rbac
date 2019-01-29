<?php
/**
 * Created by PhpStorm.
 * User: trina
 * Date: 18-9-18
 * Time: 下午5:26
 */

namespace app\controllers;


use app\controllers\common\BaseController;

class DefaultController extends BaseController
{
    public function actionIndex()
    {
        return $this->render('index');
    }
}