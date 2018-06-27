<?php
/**
 * @author : livingxue
 */

namespace api\modules\v1\controllers;

use Yii;
use api\base\BaseController;
use api\modules\v1\service\UserService;

class UserController extends BaseController
{
	public function acitonJoin()
	{
		$email = Yii::$app->request->post('email');
		$name = Yii::$app->request->post('name');
		$nickname = Yii::$app->request->post('nickname');
		$password = Yii::$app->request->post('password');
		
		if(empty($msg = UserService::Join($email, $name, $nickname, $password))){
			return $this->jsonSuccess('','邮件已发送，请注意查收');
		}else{
			return $this->jsonFail($msg,'注册失败');
		}
	}
	public function actionCheck()
	{
		$code = Yii::$app->request->get('code');
		$uid = Yii::$app->request->post('uid');
		
	}
	public function actionLogin()
	{
		$name = Yii::$app->request->post('name');
		$password = Yii::$app->request->post('password');
		$access_token = UserService::login($name, $password);
		if(!empty($access_token)){
			return $this->jsonSuccess($access_token,'登陆成功');
		}else{
			return $this->jsonFail('','登陆失败');
		}
	}
}
