<?php

/**
 * @author : livingxue
 */
namespace api\modules\v1\service;

use Yii;
use api\modules\v1\models\Email;
use api\modules\v1\models\JoinCode;
use api\modules\v1\models\User;
use api\modules\v1\models\UserData;

class UserService
{
	public static function Join($email,$name,$nickname,$password)
	{
		$user = new User();
		if($user->checkname($name)){
			return '用户名重复';
		}
		$user->name = $name;
		$user->nickname = empty($nickname) ? $nickname: $name;
		$user->password = Yii::$app->security->generatePasswordHash($password);
		$user->created_at = time();
		$user->updated_at = time();
		$user->status = User::STATUS_NOTCHECK;
		$user->save();
		
		$userdata = new UserData();
		$userdata->id = $user->id;
		$userdata->email = $email;
		$userdata->email_status = -1;
		$userdata->save();
		
		$joinCode = new JoinCode();
		$joinCode->user_id = $user->id;
		$joinCode->created_at = time();
		$joinCode->end_time = time()+Yii::$app->params['join']['email_time'];
		$joinCode->code = Yii::$app->security->generateRandomString ();
		$joinCode->status = 0;
		$joinCode->type = JoinCode::TYPE_JOIN;
		$joinCode->save();
		
		$send_data = '请点击以下链接完成注册:'.Yii::$app->params['join']['url'].'?uid='.$user->id.'&code='.$joinCode->code;
		
		$email = new Email();
		if($email->sendEmail($email, $send_data)){
			return null;
		}else{
			return '发送失败';
		}
	}
	
	public static function checkEmail($uid,$code)
	{
		$joincode = JoinCode::find()->where(['user_id'=>$uid,'status'=>0])->andWhere( ['<', 'end_time', time()])->orderBy('created_at')->one();
		if(empty($joincode)){
			return false;
		}
		if($joincode->code != $code){
			$joincode->status = 1;
			return !$joincode->save();
		}
		$joincode->status = 1;
		$user = User::findOne(['id'=>$uid]);
		$user->status = User::STATUS_NORMAL;
		
		$userdata = UserData::findOne(['id'=>$uid]);
		$userdata->email_status = 0;
		
		return $user->save()&&$user->save();
	}
	
	public static function login($name,$password)
	{
		$user = User::find()->select('password')->where(['name'=>$name])->andWhere(['>','status',User::STATUS_NORMAL])->asArray()->one();
		if(Yii::$app->security->validatePassword($password,$user['password'])){
			$access_token = Yii::$app->security->generateRandomString ();
			$redis = Yii::$app->redis;
			$redis->set($access_token,$user->id);
			$redis->expire($access_token,3600);
			return $access_token;
		}else{
			return false;
		}
	}
}