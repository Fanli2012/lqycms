<?php
namespace App\Http\Model;
use Illuminate\Support\Facades\DB;

class Article extends BaseModel
{
	//文章模型
	
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
	protected $table = 'article';
	const TABLE_NAME = 'article';
	/**
     * 表明模型是否应该被打上时间戳
     * 默认情况下，Eloquent 期望 created_at 和updated_at 已经存在于数据表中，如果你不想要这些 Laravel 自动管理的数据列，在模型类中设置 $timestamps 属性为 false
	 * 
     * @var bool
     */
    public $timestamps = false;
	
	//protected $guarded = []; //$guarded包含你不想被赋值的字段数组。
	//protected $fillable = ['name']; //定义哪些字段是可以进行赋值的,与$guarded相反
	
	/**
     * The connection name for the model.
     * 默认情况下，所有的 Eloquent 模型使用应用配置中的默认数据库连接，如果你想要为模型指定不同的连接，可以通过 $connection 属性来设置
     * @var string
     */
    //protected $connection = 'connection-name';
	
	const IS_CHECK = 0; // 已审核
	const UN_CHECK = 1; // 未审核
    
    //常用字段
    protected static $common_field = array(
        'id', 'typeid', 'tuijian', 'click', 'title', 'writer', 'source','litpic', 'pubdate', 'addtime', 'description', 'listorder'
    );
    
    public static function getDb()
    {
        return DB::table(self::TABLE_NAME);
    }
    
	/**
     * 获取关联到文章的分类
     */
    public function arctype()
    {
        return $this->belongsTo(Arctype::class, 'typeid', 'id');
    }
	
    /**
     * 列表
     * @param array $where 查询条件
     * @param string $order 排序
     * @param string $field 字段
     * @param int $offset 偏移量
     * @param int $limit 取多少条
     * @return array
     */
    public static function getList($where = array(), $order = '', $field = '*', $offset = 0, $limit = 10)
    {
        $model = self::getDb();
        if($where){$model = $model->where($where);}
        
        $res['count'] = $model->count();
        $res['list'] = array();
        
        if($res['count'] > 0)
        {
            if($field){if(is_array($field)){$model = $model->select($field);}else{$model = $model->select(\DB::raw($field));}}
            if($order){$model = parent::getOrderByData($model, $order);}
            if($offset){}else{$offset = 0;}
            if($limit){}else{$limit = 10;}
            
            $res['list'] = $model->skip($offset)->take($limit)->get();
        }
        
        return $res;
    }
    
    /* public static function getList(array $param)
    {
        extract($param); //参数：group_id，limit，offset
        
        $limit  = isset($limit) ? $limit : 10;
        $offset = isset($offset) ? $offset : 0;
        
        $model = new Article;
        
        if(isset($typeid)){$where['typeid'] = $typeid;}
        if(isset($ischeck)){$where['ischeck'] = $ischeck;}
        if(isset($keyword)){$model = $model->where("title", "like", "%$keyword%");} //关键词搜索
        
        if($where){$model = $model->where($where);}
        
        $res['count'] = $model->count();
        $res['list'] = array();
        
        //排序
        if(isset($orderby))
        {
            switch ($orderby)
            {
                case 1:
                    $model = $model->orderBy('click','desc'); //点击量从高到低
                    break;
                case 2:
                    $model = $model->orderBy('listorder','desc'); //排序
                    break;
                case 3:
                    $model = $model->orderBy('pubdate','desc'); //更新时间从高到低
                    break;
                default:
                    $model = $model->orderBy('addtime','desc'); //添加时间从高到低
            }
        }
        
		if($res['count']>0)
        {
            $res['list'] = $model->select(self::$common_field)->orderBy('id', 'desc')->skip($offset)->take($limit)->get();
        }
        
        return $res;
    } */
    
    /**
     * 分页，用于前端html输出
     * @param array $where 查询条件
     * @param string $order 排序
     * @param string $field 字段
     * @param int $limit 每页几条
     * @param int $page 当前第几页
     * @return array
     */
    public static function getPaginate($where = array(), $order = '', $field = '*', $limit = '')
    {
        $res = self::getDb();
        
        if($where){$res = $res->where($where);}
        if($field){if(is_array($field)){$res = $res->select($field);}else{$res = $res->select(\DB::raw($field));}}
        if($order){$res = parent::getOrderByData($res, $order);}
        if($limit){}else{$limit = 10;}
        
        return $res->paginate($limit);
    }
    
    /**
     * 查询全部
     * @param array $where 查询条件
     * @param string $order 排序
     * @param string $field 字段
     * @param int $limit 取多少条
     * @return array
     */
    public static function getAll($where = array(), $order = '', $field = '*', $limit = 10, $offset = 0)
    {
        $res = self::getDb();
        
        if($where){$res = $res->where($where);}
        if($field){if(is_array($field)){$res = $res->select($field);}else{$res = $res->select(\DB::raw($field));}}
        if($order){$res = parent::getOrderByData($res, $order);}
        if($offset){}else{$offset = 0;}
        if($limit){}else{$limit = 10;}
        
        $res = $res->skip($offset)->take($limit)->get();
        
        return $res;
    }
    
    /**
     * 获取一条
     * @param array $where 条件
     * @param string $field 字段
     * @return array
     */
    public static function getOne($where, $field = '*')
    {
        $res = self::getDb();
        
        if($where){$res = $res->where($where);}
        if($field){if(is_array($field)){$res = $res->select($field);}else{$res = $res->select(\DB::raw($field));}}
        
        $res = $res->find();
        
        return $res;
    }
    
    /**
     * 添加
     * @param array $data 数据
     * @return int
     */
    public static function add(array $data,$type = 0)
    {
        if($type==0)
        {
            // 新增单条数据并返回主键值
            return self::insertGetId(parent::filterTableColumn($data,self::TABLE_NAME));
        }
        elseif($type==1)
        {
            /**
             * 添加单条数据
             * $data = ['foo' => 'bar', 'bar' => 'foo'];
             * 添加多条数据
             * $data = [
             *     ['foo' => 'bar', 'bar' => 'foo'],
             *     ['foo' => 'bar1', 'bar' => 'foo1'],
             *     ['foo' => 'bar2', 'bar' => 'foo2']
             * ];
             */
            return self::insert($data);
        }
    }
    
    /**
     * 修改
     * @param array $data 数据
     * @param array $where 条件
     * @return bool
     */
    public static function edit($data, $where = array())
    {
        if (self::where($where)->update(parent::filterTableColumn($data,self::TABLE_NAME)) !== false)
        {
            return true;
        }
        
        return false;
    }
    
    /* public static function modify($where, array $data)
    {
        if (self::where($where)->update($data)!==false)
        {
            return true;
        }
        
        return false;
    } */
    
    //删除一条记录
    /* public static function remove($id)
    {
        return self::whereIn('id', explode(',', $id))->delete();
    } */
    
    /**
     * 删除
     * @param array $where 条件
     * @return bool
     */
    public static function del($where)
    {
        return self::where($where)->delete();
    }
    
    //是否审核
    public static function getIscheckAttr($data)
    {
        $arr = array(0 => '已审核', 1 => '未审核');
        return $arr[$data->ischeck];
    }
    
    //获取栏目名称
    public static function getTypenameAttr($data)
    {
        return DB::table('arctype')->where(array('id'=>$data['typeid']))->value('name');
    }
}