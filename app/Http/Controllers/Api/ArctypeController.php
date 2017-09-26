<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\CommonController;
use Illuminate\Http\Request;
use Log;
use App\Common\ReturnData;

use App\Http\Model\Arctype;

class ArctypeController extends CommonController
{
    public function __construct()
    {
        parent::__construct();
    }
	
    public function arctypeList(Request $request)
	{
        //参数
        $data['limit'] = $request->input('limit', 10);
        $data['offset'] = $request->input('offset', 0);
        if($request->input('pid', null) !== null){$data['pid'] = $request->input('pid');}
        $data['is_show'] = Arctype::IS_SHOW;
        
        $res = Arctype::getList($data);
		if($res == false)
		{
			return ReturnData::create(ReturnData::SYSTEM_FAIL);
		}
        
        foreach($res as $k=>$v)
        {
            $res['list'][$k]->addtime = date('Y-m-d H:i',$v->addtime);
            $res['list'][$k]->category_list_url = route('weixin_article_category',array('id'=>$v->id));
        }
        
		return ReturnData::create(ReturnData::SUCCESS,$res);
    }
    
    public function arctypeDetail(Request $request)
	{
        //参数
        $data['id'] = $request->input('id');
        $data['is_show'] = Arctype::IS_SHOW;
        
        $res = Arctype::getOne($data);
		if($res === false)
		{
			return ReturnData::create(ReturnData::SYSTEM_FAIL);
		}
        
        $res->addtime = date('Y-m-d H:i',$res->addtime);
        
		return ReturnData::create(ReturnData::SUCCESS,$res);
    }
}