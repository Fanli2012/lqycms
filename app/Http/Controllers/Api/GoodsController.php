<?php
namespace App\Http\Controllers\Api;
use Log;
use DB;
use Illuminate\Http\Request;
use App\Common\ReturnData;
use App\Common\Helper;
use App\Common\Token;
use App\Http\Model\Goods;
use App\Http\Logic\GoodsLogic;
use App\Http\Logic\GoodsSearchwordLogic;

class GoodsController extends CommonController
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function getLogic()
    {
        return logic('Goods');
    }
    
    public function goodsList(Request $request)
	{
        //参数
        $limit = $request->input('limit', 10);
        $offset = $request->input('offset', 0);
        $where = function ($query) use ($request) {
            $query->where('status', Goods::GOODS_NORMAL_STATUS);
            
            if($request->input('typeid', null) != null && $request->input('typeid', '') != 0)
            {
                $query->where('typeid', $request->input('typeid'));
            }
            
            if($request->input('tuijian', null) != null)
            {
                $query->where('tuijian', $request->input('tuijian'));
            }
            
            if($request->input('keyword', null) != null)
			{
				$query->where('title', 'like', '%'.$request->input('keyword').'%')->orWhere('sn', 'like', '%'.$request->input('keyword').'%');
			}
            
            //价格区间搜索
            if($request->input('min_price', null) != null && $request->input('max_price', null) != null)
            {
                $query->where('price', '>=', $request->input('min_price'))->where("price", "<=", $request->input('max_price'));
            }
            
            if($request->input('brand_id', null) != null)
            {
                $query->where('brand_id', $request->input('brand_id'));
            }
            
            //促销商品
            if($request->input('is_promote', 0) == 1)
            {
                $timestamp = time();
                $query->where("promote_start_date", "<=", $timestamp)->where('promote_end_date', '>=', $timestamp);
            }
        };
        
        //关键词搜索
        if($request->input('keyword', null) != null)
        {
            //添加搜索关键词
            $goodssearchword = new GoodsSearchwordLogic();
            $goodssearchword->add(array('name'=>$keyword));
        }
        
        //排序
        $orderby = '';
        if($request->input('orderby', null) != null)
        {
            switch ($request->input('orderby'))
            {
                case 1:
                    $orderby = ['sale','desc']; //销量从高到低
                    break;
                case 2:
                    $orderby = ['comments','desc']; //评论从高到低
                    break;
                case 3:
                    $orderby = ['price','desc']; //价格从高到低
                    break;
                case 4:
                    $orderby = ['price','asc']; //价格从低到高
                    break;
                default:
                    $orderby = ['pubdate','desc']; //最新
            }
        }
        
        $res = $this->getLogic()->getList($where, $orderby, model('Goods')->common_field, $offset, $limit);
		
		if($res['count']>0)
        {
            foreach($res['list'] as $k=>$v)
            {
                if(!empty($res['list'][$k]->litpic)){$res['list'][$k]->litpic = http_host().$res['list'][$k]->litpic;}
                
                $res['list'][$k]->goods_detail_url = route('weixin_goods_detail',array('id'=>$v->id));
            }
        }
        
		return ReturnData::create(ReturnData::SUCCESS, $res);
    }
    
    public function goodsDetail(Request $request)
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
        
        $res->goods_detail_url = route('weixin_goods_detail',array('id'=>$res->id));
        
        return ReturnData::create(ReturnData::SUCCESS, $res);
    }
    
    //添加
    public function goodsAdd(Request $request)
    {
        if(Helper::isPostRequest())
        {
            $_POST['user_id'] = Token::$uid;
            
            return $this->getLogic()->add($_POST);
        }
    }
    
    //修改
    public function goodsUpdate(Request $request)
    {
        if(!checkIsNumber(request('id',null))){return ReturnData::create(ReturnData::PARAMS_ERROR);}
        $id = request('id');
        
        if(Helper::isPostRequest())
        {
            unset($_POST['id']);
            $where['id'] = $id;
            //$where['user_id'] = Token::$uid;
            
            return $this->getLogic()->edit($_POST,$where);
        }
    }
    
    //删除
    public function goodsDelete(Request $request)
    {
        if(!checkIsNumber(request('id',null))){return ReturnData::create(ReturnData::PARAMS_ERROR);}
        $id = request('id');
        
        if(Helper::isPostRequest())
        {
            $where['id'] = $id;
            //$where['user_id'] = Token::$uid;
            
            return $this->getLogic()->del($where);
        }
    }
}