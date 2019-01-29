<?php
/**
 * Created by PhpStorm.
 * User: trina
 * Date: 18-9-18
 * Time: 下午2:12
 */

namespace app\controllers;

use app\models\UserRole;
use Yii;
use app\controllers\common\BaseController;
use app\models\Role;
use app\models\User;
use app\services\UrlService;
use yii\db\Exception;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\NotFoundHttpException;

class UserController extends BaseController
{
    /**
     * 用户登录页面
     * @return string
     * User: trina
     */
    public function actionLogin()
    {
        return $this->render("login", [
            'host' => $_SERVER['HTTP_HOST']
        ]);
    }

    /**
     * 伪登录
     * @return \yii\web\Response
     * user: trina
     */
    public function actionVLogin()
    {
        $uid = $this->get("uid", 0);
        $back_url = UrlService::buildUrl('/');
        if (!$uid) {
            return $this->redirect($back_url);
        }
        $user_info = User::find()->where(['id' => $uid])->one();
        if (!$user_info) {
            return $this->redirect($back_url);
        }
        //cookie保存用户的登录状态，所以cookie值需要加密，规则：user_auth_token + '#' + uid
        $this->createLoginStatus($user_info);

        return $this->redirect($back_url);
    }

    /**
     * 列表页面
     * @return string
     * user: trina
     */
    public function actionIndex()
    {
        $models = (new User())->getAll();

        return $this->render('index', [
            'models' => $models
        ]);
    }

    /**
     * 添加用户
     * @return string
     * @throws Exception
     * user: trina
     */
    public function actionAdd()
    {
        $roleModels = (new Role())->getAll();
        if ($data = Yii::$app->request->post()) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $model = new User();
                $model->name = $data['name'];
                $model->email = $data['email'];
                $model->updated_time = date("Y-m-d H:i:s");
                $model->created_time = date("Y-m-d H:i:s");
                if (!$model->save()) {
                    return Json::encode(['status' => false, 'message' => '添加失败。', 'data' => $model->getErrors()]);
                }

                if (isset($data['role']) && count($data['role'])) {
                    foreach ($data['role'] as $role) {
                        $userRole = new UserRole();
                        $userRole->uid = $model->id;
                        $userRole->role_id = $role;
                        $userRole->created_time = date("Y-m-d H:i:s");
                        if (!$userRole->save()) {
                            return Json::encode(['status' => false, 'message' => '添加失败。', 'data' => $userRole->getErrors()]);
                        }
                    }
                }
                $transaction->commit();
                return Json::encode(['status' => true, 'message' => '添加成功。']);
            } catch (Exception $e) {
                $transaction->rollBack();
                return Json::encode(['status' => false, 'message' => $e->getMessage()]);
            }
        }
        return $this->render('add', [
            'roleModels' => $roleModels
        ]);
    }

    /**
     * @param $id
     * @return string
     * @throws Exception
     * @throws NotFoundHttpException
     * user: trina
     */
    public function actionEdit($id)
    {
        $model = (new User())->getOne($id);
        $roleId = ArrayHelper::getColumn($model->userRole, 'role_id');
        $roleModels = (new Role())->getAll();
        if (!$model) {
            throw new NotFoundHttpException('该页面不存在');
        }

        if ($data = Yii::$app->request->post()) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $model->name = $data['name'];
                $model->email = $data['email'];
                $model->updated_time = date("Y-m-d H:i:s");
                if (!$model->save()) {
                    return Json::encode(['status' => false, 'message' => '添加失败。', 'data' => $model->getErrors()]);
                }

                //更新user role
                $data['role'] = isset($data['role']) ? $data['role'] : [];
                $add = array_diff($data['role'], $roleId);
                $delete = array_diff($roleId, $data['role']);
                //添加
                if (count($add)) {
                    foreach ($add as $addRole) {
                        $userRole = new UserRole();
                        $userRole->uid = $model->id;
                        $userRole->role_id = $addRole;
                        $userRole->created_time = date("Y-m-d H:i:s");
                        if (!$userRole->save()) {
                            return Json::encode(['status' => false, 'message' => '添加失败。', 'data' => $userRole->getErrors()]);
                        }
                    }
                }
                //删除
                if (count($delete)) {
                    foreach ($delete as $deleteRole) {
                        UserRole::find()->where(['role_id' => $deleteRole])->one()->delete();
                    }
                }

                $transaction->commit();
                return Json::encode(['status' => true, 'message' => '添加成功。']);
            } catch (Exception $e) {
                $transaction->rollBack();
                return Json::encode(['status' => false, 'message' => $e->getMessage()]);
            } catch (\Throwable $e) {
                $transaction->rollBack();
                return Json::encode(['status' => false, 'message' => $e->getMessage()]);
            }
        }

        return $this->render('edit', [
            'model' => $model,
            'roleModels' => $roleModels,
            'roleId' => $roleId
        ]);
    }
}