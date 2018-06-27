<?php
/**
 * @author : livingxue
 */

namespace api\modules\v1\controllers;

use Yii;
use api\base\BaseController;
use api\modules\v1\service\UserService;
use api\modules\v1\service\TodoService;

class TodoController extends BaseController
{
	public function acitonCreate()
	{
		$uid = $this->getUser();
		$todo = Yii::$app->request->post('todo');
		$startime = Yii::$app->request->post('startime');
		$endtime = Yii::$app->request->post('endtime');
		
		if(TodoService::Add($uid, $todo, $startime, $endtime)){
			return $this->jsonSuccess('','添加成功');
		}else{
			return $this->jsonFail('','添加失败');
		}
	}
	public function acitonUpdate()
	{
		$uid = $this->getUser();
		$id = Yii::$app->request->post('id');
		$todo = Yii::$app->request->post('todo');
		$startime = Yii::$app->request->post('startime');
		$endtime = Yii::$app->request->post('endtime');
		$status = Yii::$app->request->post('status');
		if(TodoService::Update($id, $uid, $todo, $startime, $endtime, $status)){
			return $this->jsonSuccess('','修改成功');
		}else{
			return $this->jsonFail('','修改失败');
		}
	}
	public function acitonDelete()
	{
		$uid = $this->getUser();
		$id = Yii::$app->request->post('id');
		if(TodoService::Delete($id, $uid)){
			return $this->jsonSuccess('','删除成功');
		}else{
			return $this->jsonFail('','删除失败');
		}
	}
	public function actionIndex()
	{
		$uid = $this->getUser();
		$last_id = Yii::$app->request->get('last_id');
		$status = Yii::$app->request->get('status');
		return $this->jsonSuccess(TodoService::Index($uid, $last_id, $status));
		
	}
	public function actionView()
	{
		$uid = $this->getUser();
		$id = Yii::$app->request->get('id');
		return $this->jsonSuccess(TodoService::One($id, $uid));
	}
}
