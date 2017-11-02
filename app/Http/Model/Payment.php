<?php
namespace App\Http\Model;
use App\Common\ReturnData;

class Payment extends BaseModel
{
	//用户优惠券
	
    protected $table = 'payment';
	public $timestamps = false;
	
	/**
     * 不能被批量赋值的属性
     *
     * @var array
     */
    protected $guarded = array();
	
    const STATUS = 1; // 可用支付方式
    
    //获取列表
	public static function getList(array $param)
    {
        extract($param); //参数：limit，offset
        
        $model = new Payment;
        
        if(isset($status) && $status!=-1){$where['status'] = $status;} //-1表示获取所有
        
        if(isset($where)){$model = $model->where($where);}
        
        $res['count'] = $model->count();
        $res['list'] = array();
        
		if($res['count']>0)
        {
            $res['list'] = $model->orderBy('listorder','desc')->get();
        }
        
        return $res;
    }
    
    public static function getOne($where)
    {
        return self::where($where)->first();
    }
    
    public static function add(array $data)
    {
        if(self::where(array('pay_code'=>$data['pay_code']))->first()){return ReturnData::create(ReturnData::PARAMS_ERROR,null,'支付方式已存在');}
        
        if ($id = self::insertGetId($data))
        {
            return ReturnData::create(ReturnData::SUCCESS,$id);
        }

        return ReturnData::create(ReturnData::SYSTEM_FAIL);
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