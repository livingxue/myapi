<?php

namespace api\modules\v1\models;

use Yii;

/**
 * This is the model class for table "{{%todo_list}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $todo
 * @property integer $star_time
 * @property integer $end_time
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $status
 */
class TodoList extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%todo_list}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'todo', 'star_time', 'end_time', 'created_at', 'updated_at'], 'required'],
            [['user_id', 'star_time', 'end_time', 'created_at', 'updated_at', 'status'], 'integer'],
            [['todo'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'todo' => 'Todo',
            'star_time' => 'Star Time',
            'end_time' => 'End Time',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }
}
