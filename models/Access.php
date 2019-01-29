<?php

namespace app\models;

/**
 * This is the model class for table "access".
 *
 * @property int $id
 * @property string $title 权限标题
 * @property string $urls 对应页面的url
 * @property int $status 状态，1=>有效，0=>无效
 * @property string $updated_time 最后更新时间
 * @property string $created_time 插入时间
 */
class Access extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'access';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'urls'], 'required'],
            [['status'], 'integer'],
            [['updated_time', 'created_time'], 'safe'],
            [['title'], 'string', 'max' => 50],
            [['urls'], 'string', 'max' => 1000],
            [['title'], 'validateTitle'],
        ];
    }

    /**
     * 验证title唯一性
     * @param $attribute
     * @param $params
     * user: trina
     */
    public function validateTitle($attribute, $params)
    {
        $model = $this->getAccessByTitle($this->title, $this->id);
        if ($model) {
            $this->addError($attribute, "该标题名称已存在，请输入其他名称。");
        }
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'urls' => 'Urls',
            'status' => 'Status',
            'updated_time' => 'Updated Time',
            'created_time' => 'Created Time',
        ];
    }

    /**
     * 列表页面
     * @return array|\yii\db\ActiveRecord[]
     * user: trina
     */
    public function getAll()
    {
        return self::find()->all();
    }

    /**
     * 添加/编辑验证唯一性
     * @param $title
     * @param $id
     * @return array|null|\yii\db\ActiveRecord
     * user: trina
     */
    public function getAccessByTitle($title, $id)
    {
        return self::find()->where(['title' => $title])->andFilterWhere(['<>', 'id', $id])->one();
    }

    public function getAccessById($id)
    {
        return self::find()->where(['id' => $id])->one();
    }
}
