<?php
/**
 * Created by PhpStorm.
 * User: trina
 * Date: 18-9-19
 * Time: 上午9:27
 */

namespace app\controllers;

use app\models\Access;
use app\models\RoleAccess;
use Yii;
use app\controllers\common\BaseController;
use app\models\Role;
use yii\db\Exception;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\NotFoundHttpException;

class RoleController extends BaseController
{
    /**
     * 列表页面
     * @return string
     * User: trina
     */
    public function actionIndex()
    {
        $models = (new Role())->getAll();
        return $this->render('index', [
            'models' => $models
        ]);
    }

    /**
     * 添加页面
     * @return string
     * User: trina
     */
    public function actionAdd()
    {
        if ($data = Yii::$app->request->post()) {
            $model = new Role();
            $model->name = $data['name'];
            $model->created_time = date("Y-m-d H:i:s");
            $model->updated_time = date("Y-m-d H:i:s");
            if (!$model->save()) {
                return Json::encode(['status' => false, 'message' => "添加失败。", 'data' => $model->getErrors()]);
            }
            return Json::encode(['status' => true, 'message' => "添加成功。"]);
        }
        return $this->render('add');
    }

    /**
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     * User: trina
     */
    public function actionEdit($id)
    {
        $model = (new Role())->getOne($id);

        if (!$model) {
            throw new NotFoundHttpException("该页面不存在。");
        }
        if ($data = Yii::$app->request->post()) {
            $model->name = $data['name'];
            $model->updated_time = date("Y-m-d H:i:s");
            if (!$model->save()) {
                return Json::encode(['status' => false, 'message' => "添加失败。", 'data' => $model->getErrors()]);
            }
            return Json::encode(['status' => true, 'message' => "添加成功。"]);
        }
        return $this->render('edit', [
            'model' => $model
        ]);
    }

    /**
     * 设置权限页面
     * @param $id
     * @return string
     * user: trina
     */
    public function actionAddAccess($id)
    {
        if ($list = Yii::$app->request->post()) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                foreach ($list['accessIds'] as $accessId) {
                    $model = new RoleAccess();
                    $model->role_id = $id;
                    $model->access_id = $accessId;
                    $model->created_time = date("Y-m-d H:i:s");
                    if (!$model->save()) {
                        throw new Exception(implode("; ", $model->getErrors()));
                    }
                }
                $transaction->commit();

                return Json::encode(['status' => true, 'message' => "添加成功。"]);
            } catch (Exception $exception) {
                return Json::encode(['status' => false, 'message' => $exception->getMessage()]);
            }
        }
        $access = (new Access())->getAll();
        $roleAccess = (new RoleAccess())->getRoleAccessByRoleId($id);
        $data = ArrayHelper::getColumn($roleAccess, 'access_id');

        return $this->render('add-access', [
            'access' => $access,
            'data' => $data,
            'id' => $id
        ]);
    }
}