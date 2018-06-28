<?php
namespace console\models;


use api\modules\v1\models\Email;
use yii\base\BaseObject;
use yii\queue\RetryableJobInterface;
use yii\base\Exception;

class SendMailJob extends BaseObject implements RetryableJobInterface
{
	public $email;
	public $str;
	
    public function execute($queue)
    {
    	$email = new Email();
    	if($email->sendEmail($this->email, $this->str)){
    		return true;
    	}else{
    		throw new Exception('没有响应');
    	}
    }
    public function getTtr()
    {
        return 60;//队列失败 一分钟后再次执行
    }
    
    public function canRetry($attempt, $error)
    {
        return ($attempt < 10) && ($error instanceof Exception);
    }
}
