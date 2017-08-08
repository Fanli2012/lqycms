<?php
namespace App\Http\Model;

use App\Common\Token;

class Comment extends BaseModel
{
	//评价
	
    protected $table = 'comment';
	public $timestamps = false;
	
	/**
     * 不能被批量赋值的属性
     *
     * @var array
     */
    protected $guarded = [];
	
    const SHOW_COMMENT = 1; //评论已审核
    
    //获取列表
	public static function getList(array $param)
    {
        extract($param); //参数：limit，offset
        
        $where['user_id'] = Token::$uid;
        $where['comment_type'] = $comment_type; //0商品评价，1文章评价
        $where['status'] = self::SHOW_COMMENT;
        
        $limit  = isset($limit) ? $limit : 10;
        $offset = isset($offset) ? $offset : 0;
        
        $model = new Comment;
        
        if(isset($comment_rank)){$where['comment_rank'] = $comment_rank;} //评价分
        
        $model = $model->where($where);
        
        $res['count'] = $model->count();
        $res['list'] = array();
        
		if($res['count']>0)
        {
            $res['list']  = $model->skip($offset)->take($limit)->orderBy('id','desc')->get()->toArray();
        }
        else
        {
            return '暂无记录';
        }
        
        return $res;
    }
    
    public static function getOne($id)
    {
        return self::where('id', $id)->first()->toArray();
    }
    
    public static function add(array $data)
    {
        if(self::where(array('user_id'=>$data['user_id'],'id_value'=>$data['id_value'],'comment_type'=>$data['comment_type']))->first()){return '亲，您已经评价啦！';}
        
        if ($id = self::insertGetId($data))
        {
            return true;
        }

        return false;
    }
    
    public static function modify($where, array $data)
    {
        if (self::where($where)->update($data))
        {
            return true;
        }
        
        return false;
    }
    
    //删除一条记录
    public static function remove(array $data)
    {
        if(!self::where(array('user_id'=>$data['user_id'],'comment_type'=>$data['comment_type'],'id_value'=>$data['id_value']))->first()){return '商品尚未评价';}
        
        if (!self::where(array('user_id'=>$data['user_id'],'comment_type'=>$data['comment_type'],'id_value'=>$data['id_value']))->delete())
        {
            return false;
        }
        
        return true;
    }
}