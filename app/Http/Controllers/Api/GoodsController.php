<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\CommonController;
use Illuminate\Http\Request;
use App\Common\ReturnData;
use App\Common\Token;
use App\Http\Model\Goods;
use App\Http\Model\GoodsSearchword;

class GoodsController extends CommonController
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function goodsDetail(Request $request)
	{
        //参数
        $data['id'] = $request->input('id','');
        $user_id = $request->input('user_id','');
        if($data['id']==''){return ReturnData::create(ReturnData::PARAMS_ERROR);}
        
        $res = Goods::goodsDetail($data);
		
        if($user_id){$res->is_collect = \DB::table('collect_goods')->where(array('user_id'=>$user_id,'goods_id'=>$data['id']))->count();}
        \DB::table('goods')->where(array('id'=>$data['id']))->increment('click', 1);
        
		return ReturnData::create(ReturnData::SUCCESS,$res);
    }
    
    public function goodsList(Request $request)
	{
        //参数
        $data['limit'] = $request->input('limit', 10);
        $data['offset'] = $request->input('offset', 0);
        if($request->input('typeid', null) != null && $request->input('typeid', '') != 0){$data['typeid'] = $request->input('typeid');}
        if($request->input('tuijian', null) != null){$data['tuijian'] = $request->input('tuijian');}
        if($request->input('status', null) != null){$data['status'] = $request->input('status');}
        if($request->input('keyword', null) != null){$data['keyword'] = $request->input('keyword');}
        if($request->input('min_price', null) != null){$data['min_price'] = $request->input('min_price');}
        if($request->input('max_price', null) != null){$data['max_price'] = $request->input('max_price');}
        if($request->input('orderby', null) != null){$data['orderby'] = $request->input('orderby');}
        if($request->input('brand_id', null) != null){$data['brand_id'] = $request->input('brand_id');}
        
        $res = Goods::getList($data);
		
		return ReturnData::create(ReturnData::SUCCESS,$res);
    }
    
    public function goodsSearchwordList(Request $request)
	{
        //参数
        $data['limit'] = $request->input('limit', 10);
        $data['offset'] = $request->input('offset', 0);
        
        $res = GoodsSearchword::getList($data);
		
		return ReturnData::create(ReturnData::SUCCESS,$res);
    }
}