<?php
namespace App\Http\Controllers\Api;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Common\ReturnData;
use App\Common\Helper;
use App\Common\Token;
use App\Http\Model\Cart;
use App\Http\Logic\CartLogic;

class CartController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function getLogic()
    {
        return logic('Cart');
    }
    
    public function cartList(Request $request)
	{
        //参数
        $where['user_id'] = Token::$uid;
        $res = $this->getLogic()->getList($where);
		
		return ReturnData::create(ReturnData::SUCCESS,$res);
    }
    
    public function cartDetail(Request $request)
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
    
    /**
     * 添加商品到购物车
     *
     * @access  public
     * @param   integer $goods_id     商品编号
     * @param   integer $goods_number 商品数量
     * @param   json   $property      规格值对应的id json数组，预留
     * @return  boolean
     */
    public function cartAdd(Request $request)
    {
        if(Helper::isPostRequest())
        {
            $_POST['user_id'] = Token::$uid;
            return $this->getLogic()->add($_POST);
        }
    }
    
    //修改
    public function cartUpdate(Request $request)
    {
        if(!checkIsNumber($request->input('id',null))){return ReturnData::create(ReturnData::PARAMS_ERROR);}
        $id = $request->input('id');
        
        if(Helper::isPostRequest())
        {
            unset($_POST['id']);
            $where['id'] = $id;
            //$where['user_id'] = Token::$uid;
            
            return $this->getLogic()->edit($_POST,$where);
        }
    }
    
    //删除
    public function cartDelete(Request $request)
    {
        if(!checkIsNumber($request->input('id',null))){return ReturnData::create(ReturnData::PARAMS_ERROR);}
        $id = $request->input('id');
        
        if(Helper::isPostRequest())
        {
            $where['id'] = $id;
            $where['user_id'] = Token::$uid;
            
            return $this->getLogic()->del($where);
        }
    }
    
    //清空购物车
    public function cartClear(Request $request)
    {
        if(Helper::isPostRequest())
        {
            $where['user_id'] = Token::$uid;
            
            return $this->getLogic()->del($where);
        }
    }
    
    //购物车结算商品列表
    public function cartCheckoutGoodsList(Request $request)
	{
        //参数
        $where['ids'] = $request->input('ids','');
        $where['user_id'] = Token::$uid;
        
        if($where['ids']=='')
		{
            return ReturnData::create(ReturnData::PARAMS_ERROR);
        }
        
        return $this->getLogic()->cartCheckoutGoodsList($where);
    }
}