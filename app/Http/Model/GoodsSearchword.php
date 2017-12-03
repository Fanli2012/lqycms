<?php
namespace App\Http\Model;

class GoodsSearchword extends BaseModel
{
	//用户消息
	
    protected $table = 'goods_searchword';
	public $timestamps = false;
	
	/**
     * 不能被批量赋值的属性
     *
     * @var array
     */
    protected $guarded = array();
	
    //获取列表
	public static function getList(array $param)
    {
        extract($param); //参数：limit，offset
        
        $limit  = isset($limit) ? $limit : 10;
        $offset = isset($offset) ? $offset : 0;
        
        $model = new self;
        
        $where['status'] = 0;
        
        $model = $model->where($where);
        
        $res['count'] = $model->count();
        $res['list'] = array();
        
		if($res['count']>0)
        {
            $res['list']  = $model->skip($offset)->take($limit)->orderBy('click','desc')->orderBy('listorder','asc')->get();
        }
        else
        {
            return false;
        }
        
        return $res;
    }
    
    public static function getOne($where)
    {
        return self::where($where)->first();
    }
    
    public static function add(array $data)
    {
        //如果关键词存在，就增加点击量
        if(isset($data['name']))
        {
            if(self::getOne(array('name'=>$data['name'])))
            {
                \DB::table('goods_searchword')->where(array('name'=>$data['name']))->increment('click', 1);
            }
            else
            {
                if ($id = self::insertGetId($data))
                {
                    return $id;
                }
            }
        }
        else
        {
            return false;
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
    public static function remove($id)
    {
        if (!self::whereIn('id', explode(',', $id))->delete())
        {
            return false;
        }
        
        return true;
    }
}