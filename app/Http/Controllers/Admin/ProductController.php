<?php
namespace app\fladmin\controller;

class Product extends Base
{
	public function _initialize()
	{
		parent::_initialize();
    }
    
    public function index()
    {
        $where = array();
        if(isset($_REQUEST["keyword"]))
        {
            $where['title'] = array('like','%'.$_REQUEST['keyword'].'%');
        }
        if(isset($_REQUEST["typeid"]) && $_REQUEST["typeid"]!=0)
        {
            $where['typeid'] = $_REQUEST["typeid"];
        }
        if(isset($_REQUEST["id"]))
        {
            $where['typeid'] = $_REQUEST["id"];
        }
        
		$prolist = parent::pageList('product',$where);
		$posts = array();
		foreach($prolist as $key=>$value)
        {
            $info = db('product_type')->field('content',true)->where("id=".$value['typeid'])->find();
            $value['typename'] = $info['typename'];
			$posts[] = $value;
        }
		
		$this->assign('page',$prolist->render());
        $this->assign('posts',$posts);
		
		return $this->fetch();
    }
    
    public function add()
    {
		if(!empty($_GET["catid"])){$this->assign('catid',$_GET["catid"]);}else{$this->assign('catid',0);}
		
        return $this->fetch();
    }
    
    public function doadd()
    {
        $litpic="";if(!empty($_POST["litpic"])){$litpic = $_POST["litpic"];}else{$_POST['litpic']="";} //缩略图
        if(empty($_POST["description"])){if(!empty($_POST["body"])){$_POST['description']=cut_str($_POST["body"]);}} //description
        $_POST['addtime'] = $_POST['pubdate'] = time(); //添加&更新时间
		$_POST['user_id'] = session('admin_user_info')['id']; // 发布者id
		
		//关键词
        if(!empty($_POST["keywords"]))
		{
			$_POST['keywords']=str_replace("，",",",$_POST["keywords"]);
		}
		else
		{
			if(!empty($_POST["title"]))
			{
				$title=$_POST["title"];
				$title=str_replace("，","",$title);
				$title=str_replace(",","",$title);
				$_POST['keywords']=get_keywords($title);//标题分词
			}
		}
		
		if(isset($_POST['editorValue'])){unset($_POST['editorValue']);}
		
		if(db('product')->insert($_POST))
        {
            $this->success('添加成功！', FLADMIN.'/Product' , 1);
        }
		else
		{
			$this->error('添加失败！请修改后重新添加', FLADMIN.'/Product/add' , 3);
		}
    }
    
    public function edit()
    {
        if(!empty($_GET["id"])){$id = $_GET["id"];}else {$id="";}if(preg_match('/[0-9]*/',$id)){}else{exit;}
        
        $this->assign('id',$id);
		$this->assign('post',db('product')->where("id=$id")->find());
        
        return $this->fetch();
    }
    
    public function doedit()
    {
        if(!empty($_POST["id"])){$id = $_POST["id"];}else {$id="";exit;}
        
        $litpic="";if(!empty($_POST["litpic"])){$litpic = $_POST["litpic"];}else{$_POST['litpic']="";} //缩略图
        if(empty($_POST["description"])){if(!empty($_POST["body"])){$_POST['description']=cut_str($_POST["body"]);}}//description
        $_POST['pubdate'] = time();//更新时间
        $_POST['user_id'] = session('admin_user_info')['id']; // 修改者id
		
		//关键词
        if(!empty($_POST["keywords"]))
		{
			$_POST['keywords']=str_replace("，",",",$_POST["keywords"]);
		}
		else
		{
			if(!empty($_POST["title"]))
			{
				$title=$_POST["title"];
				$title=str_replace("，","",$title);
				$title=str_replace(",","",$title);
				$_POST['keywords']=get_keywords($title);//标题分词
			}
		}
		
        if(isset($_POST['editorValue'])){unset($_POST['editorValue']);}
		
        if(db('product')->where("id=$id")->update($_POST))
        {
            $this->success('修改成功！', FLADMIN.'/Product' , 1);
        }
		else
		{
			$this->error('修改失败！', FLADMIN.'/Product/edit?id='.$_POST["id"] , 3);
		}
    }
    
    public function del()
    {
		if(!empty($_GET["id"])){$id = $_GET["id"];}else{$this->error('删除失败！请重新提交',FLADMIN.'/Product' , 3);}if(preg_match('/[0-9]*/',$id)){}else{exit;}
		
		if(db('product')->where("id in ($id)")->delete())
        {
            $this->success("$id ,删除成功", FLADMIN.'/Product' , 1);
        }
		else
		{
			$this->error("$id ,删除失败！请重新提交", FLADMIN.'/Product', 3);
		}
    }
    
	//商品推荐
	public function recommendarc()
    {
		if(!empty($_GET["id"])){$id = $_GET["id"];}else{$this->error('删除失败！请重新提交',FLADMIN.'/Product' , 3);} //if(preg_match('/[0-9]*/',$id)){}else{exit;}
		
		$data['tuijian'] = 1;

        if(db('product')->where("id in ($id)")->update($data))
        {
            $this->success("$id ,推荐成功", FLADMIN.'/Product', 1);
        }
		else
		{
			$this->error("$id ,推荐失败！请重新提交", FLADMIN.'/Product', 3);
		}
    }
    
	//商品是否存在
    public function productexists()
    {
        if(!empty($_GET["title"]))
        {
            $map['title'] = $_GET["title"];
        }
        else
        {
            $map['title']="";
        }
        
        if(!empty($_GET["id"]))
        {
            $map['id'] = array('NEQ',$_GET["id"]);
        }
        
        return db('product')->where($map)->count();
    }
}