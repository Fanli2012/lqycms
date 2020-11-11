<?php
namespace App\Http\Controllers\Api;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Common\ReturnData;
use App\Common\Helper;
use App\Common\Token;
use App\Http\Model\Bonus;
use App\Http\Logic\BonusLogic;
use App\Http\Model\UserBonus;

class BonusController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function getLogic()
    {
        return logic('Bonus');
    }
    
    //可用获取的优惠券列表
    public function bonusList(Request $request)
	{
        //参数
        $limit = $request->input('limit', 10);
        $offset = $request->input('offset', 0);
        $where = function ($query) use ($request) {
            $query->where('delete_time', 0)->where('status', Bonus::STATUS)->where('start_time', '<', date('Y-m-d H:i:s'))->where('end_time', '>', date('Y-m-d H:i:s'))->where(function ($query2){$query2->where('num', '=', -1)->orWhere('num', '>', 0);});
        };
        //var_dump(model('Bonus')->where($where)->toSql());exit;
        $res = $this->getLogic()->getList($where, '', '*', $offset, $limit);
		
        /* if($res['count']>0)
        {
            foreach($res['list'] as $k=>$v)
            {
                
            }
        } */
        
		return ReturnData::create(ReturnData::SUCCESS, $res);
    }
    
    public function bonusDetail(Request $request)
	{
        //参数
        if(!checkIsNumber($request->input('id',null))){return ReturnData::create(ReturnData::PARAMS_ERROR);}
        $id = $request->input('id');
        $where['id'] = $id;
        $where['status'] = Bonus::STATUS;
        $where['delete_time'] = 0;
        
        $res = $this->getLogic()->getOne($where);
		if(!$res)
		{
			return ReturnData::create(ReturnData::RECORD_NOT_EXIST);
		}
        
		return ReturnData::create(ReturnData::SUCCESS,$res);
    }
    
    //添加
    public function bonusAdd(Request $request)
    {
        if(Helper::isPostRequest())
        {
            return $this->getLogic()->add($_POST);
        }
    }
    
    //修改
    public function bonusUpdate(Request $request)
    {
        if(!checkIsNumber($request->input('id',null))){return ReturnData::create(ReturnData::PARAMS_ERROR);}
        $id = $request->input('id');
        
        if(Helper::isPostRequest())
        {
            unset($_POST['id']);
            $where['id'] = $id;
            $where['status'] = Bonus::STATUS;
            $where['delete_time'] = 0;
            //$where['user_id'] = Token::$uid;
            
            if($_POST['start_time'] >= $_POST['end_time'])
            {
                return ReturnData::create(ReturnData::PARAMS_ERROR,null,'有效期错误');
            }
            
            //正则验证时间格式，未作
            
            return $this->getLogic()->edit($_POST,$where);
        }
    }
    
    //删除
    public function bonusDelete(Request $request)
    {
        if(!checkIsNumber($request->input('id',null))){return ReturnData::create(ReturnData::PARAMS_ERROR);}
        $id = $request->input('id');
        
        if(Helper::isPostRequest())
        {
            $where['id'] = $id;
            //$where['user_id'] = Token::$uid;
            
            return $this->getLogic()->del($where);
        }
    }
}