<?php
namespace App\Http\Model;

class Bonus extends BaseModel
{
	//优惠券
	
    protected $table = 'bonus';
	public $timestamps = false;
	
	/**
     * 不能被批量赋值的属性
     *
     * @var array
     */
    protected $guarded = [];
	
    const STATUS = 0; // 优惠券可以
    
    //获取列表
	public static function getList(array $param)
    {
        extract($param); //参数：limit，offset
        
        $limit  = isset($limit) ? $limit : 10;
        $offset = isset($offset) ? $offset : 0;
        $where['status'] = self::STATUS;
        
        $model = new Bonus;
        
        $model = $model->where($where);
        
        $res['count'] = $model->count();
        $res['list'] = array();
        
		if($res['count']>0)
        {
            $res['list']  = $model->skip($offset)->take($limit)->orderBy('id','desc')->get()->toArray();
        }
        else
        {
            return false;
        }
        
        return $res;
    }
    
    public static function getOne($id)
    {
        return self::where('id', $id)->first()->toArray();
    }
    
    public static function add(array $data)
    {
        if ($id = self::insertGetId($data))
        {
            return true;
        }

        return false;
    }
    
    public static function modify($where, array $data)
    {
        if (self::where($where)->update($data)!==false)
        {
            return true;
        }
        
        return false;
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