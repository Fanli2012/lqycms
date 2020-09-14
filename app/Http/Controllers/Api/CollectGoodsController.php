<?php
namespace App\Http\Controllers\Api;
use Log;
use DB;
use Illuminate\Http\Request;
use App\Common\ReturnData;
use App\Common\Helper;
use App\Common\Token;
use App\Http\Model\CollectGoods;
use App\Http\Logic\CollectGoodsLogic;

class CollectGoodsController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function getLogic()
    {
        return logic('CollectGoods');
    }
    
    public function collectGoodsList(Request $request)
	{
        //参数
        $limit = $request->input('limit', 10);
        $offset = $request->input('offset', 0);
        $where['user_id'] = Token::$uid;
        if($request->input('is_attention', null) !== null){$where['is_attention'] = $request->input('is_attention');}
        
        $res = $this->getLogic()->getList($where, array('id', 'desc'), '*', $offset, $limit);
		
        /* if($res['count']>0)
        {
            foreach($res['list'] as $k=>$v)
            {
                
            }
        } */
        
		return ReturnData::create(ReturnData::SUCCESS,$res);
    }
    
    public function collectGoodsDetail(Request $request)
	{
        //参数
        if(!checkIsNumber($request->input('id',null))){return ReturnData::create(ReturnData::PARAMS_ERROR);}
        $id = $request->input('id');
        $where['id'] = $id;
        
        $res = $this->getLogic()->getOne($where);
		if(!$res)
		{
			return ReturnData::create(ReturnData::RECORD_NOT_EXIST);
		}
        
		return ReturnData::create(ReturnData::SUCCESS,$res);
    }
    
    //收藏商品
    public function collectGoodsAdd(Request $request)
    {
        if(Helper::isPostRequest())
        {
            $_POST['user_id'] = Token::$uid;
            
            return $this->getLogic()->add($_POST);
        }
    }
    
    //修改
    public function collectGoodsUpdate(Request $request)
    {
        if(!checkIsNumber($request->input('id',null))){return ReturnData::create(ReturnData::PARAMS_ERROR);}
        $id = $request->input('id');
        
        if(Helper::isPostRequest())
        {
            unset($_POST['id']);
            $where['id'] = $id;
            $where['user_id'] = Token::$uid;
            
            return $this->getLogic()->edit($_POST,$where);
        }
    }
    
    //取消收藏商品
    public function collectGoodsDelete(Request $request)
    {
        if(!checkIsNumber($request->input('goods_id',null))){return ReturnData::create(ReturnData::PARAMS_ERROR);}
        $goods_id = $request->input('goods_id');
        
        if(Helper::isPostRequest())
        {
            $where['goods_id'] = $goods_id;
            $where['user_id'] = Token::$uid;
            
            return $this->getLogic()->del($where);
        }
    }
}