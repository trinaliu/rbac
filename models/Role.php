<?php

namespace app\models;

/**
 * This is the model class for table "role".
 *
 * @property int $id
 * @property string $name 角色名称
 * @property int $status 状态；1=>有效，0=>无效
 * @property string $updated_time 最后一次更新时间
 * @property string $created_time 插入时间
 */
class Role extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'role';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['status'], 'integer'],
            [['updated_time', 'created_time'], 'safe'],
            [['name'], 'string', 'max' => 50],
            [['name'], 'validateName'],
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
        $model = $this->getRoleByName($this->name, $this->id);
        if ($model) {
            $this->addError($attribute, "该角色名称已存在，请输入其他名称。");
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
            'status' => 'Status',
            'updated_time' => 'Updated Time',
            'created_time' => 'Created Time',
        ];
    }

    /**
     * 创建/编辑页面验证name
     * @param $name
     * @param $id
     * @return array|null|\yii\db\ActiveRecord
     * User: trina
     */
    public function getRoleByName($name, $id)
    {
        return self::find()->where(['name' => $name])->andFilterWhere(['<>', 'id', $id])->one();
    }

    /**
     * 列表页面
     * @return array|\yii\db\ActiveRecord[]
     * User: trina
     */
    public function getAll()
    {
        return self::find()->all();
    }

    /**
     * 编辑页面
     * @param $id
     * @return array|null|\yii\db\ActiveRecord
     * User: trina
     */
    public function getOne($id)
    {
        return self::find()->where(['id' => $id])->one();
    }
}
