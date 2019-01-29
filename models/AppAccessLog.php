<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "app_access_log".
 *
 * @property int $id
 * @property int $uid 品牌UID
 * @property string $target_url 访问的url
 * @property string $query_params get和post参数
 * @property string $ua 访问ua
 * @property string $ip 访问ip
 * @property string $note json格式备注字段
 * @property string $created_time
 */
class AppAccessLog extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'app_access_log';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['uid'], 'integer'],
            [['query_params'], 'required'],
            [['query_params'], 'string'],
            [['created_time'], 'safe'],
            [['target_url', 'ua'], 'string', 'max' => 255],
            [['ip'], 'string', 'max' => 32],
            [['note'], 'string', 'max' => 1000],
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
            'target_url' => 'Target Url',
            'query_params' => 'Query Params',
            'ua' => 'Ua',
            'ip' => 'Ip',
            'note' => 'Note',
            'created_time' => 'Created Time',
        ];
    }
}
