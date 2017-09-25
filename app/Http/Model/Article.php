<?php
namespace App\Http\Model;

class Article extends BaseModel
{
	//文章模型
	
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
	protected $table = 'article';
	
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
    
	/**
     * 获取关联到文章的分类
     */
    public function arctype()
    {
        return $this->belongsTo(Arctype::class, 'typeid', 'id');
    }
	
    public static function getList(array $param)
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
            $res['list']  = $model->select(self::$common_field)->orderBy('id', 'desc')->skip($offset)->take($limit)->get();
            
            if($res['list'])
            {
                foreach($res['list'] as $k=>$v)
                {
                    $res['list'][$k]->article_detail_url = route('weixin_article_detail',array('id'=>$v->id));
                }
            }
        }
        else
        {
            return false;
        }
        
        return $res;
    }
    
    public static function getOne($param)
    {
        extract($param);
        
        $where['id'] = $id;
        if(isset($ischeck)){$where['ischeck'] = $ischeck;}
        
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
