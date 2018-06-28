<?php

namespace console\models;

use api\modules\v1\models\Email;
use yii\base\BaseObject;
use yii\queue\RetryableJobInterface;
use yii\base\Exception;
use api\modules\v1\models\TodoList;
use api\modules\v1\models\UserData;

class SendMailJob2 extends BaseObject implements RetryableJobInterface {
	public $uid;
	public function execute($queue) {
		$user= UserData::find ()->select ( 'user_email' )->where ( [ 
				'id' => $this->uid 
		] )->one ();
		if(empty($email)){
			return true;//无此用户 直接返回正确 结束队列
		}
		$todolist = TodoList::find ()->select ( [ 
				'todo',
				'star_time',
				'end_time' 
		] )->where ( [ 
				'user_id' => $this->uid 
		] )->andWhere ( [ 
				'in',
				'status',
				[ 
						TodoList::STATUS_ONDO,
						TodoList::STATUS_NOTSTAR 
				] 
		] )->asArray ()->all ();
		
		if (empty ( $todolist )) {
			return true;//今日无事 直接退出队列
		} else {
			$str = '今日待办事项:' . PHP_EOL;
			foreach ( $todolist as $i => $todo ) {
				$str .= '任务' . $i . ':' . $todo ['todo'] . '  结束时间:' . date ( "m-d H:i", $todo ['end_time'] ) . PHP_EOL;
			}
			$str .= '今日事！今日毕！';
		}
		
		$email = new Email ();
		if ($email->sendEmail ( $user['user_email'], $str )) {
			return true;
		} else {
			throw new Exception ( '没有响应' );
		}
	}
	public function getTtr() {
		return 60; // 队列失败 一分钟后再次执行
	}
	public function canRetry($attempt, $error) {
		return ($attempt < 10) && ($error instanceof Exception);
	}
}
