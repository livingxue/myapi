<?php

namespace api\modules\v1\models;

use Yii;

/**
 * This is the model class for table "{{%user_data}}".
 *
 * @property integer $id
 * @property string $user_email
 * @property integer $email_status
 * @property string $user_openid
 * @property integer $openid_status
 */
class UserData extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_data}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'email_status', 'openid_status'], 'integer'],
            [['user_email', 'user_openid'], 'string', 'max' => 128],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_email' => 'User Email',
            'email_status' => 'Email Status',
            'user_openid' => 'User Openid',
            'openid_status' => 'Openid Status',
        ];
    }
}
