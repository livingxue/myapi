<?php

namespace api\modules\v1\models;

use Yii;

/**
 * This is the model class for table "pre_user".
 *
 * @property integer $id
 * @property string $nickname
 * @property string $name
 * @property string $password
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $status
 * @property integer $todovip
 */
class User extends \yii\db\ActiveRecord
{
	const STATUS_NOTCHECK = -1;
	const STATUS_NORMAL = 0;
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
            [['nickname','password', 'created_at','updated_at'], 'required'],
            [['created_at', 'updated_at','status','todovip'], 'integer'],
            [['nickname', 'name','password'], 'string', 'max' => 128],
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
            'nickname' => '昵称',
            'created_at' => '创建时间',
            'updated_at' => '修改时间'
        ];
    }
    
    public function checkname($name)
    {
    	return User::find()->where(['name'=>$name])->count() > 0;
    }
}
