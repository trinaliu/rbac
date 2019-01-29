<?php
/**
 * Created by PhpStorm.
 * user: trina
 * Date: 18-9-25
 * Time: 上午11:18
 */

namespace app\controllers;

use Yii;
use app\controllers\common\BaseController;
use app\models\Access;
use yii\helpers\Json;
use yii\web\NotFoundHttpException;

class AccessController extends BaseController
{
    /**
     * 列表页面
     * @return string
     * user: trina
     */
    public function actionIndex()
    {
        $models = (new Access())->getAll();

        return $this->render('index', [
            'models' => $models
        ]);
    }

    /**
     * 添加权限
     * @return string
     * user: trina
     */
    public function actionAdd()
    {
        if ($data = Yii::$app->request->post()) {
            $model = new Access();
            $model->title = $data['title'];
            $model->urls = $data['url'];
            if (!$model->save()) {
                return Json::encode(['status' => false, 'message' => "添加失败。", 'data' => $model->getErrors()]);
            }
            return Json::encode(['status' => true, 'message' => "添加成功。"]);
        }

        return $this->render('add');
    }

    /**
     * 编辑页面
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     * user: trina
     */
    public function actionEdit($id)
    {
        $model = (new Access())->getAccessById($id);
        if (!$model) {
            throw new NotFoundHttpException("该页面不存在");
        }
        if ($data = Yii::$app->request->post()) {
            $model->title = $data['title'];
            $model->urls = $data['url'];
            if (!$model->save()) {
                return Json::encode(['status' => false, 'message' => "添加失败。", 'data' => $model->getErrors()]);
            }
            return Json::encode(['status' => true, 'message' => "添加成功。"]);
        }
        return $this->render('edit', [
            'model' => $model
        ]);
    }
}