<?php
namespace App\Http\Model;

use App\Common\Token;

class GoodsType extends BaseModel
{
	//产品分类模型
	
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
	protected $table = 'goods_type';
	public $timestamps = false;
	
	/**
	 * 获取分类对应的产品
	 */
	public function goods()
	{
		return $this->hasMany(GoodsType::class, 'typeid', 'id');
	}
	
    //获取列表
	public static function getList(array $param)
    {
        extract($param); //参数：limit，offset
        
        $where = '';
        
        $limit  = isset($limit) ? $limit : 10;
        $offset = isset($offset) ? $offset : 0;
        
        $model = new GoodsType;
        
        if(isset($pid)){$where['pid'] = $pid;}
        
        if($where !== '')
        {
            $model = $model->where($where);
        }
        
        $res['count'] = $model->count();
        $res['list'] = array();
        
		if($res['count']>0)
        {
            $res['list']  = $model->skip($offset)->take($limit)->orderBy('listorder','desc')->get()->toArray();
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
            return $id;
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