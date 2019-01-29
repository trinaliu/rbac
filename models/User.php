<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $name 用户名
 * @property string $email 用户邮箱
 * @property int $is_admin 是否为管理员；1=>是管理员，0=>不是管理员
 * @property int $status 状态；1=>有效，0=>无效
 * @property string $updated_time 最后一次更新时间
 * @property string $created_time 插入时间
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'email'], 'required'],
            [['is_admin', 'status'], 'integer'],
            [['updated_time', 'created_time'], 'safe'],
            [['name'], 'string', 'max' => 20],
            [['email'], 'string', 'max' => 30],
            [['name'], 'validateName'],
            [['email'], 'validateEmail'],
            [['email'], 'match', 'pattern' => '/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/', 'message' => '邮箱格式不正确。']
        ];
    }

    /**
     * 验证name唯一性
     * @param $attribute
     * @param $params
     * User: trina
     */
    public function validateName($attribute, $params)
    {
        $model = $this->getUserByName($this->name, $this->id);
        if ($model) {
            $this->addError($attribute, "该姓名已存在，请输入其他姓名。");
        }
    }

    /**
     * 验证邮箱唯一性
     * @param $attribute
     * @param $params
     * user: trina
     */
    public function validateEmail($attribute, $params)
    {
        $model = $this->getUserByEmail($this->email, $this->id);
        if ($model) {
            $this->addError($attribute, "该邮箱已存在，请输入其他邮箱。");
        }
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'email' => 'Email',
            'is_admin' => 'Is Admin',
            'status' => 'Status',
            'updated_time' => 'Updated Time',
            'created_time' => 'Created Time',
        ];
    }

    public function getUserRole()
    {
        return $this->hasMany(UserRole::className(), ['uid' => 'id']);
    }

    /**
     * 获取所有user，列表页面
     * @return array|\yii\db\ActiveRecord[]
     * user: trina
     */
    public function getAll()
    {
        return self::find()->all();
    }

    /**
     * 创建/编辑页面验证name
     * @param $name
     * @param $id
     * @return array|null|\yii\db\ActiveRecord
     * user: trina
     */
    public function getUserByName($name, $id)
    {
        return self::find()->where(['name' => $name])->andFilterWhere(['<>', 'id', $id])->one();
    }

    /**
     * 验证email
     * @param $email
     * @param $id
     * @return array|null|\yii\db\ActiveRecord
     * user: trina
     */
    public function getUserByEmail($email, $id)
    {
        return self::find()->where(['email' => $email])->andFilterWhere(['<>', 'id', $id])->one();
    }

    /**
     * 获取单条user
     * @param $id
     * @return array|null|\yii\db\ActiveRecord
     * user: trina
     */
    public function getOne($id)
    {
        return self::find()->where(['id' => $id])->one();
    }
}
