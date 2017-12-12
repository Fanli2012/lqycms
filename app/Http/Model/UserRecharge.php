<?php
namespace App\Http\Model;
use App\Common\ReturnData;

class UserRecharge extends BaseModel
{
	//用户余额明细
	
    protected $table = 'user_recharge';
	public $timestamps = false;
	
	/**
     * 不能被批量赋值的属性
     *
     * @var array
     */
    protected $guarded = array();
	
    const UN_PAY = 0;
    const COMPLETE_PAY = 1;
    
    //获取列表
	public static function getList(array $param)
    {
        extract($param); //参数：limit，offset
        
        $where['user_id'] = $user_id;
        $limit  = isset($limit) ? $limit : 10;
        $offset = isset($offset) ? $offset : 0;
        
        $model = new self();
        
        if(isset($status) && $status!=-1){$where['status'] = $status;} //-1表示获取所有
        
        $model = $model->where($where);
        
        $res['count'] = $model->count();
        $res['list'] = array();
        
		if($res['count']>0)
        {
            $res['list']  = $model->skip($offset)->take($limit)->orderBy('id','desc')->get();
        }
        
        return $res;
    }
    
    public static function getOne($where)
    {
        return self::where($where)->first();
    }
    
    public static function add(array $data)
    {
        $data['recharge_sn'] = date('YmdHis'.rand(1000,9999));
        
        if ($id = self::insertGetId($data))
        {
            return $id;
        }

        return false;
    }
    
    public static function modify($where, array $data)
    {
        if (self::where($where)->update($data) === false)
        {
            return false;
        }
        
        return true;
    }
    
    //删除一条记录
    public static function remove($id)
    {
        if (!self::whereIn('id', explode(',', $id))->delete())
        {
            return false;
        }
        
        return true;
    }
}