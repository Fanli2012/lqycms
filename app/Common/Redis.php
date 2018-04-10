<?php
namespace App\Common;

/**
 * redis操作类
 * 说明，任何为false的串，存在redis中都是空串。
 * 只有在key不存在时，才会返回false。
 * 这点可用于防止缓存穿透
 *
 */
class Redis
{
    private $redis;
    
    //当前数据库ID号
    protected $dbId=0;
    
    //当前权限认证码
    protected $auth;
    
    /**
     * 实例化的对象,单例模式.
     * @var \iphp\db\Redis
     */
    static private $_instance=array();
    
    private  $k;
    
    //连接属性数组
    protected $attr=array(
        //连接超时时间，redis配置文件中默认为300秒
        'timeout'=>30,
        //选择的数据库。
        'db_id'=>0,
    );
    
    //什么时候重新建立连接
    protected $expireTime;
    
    protected $host;
    protected $port;
    
    private function __construct($config,$attr=array())
    {
        $this->attr        =    array_merge($this->attr,$attr);
        $this->redis       =    new \Redis();
        $this->port        =    $config['port'] ? $config['port'] : 6379;
        $this->host        =    $config['host'];
        $this->redis->connect($this->host, $this->port, $this->attr['timeout']);
         
        if($config['auth'])
        {
            $this->auth($config['auth']);
            $this->auth    =    $config['auth'];
        }
         
        $this->expireTime  =    time() + $this->attr['timeout'];
    }
     
    /**
     * 得到实例化的对象.
     * 为每个数据库建立一个连接
     * 如果连接超时，将会重新建立一个连接
     * @param array $config
     * @param int $dbId
     * @return \iphp\db\Redis
     */
    public static function getInstance($config, $attr = array())
    {
        //如果是一个字符串，将其认为是数据库的ID号。以简化写法。
        if(!is_array($attr))
        {
            $dbId = $attr;
            $attr    =    array();
            $attr['db_id'] = $dbId;
        }
         
        $attr['db_id'] = $attr['db_id'] ? $attr['db_id'] : 0;
        
         
        $k = md5(implode('', $config).$attr['db_id']);
        if(! (static::$_instance[$k] instanceof self))
        {
            static::$_instance[$k] = new self($config,$attr);
            static::$_instance[$k]->k       =    $k;
            static::$_instance[$k]->dbId    =    $attr['db_id'];
             
            //如果不是0号库，选择一下数据库。
            if($attr['db_id'] != 0){
                static::$_instance[$k]->select($attr['db_id']);
            }
        }
        elseif( time() > static::$_instance[$k]->expireTime)
        {
            static::$_instance[$k]->close();
            static::$_instance[$k]       =     new self($config,$attr);
            static::$_instance[$k]->k    =    $k;
            static::$_instance[$k]->dbId =    $attr['db_id'];
              
            //如果不是0号库，选择一下数据库。
            if($attr['db_id']!=0)
            {
                static::$_instance[$k]->select($attr['db_id']);
            }
        }
        
        return static::$_instance[$k];
    }
     
    private function __clone(){}
     
    /**
     * 执行原生的redis操作
     * @return \Redis
     */
    public function getRedis()
    {
        return $this->redis;
    }
     
    /*****************hash表操作函数*******************/
     
    /**
     * 得到hash表中一个字段的值
     * @param string $key 缓存key
     * @param string  $field 字段
     * @return string|false
     */
    public function hGet($key,$field)
    {
        return $this->redis->hGet($key,$field);
    }
     
    /**
     * 为hash表设定一个字段的值
     * @param string $key 缓存key
     * @param string  $field 字段
     * @param string $value 值。
     * @return bool 
     */
    public function hSet($key,$field,$value)
    {
        return $this->redis->hSet($key,$field,$value);
    }
     
    /**
     * 判断hash表中，指定field是不是存在
     * @param string $key 缓存key
     * @param string  $field 字段
     * @return bool
     */
    public function hExists($key,$field)
    {
        return $this->redis->hExists($key,$field);
    }
     
    /**
     * 删除hash表中指定字段 ,支持批量删除
     * @param string $key 缓存key
     * @param string  $field 字段
     * @return int
     */
    public function hdel($key,$field)
    {
        $fieldArr=explode(',',$field);
        $delNum=0;
 
        foreach($fieldArr as $row)
        {
            $row=trim($row);
            $delNum+=$this->redis->hDel($key,$row);
        }
 
        return $delNum;
    }
     
    /**
     * 返回hash表元素个数
     * @param string $key 缓存key
     * @return int|bool
     */
    public function hLen($key)
    {
        return $this->redis->hLen($key);
    }
     
    /**
     * 为hash表设定一个字段的值,如果字段存在，返回false
     * @param string $key 缓存key
     * @param string  $field 字段
     * @param string $value 值。
     * @return bool
     */
    public function hSetNx($key,$field,$value)
    {
        return $this->redis->hSetNx($key,$field,$value);
    }
     
    /**
     * 为hash表多个字段设定值。
     * @param string $key
     * @param array $value
     * @return array|bool
     */
    public function hMset($key,$value)
    {
        if(!is_array($value))
            return false;
        return $this->redis->hMset($key,$value); 
    }
     
    /**
     * 为hash表多个字段设定值。
     * @param string $key
     * @param array|string $value string以','号分隔字段
     * @return array|bool
     */
    public function hMget($key,$field)
    {
        if(!is_array($field))
            $field=explode(',', $field);
        return $this->redis->hMget($key,$field);
    }
     
    /**
     * 为hash表设这累加，可以负数
     * @param string $key
     * @param int $field
     * @param string $value
     * @return bool
     */
    public function hIncrBy($key,$field,$value)
    {
        $value=intval($value);
        return $this->redis->hIncrBy($key,$field,$value);
    }
     
    /**
     * 返回所有hash表的所有字段
     * @param string $key
     * @return array|bool
     */
    public function hKeys($key)
    {
        return $this->redis->hKeys($key);
    }
     
    /**
     * 返回所有hash表的字段值，为一个索引数组
     * @param string $key
     * @return array|bool
     */
    public function hVals($key)
    {
        return $this->redis->hVals($key);
    }
     
    /**
     * 返回所有hash表的字段值，为一个关联数组
     * @param string $key
     * @return array|bool
     */
    public function hGetAll($key)
    {
        return $this->redis->hGetAll($key);
    }
     
    /*********************有序集合操作*********************/
     
    /**
     * 给当前集合添加一个元素
     * 如果value已经存在，会更新order的值。
     * @param string $key
     * @param string $order 序号
     * @param string $value 值
     * @return bool
     */
    public function zAdd($key,$order,$value)
    {
        return $this->redis->zAdd($key,$order,$value);   
    }
     
    /**
     * 给$value成员的order值，增加$num,可以为负数
     * @param string $key
     * @param string $num 序号
     * @param string $value 值
     * @return 返回新的order
     */
    public function zinCry($key,$num,$value)
    {
        return $this->redis->zinCry($key,$num,$value);
    }
     
    /**
     * 删除值为value的元素
     * @param string $key
     * @param stirng $value
     * @return bool
     */
    public function zRem($key,$value)
    {
        return $this->redis->zRem($key,$value);
    }
     
    /**
     * 集合以order递增排列后，0表示第一个元素，-1表示最后一个元素
     * @param string $key
     * @param int $start
     * @param int $end
     * @return array|bool
     */
    public function zRange($key,$start,$end)
    {
        return $this->redis->zRange($key,$start,$end);
    }
     
    /**
     * 集合以order递减排列后，0表示第一个元素，-1表示最后一个元素
     * @param string $key
     * @param int $start
     * @param int $end
     * @return array|bool
     */
    public function zRevRange($key,$start,$end)
    {
        return $this->redis->zRevRange($key,$start,$end);
    }
     
    /**
     * 集合以order递增排列后，返回指定order之间的元素。
     * min和max可以是-inf和+inf　表示最大值，最小值
     * @param string $key
     * @param int $start
     * @param int $end
     * @package array $option 参数
     *     withscores=>true，表示数组下标为Order值，默认返回索引数组
     *     limit=>array(0,1) 表示从0开始，取一条记录。
     * @return array|bool
     */
    public function zRangeByScore($key,$start='-inf',$end="+inf",$option=array())
    {
        return $this->redis->zRangeByScore($key,$start,$end,$option);
    }
     
    /**
     * 集合以order递减排列后，返回指定order之间的元素。
     * min和max可以是-inf和+inf　表示最大值，最小值
     * @param string $key
     * @param int $start
     * @param int $end
     * @package array $option 参数
     *     withscores=>true，表示数组下标为Order值，默认返回索引数组
     *     limit=>array(0,1) 表示从0开始，取一条记录。
     * @return array|bool
     */
    public function zRevRangeByScore($key,$start='-inf',$end="+inf",$option=array())
    {
        return $this->redis->zRevRangeByScore($key,$start,$end,$option);
    }
     
    /**
     * 返回order值在start end之间的数量
     * @param unknown $key
     * @param unknown $start
     * @param unknown $end
     */
    public function zCount($key,$start,$end)
    {
        return $this->redis->zCount($key,$start,$end);
    }
     
    /**
     * 返回值为value的order值
     * @param unknown $key
     * @param unknown $value
     */
    public function zScore($key,$value)
    {
        return $this->redis->zScore($key,$value);
    }
     
    /**
     * 返回集合以score递增加排序后，指定成员的排序号，从0开始。
     * @param unknown $key
     * @param unknown $value
     */
    public function zRank($key,$value)
    {
        return $this->redis->zRank($key,$value);
    }
     
    /**
     * 返回集合以score递增加排序后，指定成员的排序号，从0开始。
     * @param unknown $key
     * @param unknown $value
     */
    public function zRevRank($key,$value)
    {
        return $this->redis->zRevRank($key,$value);
    }
     
    /**
     * 删除集合中，score值在start end之间的元素　包括start end
     * min和max可以是-inf和+inf　表示最大值，最小值
     * @param unknown $key
     * @param unknown $start
     * @param unknown $end
     * @return 删除成员的数量。
     */
    public function zRemRangeByScore($key,$start,$end)
    {
        return $this->redis->zRemRangeByScore($key,$start,$end);
    }
     
    /**
     * 返回集合元素个数。
     * @param unknown $key
     */
    public function zCard($key)
    {
        return $this->redis->zCard($key);
    }
    /*********************队列操作命令************************/
     
    /**
     * 在队列尾部插入一个元素
     * @param unknown $key
     * @param unknown $value
     * 返回队列长度
     */
    public function rPush($key,$value)
    {
        return $this->redis->rPush($key,$value); 
    }
     
    /**
     * 在队列尾部插入一个元素 如果key不存在，什么也不做
     * @param unknown $key
     * @param unknown $value
     * 返回队列长度
     */
    public function rPushx($key,$value)
    {
        return $this->redis->rPushx($key,$value);
    }
     
    /**
     * 在队列头部插入一个元素
     * @param unknown $key
     * @param unknown $value
     * 返回队列长度
     */
    public function lPush($key,$value)
    {
        return $this->redis->lPush($key,$value);
    }
     
    /**
     * 在队列头插入一个元素 如果key不存在，什么也不做
     * @param unknown $key
     * @param unknown $value
     * 返回队列长度
     */
    public function lPushx($key,$value)
    {
        return $this->redis->lPushx($key,$value);
    }
     
    /**
     * 返回队列长度
     * @param unknown $key
     */
    public function lLen($key)
    {
        return $this->redis->lLen($key); 
    }
     
    /**
     * 返回队列指定区间的元素
     * @param unknown $key
     * @param unknown $start
     * @param unknown $end
     */
    public function lRange($key,$start,$end)
    {
        return $this->redis->lrange($key,$start,$end);
    }
     
    /**
     * 返回队列中指定索引的元素
     * @param unknown $key
     * @param unknown $index
     */
    public function lIndex($key,$index)
    {
        return $this->redis->lIndex($key,$index);
    }
     
    /**
     * 设定队列中指定index的值。
     * @param unknown $key
     * @param unknown $index
     * @param unknown $value
     */
    public function lSet($key,$index,$value)
    {
        return $this->redis->lSet($key,$index,$value);
    }
     
    /**
     * 删除值为vaule的count个元素
     * PHP-REDIS扩展的数据顺序与命令的顺序不太一样，不知道是不是bug
     * count>0 从尾部开始
     *  >0　从头部开始
     *  =0　删除全部
     * @param unknown $key
     * @param unknown $count
     * @param unknown $value
     */
    public function lRem($key,$count,$value)
    {
        return $this->redis->lRem($key,$value,$count);
    }
     
    /**
     * 删除并返回队列中的头元素。
     * @param unknown $key
     */
    public function lPop($key)
    {
        return $this->redis->lPop($key);
    }
     
    /**
     * 删除并返回队列中的尾元素
     * @param unknown $key
     */
    public function rPop($key)
    {
        return $this->redis->rPop($key);
    }
     
    /*************redis字符串操作命令*****************/
     
    /**
     * 设置一个key
     * @param unknown $key
     * @param unknown $value
     */
    public function set($key,$value)
    {
        return $this->redis->set($key,$value);
    }
     
    /**
     * 得到一个key
     * @param unknown $key
     */
    public function get($key)
    {
        return $this->redis->get($key);
    }
     
    /**
     * 设置一个有过期时间的key
     * @param unknown $key
     * @param unknown $expire
     * @param unknown $value
     */
    public function setex($key,$expire,$value)
    {
        return $this->redis->setex($key,$expire,$value);
    }
     
     
    /**
     * 设置一个key,如果key存在,不做任何操作.
     * @param unknown $key
     * @param unknown $value
     */
    public function setnx($key,$value)
    {
        return $this->redis->setnx($key,$value);
    }
     
    /**
     * 批量设置key
     * @param unknown $arr
     */
    public function mset($arr)
    {
        return $this->redis->mset($arr);
    }
     
    /*************redis　无序集合操作命令*****************/
     
    /**
     * 返回集合中所有元素
     * @param unknown $key
     */
    public function sMembers($key)
    {
        return $this->redis->sMembers($key);
    }
     
    /**
     * 求2个集合的差集
     * @param unknown $key1
     * @param unknown $key2
     */
    public function sDiff($key1,$key2)
    {
        return $this->redis->sDiff($key1,$key2);
    }
     
    /**
     * 添加集合。由于版本问题，扩展不支持批量添加。这里做了封装
     * @param unknown $key
     * @param string|array $value
     */
    public function sAdd($key,$value)
    {
        if(!is_array($value))
            $arr=array($value);
        else
            $arr=$value;
        foreach($arr as $row)
            $this->redis->sAdd($key,$row);
    }
     
    /**
     * 返回无序集合的元素个数
     * @param unknown $key
     */
    public function scard($key)
    {
        return $this->redis->scard($key);
    }
     
    /**
     * 从集合中删除一个元素
     * @param unknown $key
     * @param unknown $value
     */
    public function srem($key,$value)
    {
        return $this->redis->srem($key,$value);
    }
     
    /*************redis管理操作命令*****************/
     
    /**
     * 选择数据库
     * @param int $dbId 数据库ID号
     * @return bool
     */
    public function select($dbId)
    {
        $this->dbId=$dbId;
        return $this->redis->select($dbId);
    }
     
    /**
     * 清空当前数据库
     * @return bool
     */
    public function flushDB()
    {
        return $this->redis->flushDB();
    }
     
    /**
     * 返回当前库状态
     * @return array
     */
    public function info()
    {
        return $this->redis->info();
    }
     
    /**
     * 同步保存数据到磁盘
     */
    public function save()
    {
        return $this->redis->save();
    }
     
    /**
     * 异步保存数据到磁盘
     */
    public function bgSave()
    {
        return $this->redis->bgSave();
    }
     
    /**
     * 返回最后保存到磁盘的时间
     */
    public function lastSave()
    {
        return $this->redis->lastSave();
    }
     
    /**
     * 返回key,支持*多个字符，?一个字符
     * 只有*　表示全部
     * @param string $key
     * @return array
     */
    public function keys($key)
    {
        return $this->redis->keys($key);
    }
     
    /**
     * 删除指定key
     * @param unknown $key
     */
    public function del($key)
    {
        return $this->redis->del($key);
    }
     
    /**
     * 判断一个key值是不是存在
     * @param unknown $key
     */
    public function exists($key)
    {
        return $this->redis->exists($key);
    }
     
    /**
     * 为一个key设定过期时间 单位为秒
     * @param unknown $key
     * @param unknown $expire
     */
    public function expire($key,$expire)
    {
        return $this->redis->expire($key,$expire);
    }
     
    /**
     * 返回一个key还有多久过期，单位秒
     * @param unknown $key
     */
    public function ttl($key)
    {
        return $this->redis->ttl($key);
    }
     
    /**
     * 设定一个key什么时候过期，time为一个时间戳
     * @param unknown $key
     * @param unknown $time
     */
    public function exprieAt($key,$time)
    {
        return $this->redis->expireAt($key,$time);
    }
     
    /**
     * 关闭服务器链接
     */
    public function close()
    {
        return $this->redis->close();
    }
     
    /**
     * 关闭所有连接
     */
    public static function closeAll()
    {
        foreach(static::$_instance as $o)
        {
            if($o instanceof self)
                $o->close();
        }
    }
     
    /** 这里不关闭连接，因为session写入会在所有对象销毁之后。
    public function __destruct()
    {
        return $this->redis->close();
    }
    **/
    /**
     * 返回当前数据库key数量
     */
    public function dbSize()
    {
        return $this->redis->dbSize();
    }
     
    /**
     * 返回一个随机key
     */
    public function randomKey()
    {
        return $this->redis->randomKey();
    }
     
    /**
     * 得到当前数据库ID
     * @return int
     */
    public function getDbId()
    {
        return $this->dbId;
    }
     
    /**
     * 返回当前密码
     */
    public function getAuth()
    {
        return $this->auth;
    }
     
    public function getHost()
    {
        return $this->host;
    }
     
    public function getPort()
    {
        return $this->port;
    }
     
    public function getConnInfo()
    {
        return array(
            'host'=>$this->host,
            'port'=>$this->port,
            'auth'=>$this->auth
        );
    }
    /*********************事务的相关方法************************/
     
    /**
     * 监控key,就是一个或多个key添加一个乐观锁
     * 在此期间如果key的值如果发生的改变，刚不能为key设定值
     * 可以重新取得Key的值。
     * @param unknown $key
     */
    public function watch($key)
    {
        return $this->redis->watch($key);
    }
     
    /**
     * 取消当前链接对所有key的watch
     *  EXEC 命令或 DISCARD 命令先被执行了的话，那么就不需要再执行 UNWATCH 了
     */
    public function unwatch()
    {
        return $this->redis->unwatch();
    }
     
    /**
     * 开启一个事务
     * 事务的调用有两种模式Redis::MULTI和Redis::PIPELINE，
     * 默认是Redis::MULTI模式，
     * Redis::PIPELINE管道模式速度更快，但没有任何保证原子性有可能造成数据的丢失
     */
    public function multi($type=\Redis::MULTI)
    {
        return $this->redis->multi($type);
    }
     
    /**
     * 执行一个事务
     * 收到 EXEC 命令后进入事务执行，事务中任意命令执行失败，其余的命令依然被执行
     */
    public function exec()
    {
        return $this->redis->exec();
    }
     
    /**
     * 回滚一个事务
     */
    public function discard()
    {
        return $this->redis->discard();
    }
     
    /**
     * 测试当前链接是不是已经失效
     * 没有失效返回+PONG
     * 失效返回false
     */
    public function ping()
    {
        return $this->redis->ping();
    }
     
    public function auth($auth)
    {
        return $this->redis->auth($auth);
    }
    /*********************自定义的方法,用于简化操作************************/
     
    /**
     * 得到一组的ID号
     * @param unknown $prefix
     * @param unknown $ids
     */
    public function hashAll($prefix,$ids)
    {
        if($ids==false)
            return false;
        if(is_string($ids))
            $ids=explode(',', $ids);
        $arr=array();
        foreach($ids as $id)
        {
            $key=$prefix.'.'.$id;
            $res=$this->hGetAll($key);
            if($res!=false)
                $arr[]=$res;
        }
         
        return $arr;
    }
     
    /**
     * 生成一条消息，放在redis数据库中。使用0号库。
     * @param string|array $msg
     */
    public function pushMessage($lkey,$msg)
    {
        if(is_array($msg)){
            $msg    =    json_encode($msg);
        }
        $key    =    md5($msg);
         
        //如果消息已经存在，删除旧消息，已当前消息为准
        //echo $n=$this->lRem($lkey, 0, $key)."\n";
        //重新设置新消息
        $this->lPush($lkey, $key);
        $this->setex($key, 3600, $msg);
        return $key;
    }
     
     
    /**
     * 得到条批量删除key的命令
     * @param unknown $keys
     * @param unknown $dbId
     */
    public function delKeys($keys,$dbId)
    {
        $redisInfo=$this->getConnInfo();
        $cmdArr=array(
            'redis-cli',
            '-a',
            $redisInfo['auth'],
            '-h',
            $redisInfo['host'],
            '-p',
            $redisInfo['port'],
            '-n',
            $dbId,
        );
        $redisStr=implode(' ', $cmdArr);
        $cmd="{$redisStr} KEYS \"{$keys}\" | xargs {$redisStr} del";
        return $cmd;
    }
}