<?php
/**
 * Created by PhpStorm.
 * user: trina
 * Date: 18-10-26
 * Time: 上午11:10
 */

namespace app\models;

use yii\db\ActiveRecord;

class RoleAccess extends ActiveRecord
{
    public static function tableName()
    {
        return 'role_access';
    }

    public function rules()
    {
        return [
            [['role_id', 'access_id'], 'required'],
            [['role_id', 'access_id'], 'integer'],
            [['created_time'], 'safe']
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'role_id' => 'Role ID',
            'access_id' => 'Access ID',
            'created_time' => 'Created Time'
        ];
    }

    /**
     * 获取角色的权限
     * @param $roleId
     * @return array|ActiveRecord[]
     * user: trina
     */
    public function getRoleAccessByRoleId($roleId)
    {
        return self::find()->where(['role_id' => $roleId])->all();
    }

}