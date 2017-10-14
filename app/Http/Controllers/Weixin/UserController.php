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
	{
        //$_SESSION['weixin_user_info']['access_token'] = '72d623d26a1a6d61186a97f9ccf752f7';
        
        //获取会员信息
        $postdata = array(
            'access_token' => $_SESSION['weixin_user_info']['access_token']
		);
        $url = env('APP_API_URL')."/user_info";
		$res = curl_request($url,$postdata,'GET');
        $data['user_info'] = $res['data'];
        
		return view('weixin.user.index', $data);
	}
    
    //个人中心设置
    public function userinfo(Request $request)
	{
        //获取会员信息
        $postdata = array(
            'access_token' => $_SESSION['weixin_user_info']['access_token']
		);
        $url = env('APP_API_URL')."/user_info";
		$res = curl_request($url,$postdata,'GET');
        $data['user_info'] = $res['data'];
        
		return view('weixin.user.userinfo', $data);
	}
    
    //资金管理
    public function userAccount(Request $request)
	{
        $postdata = array(
            'access_token' => $_SESSION['weixin_user_info']['access_token']
		);
        $url = env('APP_API_URL')."/user_info";
		$res = curl_request($url,$postdata,'GET');
        $data['user_info'] = $res['data'];
        
        return view('weixin.user.userAccount', $data);
    }
    
    //余额明细
    public function userMoneyList(Request $request)
	{
        $pagesize = 10;
        $offset = 0;
        if(isset($_REQUEST['page'])){$offset = ($_REQUEST['page']-1)*$pagesize;}
        
        $postdata = array(
            'limit'  => $pagesize,
            'offset' => $offset,
            'access_token' => $_SESSION['weixin_user_info']['access_token']
		);
        $url = env('APP_API_URL')."/user_money_list";
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
                    $html .= '<li>';
                    if($v['type']==0)
                    {
                        $html .= '<span class="green">+ '.$v['money'].'</span>';
                    }
                    else
                    {
                        $html .= '<span>- '.$v['money'].'</span>';
                    }
                    $html .= '<div class="info"><p class="tit">'.$v['des'].'</p>';
                    $html .= '<p class="time">'.date('Y-m-d H:i:s',$v['add_time']).'</p></div>';
                    $html .= '</li>';
                }
            }
            
    		exit(json_encode($html));
    	}
        
        return view('weixin.user.userMoneyList', $data);
    }
    
    //积分明细
    public function userPointList(Request $request)
	{
        $pagesize = 10;
        $offset = 0;
        if(isset($_REQUEST['page'])){$offset = ($_REQUEST['page']-1)*$pagesize;}
        
        $postdata = array(
            'limit'  => $pagesize,
            'offset' => $offset,
            'access_token' => $_SESSION['weixin_user_info']['access_token']
		);
        $url = env('APP_API_URL')."/user_point_list";
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
                    $html .= '<li>';
                    if($v['type']==0)
                    {
                        $html .= '<span class="green">+ '.$v['point'].'</span>';
                    }
                    else
                    {
                        $html .= '<span>- '.$v['point'].'</span>';
                    }
                    $html .= '<div class="info"><p class="tit">'.$v['des'].'</p>';
                    $html .= '<p class="time">'.date('Y-m-d H:i:s',$v['add_time']).'</p></div>';
                    $html .= '</li>';
                }
            }
            
    		exit(json_encode($html));
    	}
        
        return view('weixin.user.userPointList', $data);
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
    
    //登录
    public function login(Request $request)
	{
        if(isset($_SESSION['weixin_user_info']))
        {
            if(isset($_SERVER["HTTP_REFERER"])){header('Location: '.$_SERVER["HTTP_REFERER"]);exit;}
            header('Location: '.route('weixin_user'));exit;
        }
        
        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            if($_POST['user_name'] == '')
            {
                $this->error_jump('账号不能为空');
            }
            
            if($_POST['password'] == '')
            {
                $this->error_jump('密码不能为空');
            }
            
            $postdata = array(
                'user_name' => $_POST['user_name'],
                'password' => md5($_POST['password'])
            );
            $url = env('APP_API_URL')."/wx_login";
            $res = curl_request($url,$postdata,'POST');
            
            if($res['code'] != ReturnCode::SUCCESS_CODE){$this->error_jump('登录失败');}
            
            $_SESSION['weixin_user_info'] = $res['data'];
            
            header('Location: '.route('weixin_user'));exit;
        }
        
        return view('weixin.user.login');
	}
    
    //注册
    public function register(Request $request)
	{
        if(isset($_SESSION['weixin_user_info']))
        {
            if(isset($_SERVER["HTTP_REFERER"])){header('Location: '.$_SERVER["HTTP_REFERER"]);exit;}
            header('Location: '.route('weixin_user'));exit;
        }
        
        return view('weixin.user.register');
	}
    
    public function logout(Request $request)
	{
        session_unset();
        session_destroy();// 退出登录，清除session
        
		$this->success_jump('退出成功',route('weixin'));
	}
}