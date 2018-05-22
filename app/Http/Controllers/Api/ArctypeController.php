<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Log;
use App\Common\ReturnData;
use App\Common\Helper;
use App\Http\Model\Arctype;
use App\Http\Logic\ArctypeLogic;

class ArctypeController extends CommonController
{
    public function __construct()
    {
        parent::__construct();
    }
	
    public function getLogic()
    {
        return new ArctypeLogic();
    }
    
    public function arctypeList(Request $request)
	{
        //参数
        $limit = $request->input('limit', 10);
        $offset = $request->input('offset', 0);
        if($request->input('pid', null) !== null){$where['pid'] = $request->input('pid');}
        $where['is_show'] = Arctype::IS_SHOW;
        
        $res = $this->getLogic()->getList($where, array('listorder', 'asc'), '*', $offset, $limit);
		if($res === false)
		{
			return ReturnData::create(ReturnData::SYSTEM_FAIL);
		}
        
        foreach($res['list'] as $k=>$v)
        {
            $res['list'][$k]->addtime = date('Y-m-d H:i',$v->addtime);
            $res['list'][$k]->category_list_url = route('weixin_article_category',array('id'=>$v->id));
        }
        
		return ReturnData::create(ReturnData::SUCCESS,$res);
    }
    
    public function arctypeDetail(Request $request)
	{
        //参数
        $where['id'] = $request->input('id',null);
        $where['is_show'] = Arctype::IS_SHOW;
        if($where['id'] == null){return ReturnData::create(ReturnData::PARAMS_ERROR);}
        
        $res = $this->getLogic()->getOne($where);
		if($res === false)
		{
			return ReturnData::create(ReturnData::SYSTEM_FAIL);
		}
        
        $res->addtime = date('Y-m-d H:i',$res->addtime);
        
		return ReturnData::create(ReturnData::SUCCESS,$res);
    }
    
    //添加
    public function arctypeAdd(Request $request)
    {
        if(Helper::isPostRequest())
        {
            return $this->getLogic()->add($_POST);
        }
    }
    
    //修改
    public function arctypeUpdate(Request $request)
    {
        if(!checkIsNumber($request->input('id',null))){return ReturnData::create(ReturnData::PARAMS_ERROR);}
        $id = $request->input('id');
        
        if(Helper::isPostRequest())
        {
            unset($_POST['id']);
            $where['id'] = $id;
            
            return $this->getLogic()->edit($_POST,$where);
        }
    }
    
    //删除
    public function arctypeDelete(Request $request)
    {
        if(!checkIsNumber($request->input('id',null))){return ReturnData::create(ReturnData::PARAMS_ERROR);}
        $id = $request->input('id');
        
        if(Helper::isPostRequest())
        {
            unset($_POST['id']);
            $where['id'] = $id;
            
            return $this->getLogic()->del($where);
        }
    }
}