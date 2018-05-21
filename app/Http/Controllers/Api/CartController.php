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
        $data['user_id'] = Token::$uid;
        
        $res = Cart::getList($data);
		
		return ReturnData::create(ReturnData::SUCCESS,$res);
    }
    
    //添加购物车
    public function cartAdd(Request $request)
	{
        //参数
        $data['goods_number'] = $request->input('goods_number','');
        $data['goods_id'] = $request->input('goods_id','');
        
        if($request->input('goods_attr', null) != null){$data['goods_attr'] = $request->input('goods_attr');}
        if($request->input('shop_id', null) != null){$data['shop_id'] = $request->input('shop_id');}
        $data['add_time'] = time();
        $data['user_id'] = Token::$uid;
        
        if($data['goods_number']=='' || $data['goods_id']=='')
		{
            return ReturnData::create(ReturnData::PARAMS_ERROR);
        }
        
		return Cart::cartAdd($data);
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
		if($res === true)
		{
			return ReturnData::create(ReturnData::SUCCESS,$res);
		}
        
		return ReturnData::create(ReturnData::SYSTEM_FAIL);
    }
    
    //清空购物车
    public function cartClear(Request $request)
	{
        $res = Cart::clearCart(Token::$uid);
		if($res !== true)
		{
			return ReturnData::create(ReturnData::SYSTEM_FAIL);
		}
        
		return ReturnData::create(ReturnData::SUCCESS,$res);
    }
    
    //购物车结算商品列表
    public function cartCheckoutGoodsList(Request $request)
	{
        //参数
        $data['ids'] = $request->input('ids','');
        $data['user_id'] = Token::$uid;
        
        if($data['ids']=='')
		{
            return ReturnData::create(ReturnData::PARAMS_ERROR);
        }
        
        return Cart::cartCheckoutGoodsList($data);
    }
}