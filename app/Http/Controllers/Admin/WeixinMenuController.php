<?php
namespace App\Http\Controllers\Admin;
use DB;
use App\Common\ReturnData;
use App\Common\Helper;
use Illuminate\Http\Request;
use App\Http\Logic\WeixinMenuLogic;
use App\Http\Model\WeixinMenu;
use App\Common\Wechat\WechatMenu;

class WeixinMenuController extends CommonController
{
    public function __construct()
    {
        parent::__construct();
    }
	
    public function getLogic()
    {
        return new WeixinMenuLogic();
    }
    
	public function index()
	{
        $where['is_show'] = -1;
		$catlist = $this->getLogic()->getPaginate($where, array('id', 'desc'));
        
		$data['catlist'] = $catlist;
		return view('admin.WeixinMenu.index', $data);
	}
	
    public function add()
    {
        if(!empty($_GET["reid"]))
        {
            $id = $_GET["reid"];
            if(preg_match('/[0-9]*/',$id)){}else{exit;}
            if($id!=0)
            {
				$data['postone'] = object_to_array(DB::table("weixin_menu")->where('id', $id)->first(), 1);
            }
			
            $data['id'] = $id;
        }
        else
        {
            $data['id'] = 0;
        }
        
        return view('admin.WeixinMenu.add', $data);
    }
    
    public function doadd()
    {
        if(!empty($_POST["prid"])){if($_POST["prid"]=="top"){$_POST['pid']=0;}else{$_POST['pid'] = $_POST["prid"];}}//父级栏目id
        $_POST['addtime'] = time();//添加时间
		unset($_POST["prid"]);
		unset($_POST["_token"]);
		
		if(DB::table('weixin_menu')->insert($_POST))
        {
            success_jump('添加成功');
        }
		else
		{
			error_jump('添加失败！请修改后重新添加');
		}
    }
    
    public function edit()
    {
        $id = $_GET["id"];if(preg_match('/[0-9]*/',$id)){}else{exit;}
        
		$data['id'] = $id;
        $post = object_to_array(DB::table('weixin_menu')->where('id', $id)->first(), 1);
        $reid = $post['pid'];
        if($reid!=0){$data['postone'] = object_to_array(DB::table('weixin_menu')->where('id', $reid)->first());}
        
        $data['post'] = $post;
		
        return view('admin.WeixinMenu.edit', $data);
    }
    
    public function doedit()
    {
        if(!empty($_POST["id"])){$id = $_POST["id"];unset($_POST["id"]);}else {$id="";exit;}
        $_POST['addtime'] = time(); //添加时间
        unset($_POST["_token"]);
		
		if(DB::table('weixin_menu')->where('id', $id)->update($_POST))
        {
            success_jump('修改成功', route('admin_weixinmenu'));
        }
		else
		{
			error_jump('修改失败！请修改后重新添加');
		}
    }
    
    public function del()
    {
		if(!empty($_REQUEST["id"])){$id = $_REQUEST["id"];}else{error_jump('删除失败！请重新提交');} //if(preg_match('/[0-9]*/',$id)){}else{exit;}
		
		if(DB::table('weixin_menu')->where('pid', $id)->first())
		{
			error_jump('删除失败！请先删除子栏目');
		}
		else
		{
			if(DB::table('weixin_menu')->where('id', $id)->delete())
			{
				success_jump('删除成功');
			}
			else
			{
				error_jump('删除失败！请重新提交');
			}
		}
    }
    
    public function createmenu()
    {
        $catlist = WeixinMenu::getList(array('is_show'=>-1));
        
        $wechat_menu = new WechatMenu(sysconfig('CMS_WX_APPID'),sysconfig('CMS_WX_APPSECRET'));
		
        /* $menu = array(
            'button'=>array();
        ); */
        
        $jsonmenu = '
        {
            "button":[
            {
                   "name":"篮球",
                   "sub_button":[
                        {
                           "type":"click",
                           "name":"nba",
                           "key":"V1001_NBA"
                        },
                        {
                           "type":"click",
                           "name":"cba",
                           "key":"V1001_CBA"
                        }
                    ]
               },
               {
                   "name":"体育",
                   "sub_button":[
                        {
                           "type":"view",
                           "name":"url",
                           "url":"http://m.hao123.com/a/tianqi"
                        },
                        {
                           "type":"click",
                           "name":"排球",
                           "key":"V1001_PAIQIU"
                        },
                        {
                           "type":"click",
                           "name":"网球",
                           "key":"V1001_WANGQIU"
                        },
                        {
                           "type":"click",
                           "name":"乒乓球",
                           "key":"V1001_PPQ"
                        },
                        {
                           "type":"click",
                           "name":"台球",
                           "key":"V1001_TAIQIU"
                        }
                    ]
               },
               {
                   "name":"新闻",
                   "sub_button":[
                        {
                           "type":"click",
                           "name":"国内新闻",
                           "key":"V1001_GNNEWS"
                        },
                        {
                           "type":"click",
                           "name":"国际新闻",
                           "key":"V1001_GJNEWS"
                        },
                        {
                           "type":"click",
                           "name":"地方新闻",
                           "key":"V1001_AREANEWS"
                        },
                        {
                           "type":"click",
                           "name":"家庭新闻",
                           "key":"V1001_HOMENEWS"
                        }
                    ]
               }
           ]
        }';
        
        $wechat_menu->create_menu($jsonmenu);
        
		success_jump('修改菜单，生成后，不会立即显示，有24小时的缓存，除非你取消关注，然后重新关注', route('admin_weixinmenu'),5);
    }
}