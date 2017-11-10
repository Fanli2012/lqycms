<?php
namespace App\Http\Model;
use App\Common\ReturnData;

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
	
	/**
     * 不能被批量赋值的属性
     *
     * @var array
     */
    protected $guarded = array();
	
    const IS_SHOW = 0;
    
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
    }
    
    //删除一条记录
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