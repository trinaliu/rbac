<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_role".
 *
 * @property int $id
 * @property int $uid 对应user表的id字段
 * @property int $role_id 对应role表的id字段
 * @property string $created_time 插入时间
 */
class UserRole extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_role';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['uid', 'role_id'], 'required'],
            [['uid', 'role_id'], 'integer'],
            [['created_time'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'uid' => 'Uid',
            'role_id' => 'Role ID',
            'created_time' => 'Created Time',
        ];
    }

    public function getRole()
    {
        return $this->hasOne(Role::className(), ['id' => 'role_id']);
    }
}
