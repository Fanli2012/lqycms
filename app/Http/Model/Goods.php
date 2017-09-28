<?php
namespace App\Http\Model;

class Goods extends BaseModel
{
	//产品模型
	
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
	protected $table = 'goods';
	
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
	
    //常用字段
    protected static $common_field = array(
        'id', 'typeid', 'tuijian', 'click', 'title', 'sn', 'price','litpic', 'pubdate', 'add_time', 'market_price', 'goods_number', 'sale', 'comments','promote_start_date','promote_price','promote_end_date','goods_img','spec','point'
    );
    
    const STATUS = 0; //商品是否删除，0未删除
    
	/**
     * 获取关联到产品的分类
     */
    public function goodstype()
    {
        return $this->belongsTo(GoodsType::class, 'typeid', 'id');
    }
	
    //获取列表
	public static function getList(array $param)
    {
        extract($param); //参数：limit，offset
        
        $where = '';
        
        $limit  = isset($limit) ? $limit : 10;
        $offset = isset($offset) ? $offset : 0;
        
        $model = new Goods;
        
        if(isset($typeid)){$where['typeid'] = $typeid;}
        if(isset($tuijian)){$where['tuijian'] = $tuijian;}
        if(isset($status)){$where['status'] = $status;}else{$where['status'] = self::STATUS;}
        
        if($where !== '')
        {
            $model = $model->where($where);
        }
        
        if(isset($keyword)){$model = $model->where("title", "like", "%$keyword%")->orWhere("sn", "like", "%$keyword%");} //关键词搜索
        if(isset($max_price) && isset($min_price)){$model = $model->where("price", ">=", $min_price)->where("price", "<=", $max_price);} //价格区间搜索
        
        $res['count'] = $model->count();
        $res['list'] = array();
        
        //排序
        if(isset($orderby))
        {
            switch ($orderby)
            {
                case 1:
                    $model = $model->orderBy('sale','desc'); //销量从高到低
                    break;
                case 2:
                    $model = $model->orderBy('comments','desc'); //评论从高到低
                    break;
                case 3:
                    $model = $model->orderBy('price','desc'); //价格从高到低
                    break;
                case 4:
                    $model = $model->orderBy('price','asc'); //价格从低到高
                    break;
                default:
                    $model = $model->orderBy('pubdate','desc'); //价格从低到高
            }
        }
        
		if($res['count']>0)
        {
            $res['list']  = $model->select(self::$common_field)->skip($offset)->take($limit)->orderBy('id','desc')->get();
            
            if($res['list'])
            {
                foreach($res['list'] as $k=>$v)
                {
                    $res['list'][$k]->goods_detail_url = route('weixin_goods_detail',array('id'=>$v->id));
                }
            }
        }
        
        return $res;
    }
    
    public static function getOne(array $param)
    {
        extract($param);
        
        $model = new Goods;
        
        $where['id'] = $id;
        
        if(isset($where)){$model = $model->where($where);}
        if(isset($field)){$model = $model->select($field);}
        
        $goods = $model->first();
        
        if($goods)
        {
            $goods['goods_detail_url'] = route('weixin_goods_detail',array('id'=>$goods->id));
            $goods['price'] = self::get_final_price($id);
        }
        
        return $goods;
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
    
    /**
     * 取得商品最终使用价格
     *
     * @param   string  $goods_id      商品编号
     * @param   string  $goods_num     购买数量
     *
     * @return  商品最终购买价格
     */
    public static function get_final_price($goods_id)
    {
        $final_price   = '0'; //商品最终购买价格
        $promote_price = '0'; //商品促销价格
        $user_price    = '0'; //商品会员价格，预留
        
        //取得商品促销价格列表
        $goods = Goods::where('id',$goods_id)->where('status',0)->first(['promote_price','promote_start_date','promote_end_date','price']);
        $final_price = $goods->price;
        
        // 计算商品的促销价格
        if ($goods->promote_price > 0)
        {
            $promote_price = self::bargain_price($goods->promote_price, $goods->promote_start_date, $goods->promote_end_date);
        }
        else
        {
            $promote_price = 0;
        }
        
        if ($promote_price != 0)
        {
            $final_price = $promote_price;
        }
        
        //返回商品最终购买价格
        return $final_price;
    }
    
    /**
     * 判断某个商品是否正在特价促销期
     *
     * @access  public
     * @param   float   $price      促销价格
     * @param   string  $start      促销开始日期
     * @param   string  $end        促销结束日期
     * @return  float   如果还在促销期则返回促销价，否则返回0
     */
    public static function bargain_price($price, $start, $end)
    {
        if ($price == 0)
        {
            return 0;
        }
        else
        {
            $time = time();
            
            if ($time >= $start && $time <= $end)
            {
                return $price;
            }
            else
            {
                return 0;
            }
        }
    }
}