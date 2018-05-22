<?php
namespace App\Http\Model;
use DB;
use Log;

/**
 * 微信自定义菜单
 * 1、自定义菜单最多包括3个一级菜单，每个一级菜单最多包含5个二级菜单。
 * 2、一级菜单最多4个汉字，二级菜单最多7个汉字，多出来的部分将会以“...”代替。
 * 3、创建自定义菜单后，菜单的刷新策略是，在用户进入公众号会话页或公众号profile页时，如果发现上一次拉取菜单的请求在5分钟以前，就会拉取一下菜单，如果菜单有更新，就会刷新客户端的菜单。测试时可以尝试取消关注公众账号后再次关注，则可以看到创建后的效果。
 */
class WeixinMenu extends BaseModel
{
    protected $table = 'weixin_menu';
    public $timestamps = false;
	protected $guarded = []; //$guarded包含你不想被赋值的字段数组。
	
    const IS_SHOW = 0;
    
    public function getDb()
    {
        return DB::table($this->table);
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
    public function getList($where = array(), $order = '', $field = '*', $offset = 0, $limit = 10)
    {
        $model = $this->getDb();
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
    
    /**
     * 分页，用于前端html输出
     * @param array $where 查询条件
     * @param string $order 排序
     * @param string $field 字段
     * @param int $limit 每页几条
     * @param int $page 当前第几页
     * @return array
     */
    public function getPaginate($where = array(), $order = '', $field = '*', $limit = 10)
    {
        $res = $this->getDb();
        
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
    public function getAll($where = array(), $order = '', $field = '*', $limit = 10, $offset = 0)
    {
        $res = $this->getDb();
        
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
    public function getOne($where, $field = '*')
    {
        $res = $this->getDb();
        
        if($where){$res = $res->where($where);}
        if($field){if(is_array($field)){$res = $res->select($field);}else{$res = $res->select(\DB::raw($field));}}
        
        $res = $res->first();
        
        return $res;
    }
    
    /**
     * 添加
     * @param array $data 数据
     * @return int
     */
    public function add(array $data,$type = 0)
    {
        if($type==0)
        {
            // 新增单条数据并返回主键值
            return self::insertGetId(parent::filterTableColumn($data,$this->table));
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
    public function edit($data, $where = array())
    {
        $res = $this->getDb();
        $res = $res->where($where)->update(parent::filterTableColumn($data, $this->table));
        
        if ($res === false)
        {
            return false;
        }
        
        return true;
    }
    
    /**
     * 删除
     * @param array $where 条件
     * @return bool
     */
    public function del($where)
    {
        $res = $this->getDb();
        $res = $res->where($where)->delete();
        
        return $res;
    }
    
    /* 
    //获取列表
	public static function getList(array $param)
    {
        extract($param); //参数：limit，offset
        
        if(isset($is_show) && $is_show!=-1){$where['is_show'] = $is_show;} //-1表示获取所有
        $where['pid'] = 0;
        
        $list = self::where($where)->orderBy('listorder', 'asc')->get();
        
        if($list)
        {
            foreach($list as $k=>$v)
            {
                $res[] = $v;
                $child = self::where(array('pid'=>$list[$k]->id,'is_show'=>self::IS_SHOW))->orderBy('listorder', 'asc')->get();
                
                if($child)
                {
                    foreach($child as $key=>$value)
                    {
                        $res[] = $value;
                    }
                }
            }
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
    } */
    
    //获取微信自定义菜单
    public static function getWeixinMenuJson()
    {
        $where['pid'] = 0;
        $where['is_show'] = self::IS_SHOW;
        $list = self::where($where)->orderBy('listorder', 'asc')->get();
        
        $res='';
        if($list)
        {
            foreach($list as $k=>$v)
            {
                $child = self::where(array('pid'=>$list[$k]->id,'is_show'=>self::IS_SHOW))->orderBy('listorder', 'asc')->get();
                
                if($child)
                {
                    $temp_child='';
                    foreach($child as $key=>$value)
                    {
                        if($value->type == 'click')
                        {
                            $temp_child[] = array(
                                'type'=>$value->type,
                                'name'=>$value->name,
                                'key'=>$value->key
                            );
                        }
                        elseif($value->type == 'view')
                        {
                            $temp_child[] = array(
                                'type'=>$value->type,
                                'name'=>$value->name,
                                'url'=>$value->key
                            );
                        }
                        elseif($value->type == 'miniprogram')
                        {
                            $temp_child[] = array(
                                'type'=>$value->type,
                                'name'=>$value->name,
                                'url'=>$value->key,
                                'appid'=>$value->appid,
                                'pagepath'=>$value->pagepath
                            );
                        }
                    }
                    
                    $res[] = array(
                        'name'=>$value->name,
                        'sub_button'=>$temp_child
                    );
                }
                else
                {
                    if($v->type == 'click')
                    {
                        $res[] = array(
                            'type'=>$v->type,
                            'name'=>$v->name,
                            'key'=>$v->key
                        );
                    }
                    elseif($v->type == 'view')
                    {
                        $res[] = array(
                            'type'=>$v->type,
                            'name'=>$v->name,
                            'url'=>$v->key
                        );
                    }
                    elseif($v->type == 'miniprogram')
                    {
                        $res[] = array(
                            'type'=>$v->type,
                            'name'=>$v->name,
                            'url'=>$v->key,
                            'appid'=>$v->appid,
                            'pagepath'=>$v->pagepath
                        );
                    }
                }
            }
        }
        
        return json_encode($res);
    }
}