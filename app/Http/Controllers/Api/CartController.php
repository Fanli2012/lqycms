<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\CommonController;
use Illuminate\Http\Request;
use App\Common\ReturnData;
use App\Common\Token;
use App\Http\Model\Cart;

class CartController extends CommonController
{
    public function __construct()
    {
        parent::__construct();
    }
    
    //购物车列表
    public function cartList(Request $request)
	{
        //参数
        $data['limit'] = $request->input('limit', 10);
        $data['offset'] = $request->input('offset', 0);
        $data['user_id'] = Token::$uid;
        
        $res = Cart::getList($data);
		
		return ReturnData::create(ReturnData::SUCCESS,$res);
    }
    
    //添加购物车
    public function cartAdd(Request $request)
	{
        //参数
        $data['type'] = $request->input('type',null);
        $data['money'] = $request->input('money',null);
        $data['des'] = $request->input('des',null);
        if($request->input('user_money', null) !== null){$data['user_money'] = $request->input('user_money');}
        $data['add_time'] = time();
        $data['user_id'] = Token::$uid;
        
        if($data['type']===null || $data['money']===null || $data['des']===null)
		{
            return ReturnData::create(ReturnData::PARAMS_ERROR);
        }
        
        $res = UserMoney::add($data);
		if(!$res)
		{
			return ReturnData::create(ReturnData::SYSTEM_FAIL);
		}
        
		return ReturnData::create(ReturnData::SUCCESS,$res);
    }
    
    //修改购物车
    public function cartUpdate(Request $request)
	{
        //参数
        $data['type'] = $request->input('type',null);
        $data['money'] = $request->input('money',null);
        $data['des'] = $request->input('des',null);
        if($request->input('user_money', null) !== null){$data['user_money'] = $request->input('user_money');}
        $data['add_time'] = time();
        $data['user_id'] = Token::$uid;
        
        if($data['type']===null || $data['money']===null || $data['des']===null)
		{
            return ReturnData::create(ReturnData::PARAMS_ERROR);
        }
        
        $res = UserMoney::add($data);
		if($res != true)
		{
			return ReturnData::create(ReturnData::SYSTEM_FAIL);
		}
        
		return ReturnData::create(ReturnData::SUCCESS,$res);
    }
    
    //删除购物车
    public function cartDelete(Request $request)
	{
        $id = $request->input('id','');
        
        if($id=='')
		{
            return ReturnData::create(ReturnData::PARAMS_ERROR);
        }
        
        $res = Cart::remove($id,Token::$uid);
		if($res == true)
		{
			return ReturnData::create(ReturnData::SUCCESS,$res);
		}
        
		return ReturnData::create(ReturnData::SYSTEM_FAIL);
    }
    
    //清空购物车
    public function cartClear(Request $request)
	{
        $res = Cart::clearCart(Token::$uid);
		if(!$res)
		{
			return ReturnData::create(ReturnData::SYSTEM_FAIL);
		}
        
		return ReturnData::create(ReturnData::SUCCESS,$res);
    }
}