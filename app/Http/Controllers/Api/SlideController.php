<?php
namespace App\Http\Controllers\Api;
use Log;
use DB;
use Illuminate\Http\Request;
use App\Common\ReturnData;
use App\Common\Helper;
use App\Common\Token;
use App\Http\Model\Slide;
use App\Http\Logic\SlideLogic;

class SlideController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function getLogic()
    {
        return new SlideLogic();
    }
    
    public function slideList(Request $request)
	{
        //参数
        $where = array();
        $limit = $request->input('limit', 10);
        $offset = $request->input('offset', 0);
        if($request->input('group_id', null) != null){$where['group_id'] = $request->input('group_id');}
        if($request->input('type', null) != null){$where['type'] = $request->input('type');}
        $where['is_show'] = Slide::IS_SHOW;
        
        $res = $this->getLogic()->getList($where, array('listorder', 'asc'), '*', $offset, $limit);
		
        if($res['count']>0)
        {
            foreach($res['list'] as $k=>$v)
            {
                if(!empty($res['list'][$k]->pic)){$res['list'][$k]->pic = http_host().$v->pic;}
            }
        }
        
		return ReturnData::create(ReturnData::SUCCESS,$res);
    }
    
    //详情
    public function slideDetail(Request $request)
	{
        //参数
        if(!checkIsNumber($request->input('id',null))){return ReturnData::create(ReturnData::PARAMS_ERROR);}
        $id = $request->input('id');
        $where['id'] = $id;
        
		$res = $this->getLogic()->getOne($where);
        if(!$res){return ReturnData::create(ReturnData::RECORD_NOT_EXIST);}
        
        if(!empty($res->pic)){$res->pic = http_host().$res->pic;}
        
		return ReturnData::create(ReturnData::SUCCESS,$res);
    }
    
    //添加
    public function slideAdd(Request $request)
    {
        if(Helper::isPostRequest())
        {
            $res = $this->getLogic()->add($_POST);
            
            return $res;
        }
    }
    
    //修改
    public function slideUpdate(Request $request)
    {
        if(!checkIsNumber($request->input('id',null))){return ReturnData::create(ReturnData::PARAMS_ERROR);}
        $id = $request->input('id');
        
        if(Helper::isPostRequest())
        {
            unset($_POST['id']);
            $where['id'] = $id;
            
            $res = $this->getLogic()->edit($_POST,$where);
            
            return $res;
        }
    }
    
    //删除
    public function slideDelete(Request $request)
    {
        if(!checkIsNumber($request->input('id',null))){return ReturnData::create(ReturnData::PARAMS_ERROR);}
        $id = $request->input('id');
        
        if(Helper::isPostRequest())
        {
            $where['id'] = $id;
            
            $res = $this->getLogic()->del($where);
            
            return $res;
        }
    }
}