<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Log;
use DB;
use App\Common\ReturnData;
use App\Common\Helper;
use App\Http\Model\Article;
use App\Http\Logic\ArticleLogic;

class ArticleController extends CommonController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getLogic()
    {
        return new ArticleLogic();
    }

    public function articleList(Request $request)
	{
        //参数
        $limit = $request->input('limit', 10);
        $offset = $request->input('offset', 0);
        if($request->input('typeid', null) != null){$where['typeid'] = $request->input('typeid');}
        $where['ischeck'] = Article::IS_CHECK;
        
        $res = $this->getLogic()->getList($where, array('id', 'desc'), '*', $offset, $limit);
		if($res === false)
		{
			return ReturnData::create(ReturnData::SYSTEM_FAIL);
		}
        
        foreach($res['list'] as $k=>$v)
        {
            $res['list'][$k]->article_detail_url = route('weixin_article_detail',array('id'=>$v->id));
        }
        
		return ReturnData::create(ReturnData::SUCCESS,$res);
    }
    
    public function articleDetail(Request $request)
	{
        //参数
        $where['id'] = $request->input('id',null);
        $where['ischeck'] = Article::IS_CHECK;
        if($where['id']==null){return ReturnData::create(ReturnData::PARAMS_ERROR);}
        
        $res = $this->getLogic()->getOne($where);
		if($res === false)
		{
			return ReturnData::create(ReturnData::SYSTEM_FAIL);
		}
        
        //$res->pubdate = date('Y-m-d H:i',$res->pubdate);
        //$res->addtime = date('Y-m-d H:i',$res->addtime);

		return ReturnData::create(ReturnData::SUCCESS,$res);
    }
    
    //添加
    public function articleAdd(Request $request)
    {
        if(Helper::isPostRequest())
        {
            $_POST['user_id'] = Token::$uid;
            
            return $this->getLogic()->add($_POST);
        }
    }
    
    //修改
    public function articleUpdate(Request $request)
    {
        if($request->input('id',null)!=null){$id = $request->input('id');}else{$id='';}if(preg_match('/[0-9]*/',$id)){}else{return ReturnData::create(ReturnData::PARAMS_ERROR);}
        
        if(Helper::isPostRequest())
        {
            unset($_POST['id']);
            $where['id'] = $id;
            //$where['user_id'] = Token::$uid;
            
            return $this->getLogic()->edit($_POST,$where);
        }
    }
    
    //删除
    public function articleDelete(Request $request)
    {
        if($request->input('id',null)!=null){$id = $request->input('id');}else{$id='';}if(preg_match('/[0-9]*/',$id)){}else{return ReturnData::create(ReturnData::PARAMS_ERROR);}
        
        if(Helper::isPostRequest())
        {
            unset($_POST['id']);
            $where['id'] = $id;
            //$where['user_id'] = Token::$uid;
            
            return $this->getLogic()->del($where);
        }
    }
}