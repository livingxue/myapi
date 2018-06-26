<?php

namespace api\modules\v1\models;

use Yii;

/**
 * This is the model class for table "{{%join_code}}".
 *
 * @property integer $id
 * @property integer $created_at
 * @property integer $end_time
 * @property integer $status
 * @property integer $type
 * @property integer $user_id
 * @property string $code
 */
class JoinCode extends \yii\db\ActiveRecord
{
	const TYPE_JOIN = 1;//注册
	const TYPE_FINDPASSWORD = 2;//找回密码
	
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%join_code}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_at', 'end_time', 'status', 'type', 'user_id', 'code'], 'required'],
            [['created_at', 'end_time', 'status', 'type', 'user_id'], 'integer'],
            [['code'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'created_at' => 'Created At',
            'end_time' => 'End Time',
            'status' => 'Status',
            'type' => 'Type',
            'user_id' => 'User ID',
            'code' => 'Code',
        ];
    }
}
