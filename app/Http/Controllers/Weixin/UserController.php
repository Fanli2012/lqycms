<?php
namespace App\Http\Controllers\Weixin;

use App\Http\Controllers\Weixin\CommonController;
use Illuminate\Http\Request;
use App\Common\ReturnCode;

class UserController extends CommonController
{
    public function __construct()
    {
        parent::__construct();
    }
	
    //个人中心
    public function index(Request $request)
	{$_SESSION['weixin_user_info']['access_token'] = '72d623d26a1a6d61186a97f9ccf752f7';
        if($request->input('typeid', '') != ''){$data['typeid'] = $request->input('typeid');}
        if($request->input('tuijian', '') != ''){$data['tuijian'] = $request->input('tuijian');}
        if($request->input('keyword', '') != ''){$data['keyword'] = $request->input('keyword');}
        if($request->input('status', '') != ''){$data['status'] = $request->input('status');}
        if($request->input('is_promote', '') != ''){$data['is_promote'] = $request->input('is_promote');}
        if($request->input('orderby', '') != ''){$data['orderby'] = $request->input('orderby');}
        if($request->input('max_price', '') != ''){$data['max_price'] = $request->input('max_price');}else{$data['max_price'] = 99999;}
        if($request->input('min_price', '') != ''){$data['min_price'] = $request->input('min_price');}else{$data['min_price'] = 0;}
        
        //商品列表
        $postdata = array(
            'limit'  => 10,
            'offset' => 0
		);
        $url = env('APP_API_URL')."/goods_list";
		$goods_list = curl_request($url,$postdata,'GET');
        $data['goods_list'] = $goods_list['data']['list'];
        
		return view('weixin.user.index', $data);
	}
    
    //浏览记录
    public function userGoodsHistory(Request $request)
	{
        //商品列表
        $pagesize = 10;
        $offset = 0;
        if(isset($_REQUEST['page'])){$offset = ($_REQUEST['page']-1)*$pagesize;}
        
        $postdata = array(
            'limit'  => $pagesize,
            'offset' => $offset,
            'access_token' => $_SESSION['weixin_user_info']['access_token']
		);
        $url = env('APP_API_URL')."/user_goods_history_list";
		$res = curl_request($url,$postdata,'GET');
        $data['user_goods_history'] = $res['data']['list'];
        
        $data['totalpage'] = ceil($res['data']['count']/$pagesize);
        
        if(isset($_REQUEST['page_ajax']) && $_REQUEST['page_ajax']==1)
        {
    		$html = '';
            
            if($res['data']['list'])
            {
                foreach($res['data']['list'] as $k => $v)
                {
                    $html .= '<li><a href="'.$v['goods']['goods_detail_url'].'"><span class="goods_thumb"><img alt="'.$v['goods']['title'].'" src="'.env('APP_URL').$v['goods']['litpic'].'"></span></a>';
                    $html .= '<div class="goods_info"><p class="goods_tit">'.$v['goods']['title'].'</p>';
                    $html .= '<p class="goods_price">￥<b>'.$v['goods']['price'].'</b></p>';
                    $html .= '<p class="goods_des fr"><span id="del_history" onclick="delconfirm(\''.route('weixin_user_goods_history_delete',array('id'=>$v['id'])).'\')">删除</span></p>';
                    $html .= '</div></li>';
                }
            }
            
    		exit(json_encode($html));
    	}
        
        return view('weixin.user.userGoodsHistory', $data);
	}
    
    //浏览记录删除
    public function userGoodsHistoryDelete(Request $request)
	{
        $id = $request->input('id','');
        
        if($id == ''){$this->error_jump(ReturnData::PARAMS_ERROR);}
        
        $postdata = array(
            'id' => $id,
            'access_token' => $_SESSION['weixin_user_info']['access_token']
		);
        $url = env('APP_API_URL')."/user_goods_history_delete";
		$res = curl_request($url,$postdata,'POST');
        
        if($res['code'] != ReturnCode::SUCCESS_CODE){$this->error_jump(ReturnCode::FAIL);}
        
        $this->success_jump(ReturnCode::SUCCESS);
	}
    
    //浏览记录清空
    public function userGoodsHistoryClear(Request $request)
	{
        $postdata = array(
            'access_token' => $_SESSION['weixin_user_info']['access_token']
		);
        $url = env('APP_API_URL')."/user_goods_history_clear";
		$res = curl_request($url,$postdata,'POST');
        
        if($res['code'] != ReturnCode::SUCCESS_CODE){$this->error_jump(ReturnCode::FAIL);}
        
        $this->success_jump(ReturnCode::SUCCESS);
	}
}