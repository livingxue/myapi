<?php

namespace api\modules\v1\models;

use Yii;

/**
 * This is the model class for table "{{%email}}".
 *
 * @property integer $id
 * @property string $send_from
 * @property string $send_to
 * @property string $send_data
 * @property string $send_html
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class Email extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%email}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['send_from', 'send_to', 'send_data', 'send_html', 'created_at', 'updated_at'], 'required'],
            [['send_data', 'send_html'], 'string'],
            [['status', 'created_at', 'updated_at'], 'integer'],
            [['send_from', 'send_to'], 'string', 'max' => 128],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'send_from' => 'Send From',
            'send_to' => 'Send To',
            'send_data' => 'Send Data',
            'send_html' => 'Send Html',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
    
    public function sendEmail($send_to,$send_data)
    {
    	$send = Yii::$app->mailer->compose();
    	
    	$send->setTo($send_to);
    	$send->setTextBody($send_data);
    	if(!$send->send()){
    		return false;
    	}
    	$model = new Email();
    	$model->send_from = 'null';
    	$model->send_to = $send_to;
    	$model->send_data = $send_data;
    	$model->send_html = 'null';
    	$model->created_at = time();
    	$model->updated_at = time();
    	
    	return $model->save();
    }
}
