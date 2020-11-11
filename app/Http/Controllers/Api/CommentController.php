<?php
namespace App\Http\Controllers\Api;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Common\ReturnData;
use App\Common\Helper;
use App\Common\Token;
use App\Http\Model\Comment;
use App\Http\Logic\CommentLogic;

class CommentController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function getLogic()
    {
        return logic('Comment');
    }
    
    public function commentList(Request $request)
	{
        //参数
        $limit = $request->input('limit', 10);
        $offset = $request->input('offset', 0);
        $where['user_id'] = Token::$uid;
        $where['comment_type'] = 0;if($request->input('comment_type')!=null){$where['comment_type'] = $request->input('comment_type');}; //0商品评价，1文章评价
        if($request->input('comment_rank', '') != ''){$where['comment_rank'] = $request->input('comment_rank');}
        if($request->input('id_value', '') != ''){$where['id_value'] = $request->input('id_value');}
        if($request->input('parent_id', '') != ''){$where['parent_id'] = $request->input('parent_id');}
        $where['status'] = Comment::SHOW_COMMENT;
        
        $res = $this->getLogic()->getList($where, array('id', 'desc'), '*', $offset, $limit);
		
        /* if($res['count']>0)
        {
            foreach($res['list'] as $k=>$v)
            {
                
            }
        } */
        
		return ReturnData::create(ReturnData::SUCCESS,$res);
    }
    
    public function commentDetail(Request $request)
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
    public function commentAdd(Request $request)
    {
        if(Helper::isPostRequest())
        {
            $_POST['user_id'] = Token::$uid;
            $_POST['add_time'] = time();
            $_POST['ip_address'] = Helper::getRemoteIp();
            
            return $this->getLogic()->add($_POST);
        }
    }
    
    //评价批量添加
    public function commentBatchAdd(Request $request)
	{
        if($request->input('comment',null)==null || $request->input('order_id',null)==null){return ReturnData::create(ReturnData::PARAMS_ERROR);}
        $comment = json_decode($request->input('comment'),true);
        
        if($comment)
        {
            foreach($comment as $k=>$v)
            {
                $comment[$k]['user_id'] = Token::$uid;
                $comment[$k]['ip_address'] = Helper::getRemoteIp();
                $comment[$k]['add_time'] = time();
                $comment[$k]['order_id'] = $request->input('order_id');
            }
        }
        
        return $this->getLogic()->batchAdd($comment);
    }
    
    //修改
    public function commentUpdate(Request $request)
    {
        if(!checkIsNumber($request->input('id',null))){return ReturnData::create(ReturnData::PARAMS_ERROR);}
        $id = $request->input('id');
        
        if(Helper::isPostRequest())
        {
            unset($_POST['id']);
            $where['id'] = $id;
            $where['user_id'] = Token::$uid;
            
            return $this->getLogic()->edit($_POST,$where);
        }
    }
    
    //删除
    public function commentDelete(Request $request)
    {
        if(!checkIsNumber($request->input('id',null))){return ReturnData::create(ReturnData::PARAMS_ERROR);}
        $id = $request->input('id');
        
        if(Helper::isPostRequest())
        {
            $where['id'] = $id;
            $where['user_id'] = Token::$uid;
            
            return $this->getLogic()->del($where);
        }
    }
}