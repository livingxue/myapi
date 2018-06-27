<?php

/**
 * @author : livingxue
 */
namespace api\modules\v1\service;

use api\modules\v1\models\TodoList;

class TodoService {
	public static function Add($uid, $todo, $startime, $endtime) {
		$model = new TodoList ();
		$model->user_id = $uid;
		$model->todo = $todo;
		$model->star_time = $startime;
		$model->end_time = $endtime;
		$model->status = TodoList::STATUS_NOTSTAR;
		return $model->save ();
	}
	public static function Update($id, $uid, $todo, $startime, $endtime, $status) {
		$model = TodoList::findOne ( [ 
				'id' => $id,
				'user_id' => $uid 
		] );
		if (empty ( $model )) {
			return false;
		}
		
		$model->todo = $todo;
		$model->star_time = $startime;
		$model->end_time = $endtime;
		if ($status >= - 1 && $status <= 2) {
			$model->status = $status;
		}
		return $model->save ();
	}
	public static function Delete($id, $uid) {
		$model = TodoList::findOne ( [ 
				'id' => $id,
				'user_id' => $uid 
		] );
		if (empty ( $model )) {
			return false;
		}
		return $model->delete ();
	}
	public static function Index($uid, $last_id, $status) {
		return TodoList::find ()->select ( [ 
				'todo','star_time','end_time','status' 
		] )->where ( [ 
				'user_id' => $uid 
		] )->andWhere ( [ 
				'>','id',$last_id
		] )->andFilterWhere ( [ 
				'status' => $status 
		] )->orderBy ( [ 
				'star_time' 
		] )->limit ( 20 )->all ();
	}
	public static function One($id, $uid) {
		return TodoList::findOne ( [ 
				'id' => $id,
				'user_id' => $uid 
		] );
	}
}