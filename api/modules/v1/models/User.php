<?php

namespace api\modules\v1\models;

use Yii;

/**
 * This is the model class for table "pre_user".
 *
 * @property integer $id
 * @property string $email
 * @property string $name
 * @property string $password
 * @property integer $created_at
 * @property string $updated_at
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email','password', 'created_at','updated_at'], 'required'],
            [['created_at', 'updated_at'], 'integer'],
            [['email', 'name','password'], 'string', 'max' => 128],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '用户名',
            'password' => '密码',
            'email' => '邮箱',
            'created_at' => '创建时间',
            'updated_at' => '修改时间'
        ];
    }
}
