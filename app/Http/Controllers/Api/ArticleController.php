<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\CommonController;
use Illuminate\Http\Request;
use Log;
use App\Common\ReturnData;

use App\Http\Model\Article;

class ArticleController extends CommonController
{
    public function __construct()
    {
        parent::__construct();
    }
	
    public function articleList(Request $request)
	{
        //参数
        $data['limit'] = $request->input('limit', 10);
        $data['offset'] = $request->input('offset', 0);
        if($request->input('typeid', '') != ''){$data['typeid'] = $request->input('typeid');}
        $data['ischeck'] = Article::IS_CHECK;
        
        $res = Article::getList($data);
		if($res === false)
		{
			return ReturnData::create(ReturnData::SYSTEM_FAIL);
		}
        
        foreach($res['list'] as $k=>$v)
        {
            $res['list'][$k]->pubdate = date('Y-m-d H:i',$v->pubdate);
            $res['list'][$k]->addtime = date('Y-m-d H:i',$v->addtime);
            $res['list'][$k]->article_detail_url = route('weixin_article_detail',array('id'=>$v->id));
        }
        
		return ReturnData::create(ReturnData::SUCCESS,$res);
    }
    
    public function articleDetail(Request $request)
	{
        //参数
        $data['id'] = $request->input('id');
        $data['ischeck'] = Article::IS_CHECK;
        if($data['id']==''){return ReturnData::create(ReturnData::PARAMS_ERROR);}
        
        $res = Article::getOne($data);
		if($res === false)
		{
			return ReturnData::create(ReturnData::SYSTEM_FAIL);
		}
        
        //$res->pubdate = date('Y-m-d H:i',$res->pubdate);
        //$res->addtime = date('Y-m-d H:i',$res->addtime);
        
        \DB::table('article')->where(array('id'=>$data['id']))->increment('click', 1);
        
		return ReturnData::create(ReturnData::SUCCESS,$res);
    }
}