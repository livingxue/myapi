<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;
use api\modules\v1\models\TodoList;
use api\modules\v1\models\UserData;
use console\models\SendMailJob;
use api\modules\v1\models\Email;
use console\models\SendMailJob2;

class TodoController extends Controller {
	
	public function actionSendmail($param1) {
		//======= 直接根据id设立计划任务发送
		$user = UserData::find ()->select ( 'user_email' )->where ( [
				'id' => $param1
		] )->one ();
		if(empty($user)){
			return false;
		}

		$todolist = TodoList::find ()->select ( [ 
				'todo',
				'star_time',
				'end_time' 
		] )->where ( [ 
				'user_id' => $param1
		] )->andWhere ( [ 
				'in',
				'status',
				[ 
						TodoList::STATUS_ONDO,
						TodoList::STATUS_NOTSTAR 
				] 
		] )->asArray()->all ();
		
		if(empty($todolist)){
			$str = '今日无事！';
		}else{
			$str = '今日待办事项:'.PHP_EOL;
			foreach ($todolist as $i=>$todo)
			{
				$str .= '任务'.$i.':'.$todo['todo'].'  结束时间:'.date("m-d H:i",$todo['end_time']).PHP_EOL;
			}
			$str .= '今日事！今日毕！';
		}
		//队列跑
		//Yii::$app->queue->push(new SendMailJob(['email' => $email['user_email'],'str'=>$str]));
		//直接发送
		$email = new Email();
		if ($email->sendEmail ( $user['user_email'], $str )) {
			return true;
		} else {
			throw new \Exception( '没有响应' );
		}
	}
	
	public function actionSendmailQueue() {
		//2 ======= 通过队列实现
		$users = UserData::find(['id'])->where(['email_status'=>0])->asArray()->all();
		foreach ($users as $user)
		{
			Yii::$app->queue->push(new SendMailJob2(['uid' => $user]));
		}
		return true;
	}
}