<?php
namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Arctype extends Model
{
	//文章分类模型
	
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
	protected $table = 'arctype';
	
	/**
     * 表明模型是否应该被打上时间戳
     * 默认情况下，Eloquent 期望 created_at 和updated_at 已经存在于数据表中，如果你不想要这些 Laravel 自动管理的数据列，在模型类中设置 $timestamps 属性为 false
	 * 
     * @var bool
     */
    public $timestamps = false;
	
	/**
     * The connection name for the model.
     * 默认情况下，所有的 Eloquent 模型使用应用配置中的默认数据库连接，如果你想要为模型指定不同的连接，可以通过 $connection 属性来设置
     * @var string
     */
    //protected $connection = 'connection-name';
	
    const IS_SHOW = 0; // 显示
	const UN_SHOW = 1; // 不显示
    
    //常用字段
    protected static $common_field = array(
        'id', 'pid', 'addtime', 'name', 'seotitle', 'keywords', 'description','typedir', 'templist', 'temparticle', 'litpic', 'listorder', 'is_show'
    );
    
	/**
	 * 获取分类对应的文章
	 */
	public function article()
	{
		return $this->hasMany(Article::class, 'typeid', 'id');
	}
	
    public static function getList(array $param)
    {
        extract($param); //参数：group_id，limit，offset
        
        $limit  = isset($limit) ? $limit : 10;
        $offset = isset($offset) ? $offset : 0;
        
        $model = new Arctype;
        
        if(isset($pid)){$where['pid'] = $pid;}
        if(isset($is_show)){$where['is_show'] = $is_show;}
        if(isset($keyword)){$model = $model->where("name", "like", "%$keyword%");} //关键词搜索
        
        if($where){$model = $model->where($where);}
        
        $res['count'] = $model->count();
        $res['list'] = array();
        
        //排序
        if(isset($orderby))
        {
            switch ($orderby)
            {
                case 1:
                    $model = $model->orderBy('listorder','desc'); //排序
                    break;
                case 2:
                    $model = $model->orderBy('addtime','desc'); //添加时间从高到低
                    break;
                default:
                    $model = $model->orderBy('id','desc'); //id从高到低
            }
        }
        
		if($res['count']>0)
        {
            $res['list'] = $model->select(self::$common_field)->orderBy('id', 'desc')->skip($offset)->take($limit)->get();
        }
        else
        {
            return false;
        }
        
        return $res;
    }
    
    public static function getOne(array $param)
    {
        extract($param);
        
        $where['id'] = $id;
        if(isset($is_show)){$where['is_show'] = $is_show;}
        
        return self::where($where)->first();
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