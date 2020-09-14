<?php
namespace App\Http\Model;
use App\Common\Sms;
use App\Common\Helper;
use App\Common\ReturnData;
use DB;
use Log;

//验证码
class VerifyCode extends BaseModel
{
    protected $table = 'verify_code';
    public $timestamps = false;
    protected $hidden = array();
    protected $guarded = array(); //$guarded包含你不想被赋值的字段数组。
    
    
    const STATUS_UNUSE = 0;
    const STATUS_USE = 1;                                                       //验证码已被使用
    
    const TYPE_GENERAL = 0;                                                     //通用
    const TYPE_REGISTER = 1;                                                    //用户注册业务验证码
    const TYPE_CHANGE_PASSWORD = 2;                                             //密码修改业务验证码
    const TYPE_MOBILEE_BIND = 3;                                                //手机绑定业务验证码
	const TYPE_VERIFYCODE_LOGIN = 4;                                            //验证码登录
	const TYPE_CHANGE_MOBILE = 5;                                               //修改手机号码
	
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
    public function getList($where = array(), $order = '', $field = '*', $offset = 0, $limit = 15)
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
            if($limit){}else{$limit = 15;}
            
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
    public function getPaginate($where = array(), $order = '', $field = '*', $limit = 15)
    {
        $res = $this->getDb();
        
        if($where){$res = $res->where($where);}
        if($field){if(is_array($field)){$res = $res->select($field);}else{$res = $res->select(\DB::raw($field));}}
        if($order){$res = parent::getOrderByData($res, $order);}
        if($limit){}else{$limit = 15;}
        
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
    public function getAll($where = array(), $order = '', $field = '*', $limit = '', $offset = '')
    {
        $res = $this->getDb();
        
        if($where){$res = $res->where($where);}
        if($field){if(is_array($field)){$res = $res->select($field);}else{$res = $res->select(\DB::raw($field));}}
        if($order){$res = parent::getOrderByData($res, $order);}
        if($offset){$res = $res->skip($offset);}
        if($limit){$res = $res->take($limit);}
        
        $res = $res->get();
        
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
     * @return int
     */
    public function edit($data, $where = array())
    {
        $res = $this->getDb();
        return $res->where($where)->update(parent::filterTableColumn($data, $this->table));
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
    
    //验证码校验
    public static function isVerify($mobile, $code, $type)
    {
        return VerifyCode::Where('code', $code)->where('mobile', $mobile)->where('type', $type)->where('status', VerifyCode::STATUS_UNUSE)->where('expired_at', '>',  date('Y-m-d H:i:s'))->first();
    }
    
    //生成验证码
    public static function getVerifyCode($mobile,$type,$text='')
    {
        //验证手机号
        if (!Helper::isValidMobile($mobile))
        {
            return ReturnData::create(ReturnData::MOBILE_FORMAT_FAIL);
        }
        
        switch ($type)
        {
            case self::TYPE_GENERAL;//通用
                break;
            case self::TYPE_REGISTER: //用户注册业务验证码
                break;
            case self::TYPE_CHANGE_PASSWORD: //密码修改业务验证码
                break;
            case self::TYPE_MOBILEE_BIND: //手机绑定业务验证码
                break;
            case self::TYPE_VERIFYCODE_LOGIN: //验证码登录
                break;
            case VerifyCode::TYPE_CHANGE_MOBILE: //修改手机号码
                break;
            default:
                return ReturnData::create(ReturnData::INVALID_VERIFYCODE);
        }

        $verifyCode = new VerifyCode;
        $verifyCode->type = $type;
        $verifyCode->mobile = $mobile;
        $verifyCode->code = rand(1000, 9999);
        $verifyCode->status = self::STATUS_UNUSE;
        //10分钟有效
        $verifyCode->expired_at = date('Y-m-d H:i:s',(time()+60*20));
        
        //短信发送验证码
        if (strpos($verifyCode->mobile, '+') !== false)
        {
            $text = "【hoo】Your DC verification Code is: {$verifyCode->code}";
        }
        else
            $text = "【后】您的验证码是{$verifyCode->code}，有效期20分钟。";
        
        Sms::sendByYp($text,$verifyCode->mobile);
		
		$verifyCode->save();
		
        return ReturnData::create(ReturnData::SUCCESS,array('code' => $verifyCode->code));
    }
}