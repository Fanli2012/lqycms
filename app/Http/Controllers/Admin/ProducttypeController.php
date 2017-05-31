<?php
namespace app\fladmin\controller;

class Producttype extends Base
{
	public function _initialize()
	{
		parent::_initialize();
    }
    
    public function index()
    {
		$this->assign('catlist',tree(get_category('product_type',0)));
		
        return $this->fetch();
    }
    
    public function add()
    {
        if(!empty($_GET["reid"]))
        {
            $id = $_GET["reid"];
            if(preg_match('/[0-9]*/',$id)){}else{exit;}
            if($id!=0)
            {
				$this->assign('postone',db("product_type")->field('content',true)->where("id=$id")->find());
            }
            $this->assign('id',$id);
        }
        else
        {
            $this->assign('id',0);
        }
		
        return $this->fetch();
    }
    
    public function doadd()
    {
        if(isset($_POST["prid"])){if($_POST["prid"]=="top"){$_POST['reid']=0;}else{$_POST['reid'] = $_POST["prid"];}unset($_POST["prid"]);}//父级栏目id
        $_POST['addtime'] = time();//添加时间
        
		if(db("product_type")->insert($_POST))
        {
            $this->success('添加成功！', FLADMIN.'/Producttype' , 1);
        }
		else
		{
			$this->error('添加失败！请修改后重新添加', FLADMIN.'/Producttype' , 3);
		}
    }
    
    public function edit()
    {
        $id = $_GET["id"];if(preg_match('/[0-9]*/',$id)){}else{exit;}
        
        $this->assign('id',$id);
        $post = db("product_type")->where("id=$id")->find();
        $reid = $post['reid'];
        if($reid!=0){$this->assign('postone',db("product_type")->where("id=$reid")->find());}
        $this->assign('post',$post);
        
        return $this->fetch();
    }
    
    public function doedit()
    {
        if(!empty($_POST["id"])){$id = $_POST["id"];unset($_POST["id"]);}else{$id="";exit;}
        $_POST['addtime'] = time();//添加时间
        
		if(db("product_type")->where("id=$id")->update($_POST))
        {
            $this->success('修改成功！', FLADMIN.'/Producttype' , 1);
        }
		else
		{
			$this->error('修改失败！请修改后重新添加', FLADMIN.'/Producttype/edit?id='.$_POST["id"] , 3);
		}
    }
    
    public function del()
    {
		if(!empty($_GET["id"])){$id = $_GET["id"];}else{$this->error('删除失败！请重新提交',FLADMIN.'/Producttype' , 3);}
		
		if(db("product_type")->where("reid=$id")->find())
		{
			$this->error('删除失败！请先删除子分类', FLADMIN.'/Producttype', 3);
		}
		else
		{
			if(db("product_type")->where("id=$id")->delete())
			{
				if(db("product")->where("typeid=$id")->count()>0) //判断该分类下是否有商品，如果有把该分类下的商品也一起删除
				{
					if(db("product")->where("typeid=$id")->delete())
					{
						$this->success('删除成功', FLADMIN.'/Producttype' , 1);
					}
					else
					{
						$this->error('分类下的商品删除失败！', FLADMIN.'/Producttype', 3);
					}
				}
				else
				{
					$this->success('删除成功', FLADMIN.'/Producttype' , 1);
				}
			}
			else
			{
				$this->error('删除失败！请重新提交', FLADMIN.'/Producttype', 3);
			}
		}
    }
}