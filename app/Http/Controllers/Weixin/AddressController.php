<?php
namespace App\Http\Controllers\Weixin;

use App\Http\Controllers\Weixin\CommonController;
use Illuminate\Http\Request;

class AddressController extends CommonController
{
    public function __construct()
    {
        parent::__construct();
    }
	
    //收货地址列表
    public function index(Request $request)
	{
        $pagesize = 10;
        $offset = 0;
        if(isset($_REQUEST['page'])){$offset = ($_REQUEST['page']-1)*$pagesize;}
        
        //收货地址列表
        $postdata = array(
            'limit'  => $pagesize,
            'offset' => $offset,
            'access_token' => $_SESSION['weixin_user_info']['access_token']
		);
        $url = env('APP_API_URL')."/user_address_list";
		$res = curl_request($url,$postdata,'GET');
        $data['list'] = $res['data']['list'];
        
        $data['totalpage'] = ceil($res['data']['count']/$pagesize);
        if(isset($_REQUEST['page_ajax']) && $_REQUEST['page_ajax']==1)
        {
    		$html = '';
            
            if($res['data']['list'])
            {
                foreach($res['data']['list'] as $k => $v)
                {
                    $html .= '<div class="flow-have-adr">';
                    
                    if($v['is_default']==1)
                    {
                        $html .= '<p class="f-h-adr-title"><label>'.$v['name'].'</label><span class="ect-colory">'.$v['mobile'].'</span><span class="fr">默认</span></p>';
                    }
                    else
                    {
                        $html .= '<p class="f-h-adr-title"><label>'.$v['name'].'</label><span class="ect-colory">'.$v['mobile'].'</span></p>';
                    }
                    
                    $html .= '<p class="f-h-adr-con">'.$v['province'].$v['city'].$v['district'].' '.$v['address'].'</p>';
                    $html .= '<div class="adr-edit-del"><a href="'.route('weixin_user_address_update',array('id'=>$v['id'])).'"><i class="iconfont icon-bianji"></i>编辑</a><a href="javascript:del('.$v['id'].');"><i class="iconfont icon-xiao10"></i>删除</a></div>';
                    $html .= '</div>';
                }
            }
            
    		exit(json_encode($html));
    	}
        
		return view('weixin.address.index', $data);
	}
    
    //收货地址添加
    public function userAddressAdd(Request $request)
	{
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
            'access_token'  => $_SESSION['weixin_user_info']['access_token'],
            'limit'  => 10,
            'offset' => 0
		);
        $url = env('APP_API_URL')."/user_address_list";
		$goods_list = curl_request($url,$postdata,'GET');
        $data['user_address_list'] = $goods_list['data']['list'];
        
		return view('weixin.address.userAddressAdd', $data);
	}
}