<?php
namespace App\Http\Controllers\Api;
use Log;
use DB;
use Illuminate\Http\Request;
use App\Common\ReturnData;
use App\Common\Helper;
use App\Common\Token;
use App\Http\Model\Page;
use App\Http\Logic\PageLogic;

class PageController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function getLogic()
    {
        return logic('Page');
    }
    
    public function pageList(Request $request)
	{
        //参数
        $limit = $request->input('limit', 10);
        $offset = $request->input('offset', 0);
        
        $res = $this->getLogic()->getList('', array('listorder', 'asc'), '*', $offset, $limit);
		
        if($res['count']>0)
        {
            foreach($res['list'] as $k=>$v)
            {
                $res['list'][$k]->page_detail_url = route('weixin_singlepage',array('id'=>$v->filename));
            }
        }
        
		return ReturnData::create(ReturnData::SUCCESS,$res);
    }
    
    public function pageDetail(Request $request)
	{
        //参数
        if(!checkIsNumber($request->input('id',null))){return ReturnData::create(ReturnData::PARAMS_ERROR);}
        $id = $request->input('id');
        $where['id'] = $id;
        
        $res = $this->getLogic()->getOne($where);
		if(!$res)
		{
			return ReturnData::create(ReturnData::RECORD_NOT_EXIST);
		}
        
		return ReturnData::create(ReturnData::SUCCESS,$res);
    }
    
    //添加
    public function pageAdd(Request $request)
    {
        if(Helper::isPostRequest())
        {
            return $this->getLogic()->add($_POST);
        }
    }
    
    //修改
    public function pageUpdate(Request $request)
    {
        if(!checkIsNumber($request->input('id',null))){return ReturnData::create(ReturnData::PARAMS_ERROR);}
        $id = $request->input('id');
        
        if(Helper::isPostRequest())
        {
            unset($_POST['id']);
            $where['id'] = $id;
            //$where['user_id'] = Token::$uid;
            
            return $this->getLogic()->edit($_POST,$where);
        }
    }
    
    //删除
    public function pageDelete(Request $request)
    {
        if(!checkIsNumber($request->input('id',null))){return ReturnData::create(ReturnData::PARAMS_ERROR);}
        $id = $request->input('id');
        
        if(Helper::isPostRequest())
        {
            $where['id'] = $id;
            //$where['user_id'] = Token::$uid;
            
            return $this->getLogic()->del($where);
        }
    }
}