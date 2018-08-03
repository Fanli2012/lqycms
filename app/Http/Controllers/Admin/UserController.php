<?php
namespace App\Http\Controllers\Admin;
use DB;
use App\Common\ReturnData;
use App\Common\Helper;
use Illuminate\Http\Request;
use App\Http\Logic\UserLogic;
use App\Http\Model\User;

class UserController extends CommonController
{
    public function __construct()
    {
        parent::__construct();
    }
	
    public function getLogic()
    {
        return new UserLogic();
    }
    
    public function index()
    {
        $where = '';
		$posts = $this->getLogic()->getPaginate($where, array('id', 'desc'));
        
        $data['posts'] = $posts;
        return view('admin.user.index', $data);
    }
    
    //会员账户记录
    public function money()
    {
        $where = '';
        if(isset($_REQUEST["user_id"]))
        {
            $where['user_id'] = $_REQUEST["user_id"];
        }
        
        $posts = parent::pageList('user_money',$where);
		
        if($posts)
        {
            foreach($posts as $k=>$v)
            {
                $posts[$k]->user = DB::table('user')->where('id', $v->user_id)->first();
            }
        }
        
        $data['posts'] = $posts;
        return view('admin.user.money', $data);
    }
    
    //人工充值
    public function manualRecharge()
    {
        if(Helper::isPostRequest())
        {
            if(!is_numeric($_POST["money"]) || $_POST["money"]==0){error_jump('金额格式不正确');}
            
            unset($_POST["_token"]);
            
            if($_POST["money"]>0)
            {
                DB::table('user')->where(['id'=>$_POST["id"]])->increment('money', $_POST["money"]);
                $user_money['type'] = 0;
            }
            else
            {
                DB::table('user')->where(['id'=>$_POST["id"]])->decrement('money', abs($_POST["money"]));
                $user_money['type'] = 1;
            }
            
            $user_money['user_id'] = $_POST["id"];
            $user_money['add_time'] = time();
            $user_money['money'] = abs($_POST["money"]);
            $user_money['des'] = '后台充值';
            $user_money['user_money'] = DB::table('user')->where(array('id'=>$_POST["id"]))->value('money');
            
            //添加用户余额记录
            DB::table('user_money')->insert($user_money);
            
            success_jump('操作成功', route('admin_user'));
        }
        
        $data['user'] = object_to_array(DB::table('user')->select('user_name', 'mobile', 'money', 'id')->where('id', $_REQUEST["user_id"])->first(), 1);
        if(!$data['user']){error_jump('参数错误');}
        
        return view('admin.user.manualRecharge', $data);
    }
    
    public function add()
    {
        if(Helper::isPostRequest())
        {
            unset($_POST["_token"]);
            
            if(DB::table('user')->where('user_name', $_POST["user_name"])->first()){error_jump('用户名已经存在');}
            if(DB::table('user')->where('mobile', $_POST["mobile"])->first()){error_jump('手机号已经存在');}
            $_POST['password'] = md5($_POST['password']);
            $_POST['add_time'] = time();
            
            if(DB::table('user')->insert($_POST))
            {
                success_jump('添加成功', route('admin_user'));
            }
            else
            {
                error_jump('添加失败！请修改后重新添加');
            }
        }
        
        $data['user_rank'] = DB::table('user_rank')->orderBy('rank', 'asc')->get();
        
        return view('admin.user.add',$data);
    }
    
    public function edit()
    {
        if(Helper::isPostRequest())
        {
            if(!empty($_POST["id"])){$id = $_POST["id"];unset($_POST["id"]);}else {$id="";exit;}
            
            unset($_POST["_token"]);
            if(DB::table('user')->where('id', $id)->update($_POST))
            {
                success_jump('修改成功', route('admin_user'));
            }
            else
            {
                error_jump('修改失败');
            }
        }
        
        if(!empty($_GET["id"])){$id = $_GET["id"];}else{$id="";}
        if(preg_match('/[0-9]*/',$id)){}else{exit;}
        
        $data['id'] = $id;
		$data['post'] = object_to_array(DB::table('user')->where('id', $id)->first(), 1);
        
        return view('admin.user.edit', $data);
    }
	
    public function del()
    {
        if(!empty($_GET["id"])){$id = $_GET["id"];}else{error_jump('删除失败！请重新提交');}
		
		if(DB::table('user')->whereIn("id", explode(',', $id))->update(['status' => 2]))
        {
            success_jump('删除成功');
        }
		else
		{
			error_jump('删除失败！请重新提交');
		}
    }
}