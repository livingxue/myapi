<?php

/**
 * @author : livingxue
 */
namespace api\modules\v1\service;

use Yii;
use backend\modules\restaurant\models\Food;
use backend\modules\restaurant\models\FoodSKU;
use backend\modules\restaurant\models\FoodOrder;
use backend\modules\restaurant\models\OrderFood;
use backend\modules\restaurant\models\FoodProperty;
use backend\modules\restaurant\models\FoodPropertychild;
use backend\modules\restaurant\models\PrintTemplate;
use backend\modules\admin\models\Site;
use backend\modules\admin\models\Admin;
use common\extensions\ylyprint;
use backend\modules\restaurant\models\Prints;
use backend\modules\restaurant\models\OrderFoodAction;
use common\extensions\printcenter;
use backend\modules\restaurant\models\FoodOrderRefund;

class UserService
{
	public static function sendEmail($email,$code,$type=1,$user_id=null)
	{
		
	}
}