<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\CommonController;
use Illuminate\Http\Request;
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
        if($request->input('typeid', null) !== null){$data['typeid'] = $request->input('typeid');}
        $data['ischeck'] = Article::IS_CHECK;
        
        $res = Article::getList($data);
		if($res == false)
		{
			return ReturnData::create(ReturnData::SYSTEM_FAIL);
		}
        
		return ReturnData::create(ReturnData::SUCCESS,$res);
    }
}