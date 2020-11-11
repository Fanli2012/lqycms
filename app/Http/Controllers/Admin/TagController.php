<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\CommonController;
use Illuminate\Support\Facades\DB;

class TagController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }
	
    public function index()
    {
		$data['posts'] = parent::pageList('tagindex');
        
		return view('admin.tag.index', $data);
    }
    
    public function add()
    {
        return view('admin.tag.add');
    }
    
    public function doadd()
    {
		$tagarc = "";
		if(!empty($_POST["tagarc"])){$tagarc = str_replace("，",",",$_POST["tagarc"]);if(!preg_match("/^\d*$/",str_replace(",","",$tagarc))){$tagarc="";}} //Tag文章列表
        
        $_POST['pubdate'] = time();//更新时间
        $_POST['click'] = rand(200,500);//点击
		
        unset($_POST["tagarc"]);
        unset($_POST["_token"]);
		if(isset($_POST['editorValue'])){unset($_POST['editorValue']);}
		
		if($insertId = DB::table('tagindex')->insertGetId($_POST))
        {
            if($tagarc!="")
            {
                $arr=explode(",",$tagarc);
                
                foreach($arr as $row)
                {
                    $data2['tid'] = $insertId;
                    $data2['aid'] = $row;
                    DB::table("taglist")->insert($data2);
                }
            }
			
            success_jump('添加成功', route('admin_tag'));
        }
		else
		{
			error_jump('添加失败！请修改后重新添加');
		}
    }
    
    public function edit()
    {
        if(!empty($_GET["id"])){$id = $_GET["id"];}else{$id="";}
        if(preg_match('/[0-9]*/',$id)){}else{exit;}
        
        $data['id'] = $id;
		$data['post'] = object_to_array(DB::table('tagindex')->where('id',$id)->first(), 1);
        
        //获取该标签下的文章id
        $posts = object_to_array(DB::table('taglist')->select('aid')->where('tid', $id)->get());
        $aidlist = "";
        if(!empty($posts))
        {
            foreach($posts as $row)
            {
                $aidlist = $aidlist.','.$row['aid'];
            }
        }
		
        $data['aidlist'] = ltrim($aidlist, ",");
		
        return view('admin.tag.edit', $data);
    }
    
    public function doedit()
    {
        if(!empty($_POST["id"])){$id = $_POST["id"];unset($_POST["id"]);}else{$id="";exit;}
        if(!empty($_POST["keywords"])){$_POST['keywords']=str_replace("，",",",$_POST["keywords"]);}else{$_POST['keywords']="";}//关键词
        $_POST['pubdate'] = time();//更新时间
        $tagarc="";
		if(!empty($_POST["tagarc"])){$tagarc = str_replace("，",",",$_POST["tagarc"]);if(!preg_match("/^\d*$/",str_replace(",","",$tagarc))){$tagarc="";}} //Tag文章列表
        
		unset($_POST["tagarc"]);
        unset($_POST["_token"]);
		if(isset($_POST['editorValue'])){unset($_POST['editorValue']);}
		
		if(DB::table('tagindex')->where('id', $id)->update($_POST))
        {
            //获取该标签下的文章id
            $posts = object_to_array(DB::table("taglist")->select('aid')->where('tid', $id)->get());
            $aidlist = "";
            if(!empty($posts))
            {
                foreach($posts as $row)
                {
                    $aidlist = $aidlist.','.$row['aid'];
                }
            }
            $aidlist = ltrim($aidlist, ",");
            
            if($tagarc!="" && $tagarc!=$aidlist)
            {
                DB::table("taglist")->where('tid', $id)->delete();
                
                $arr=explode(",",$tagarc);
                    
                foreach($arr as $row)
                {
                    $data2['tid'] = $id;
                    $data2['aid'] = $row;
                    DB::table("taglist")->insert($data2);
                }
            }
            elseif($tagarc=="")
            {
                DB::table("taglist")->where('tid', $id)->delete();
            }
            
            success_jump('修改成功', route('admin_tag'));
        }
		else
		{
			error_jump('修改失败');
		}
    }
    
	public function del()
    {
		if(!empty($_GET["id"])){$id = $_GET["id"];}else{error_jump('删除失败！请重新提交');} //if(preg_match('/[0-9]*/',$id)){}else{exit;}
		
		if(DB::table("tagindex")->whereIn("id", explode(',', $id))->delete())
        {
            success_jump('删除成功');
        }
		else
		{
			error_jump('删除失败！请重新提交');
		}
    }
}
