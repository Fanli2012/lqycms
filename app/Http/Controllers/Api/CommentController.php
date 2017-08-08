<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\CommonController;
use Illuminate\Http\Request;
use App\Common\ReturnData;
use App\Common\Token;
use App\Http\Model\Comment;

class CommentController extends CommonController
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function goodsCommentList(Request $request)
	{
        //参数
        $data['limit'] = $request->input('limit', 10);
        $data['offset'] = $request->input('offset', 0);
        $data['user_id'] = Token::$uid;
        $data['comment_type'] = $request->input('comment_type', 0); //0商品评价，1文章评价
        if($request->input('comment_rank', null) !== null){$data['comment_rank'] = $request->input('comment_rank');}
        
        $res = Comment::getList($data);
		if($res !== true)
		{
			return ReturnData::create(ReturnData::SYSTEM_FAIL,null,$res);
		}
        
		return ReturnData::create(ReturnData::SUCCESS,$res);
    }
    
    //添加评价
    public function goodsCommentAdd(Request $request)
	{
        //参数
        $data['comment_type'] = $request->input('comment_type',0);
        $data['id_value'] = $request->input('id_value',null);
        $data['content'] = $request->input('content',null);
        $data['comment_rank'] = $request->input('comment_rank',null);
        if($request->input('email', null) !== null){$data['email'] = $request->input('email');}
        if($request->input('user_name', null) !== null){$data['user_name'] = $request->input('user_name');}
        if($request->input('ip_address', null) !== null){$data['ip_address'] = $request->input('ip_address');}
        if($request->input('parent_id', null) !== null){$data['parent_id'] = $request->input('parent_id');}
        $data['add_time'] = time();
        $data['user_id'] = Token::$uid;
        
        if($data['comment_type']===null || $data['id_value']===null || $data['content']===null || $data['comment_rank']===null)
		{
            return ReturnData::create(ReturnData::PARAMS_ERROR);
        }
        
        $res = Comment::add($data);
		if($res !== true)
		{
			return ReturnData::create(ReturnData::SYSTEM_FAIL,null,$res);
		}
        
		return ReturnData::create(ReturnData::SUCCESS,$res);
    }
    
    public function goodsCommentUpdate(Request $request)
	{
        //参数
        $id = $request->input('id',null);
        $data['comment_type'] = $request->input('comment_type',0);
        $data['id_value'] = $request->input('id_value',null);
        $data['content'] = $request->input('content',null);
        $data['comment_rank'] = $request->input('comment_rank',null);
        if($request->input('email', null) !== null){$data['email'] = $request->input('email');}
        if($request->input('user_name', null) !== null){$data['user_name'] = $request->input('user_name');}
        if($request->input('ip_address', null) !== null){$data['ip_address'] = $request->input('ip_address');}
        if($request->input('parent_id', null) !== null){$data['parent_id'] = $request->input('parent_id');}
        $data['add_time'] = time();
        $data['user_id'] = Token::$uid;
        
        if($id===null || $data['comment_type']===null || $data['id_value']===null || $data['content']===null || $data['comment_rank']===null)
		{
            return ReturnData::create(ReturnData::PARAMS_ERROR);
        }
        
        $res = Comment::modify(array('id'=>$id),$data);
		if($res !== true)
		{
			return ReturnData::create(ReturnData::SYSTEM_FAIL,null,$res);
		}
        
		return ReturnData::create(ReturnData::SUCCESS,$res);
    }
    
    //删除评价
    public function goodsCommentDelete(Request $request)
	{
        //参数
        $data['comment_type'] = $request->input('comment_type',null);
        $data['id_value'] = $request->input('id_value',null);
        $data['user_id'] = Token::$uid;
        
        if($data['comment_type']===null || $data['id_value']===null)
		{
            return ReturnData::create(ReturnData::PARAMS_ERROR);
        }
        
        $res = Comment::remove($data);
		if($res !== true)
		{
			return ReturnData::create(ReturnData::SYSTEM_FAIL,null,$res);
		}
        
		return ReturnData::create(ReturnData::SUCCESS,$res);
    }
}