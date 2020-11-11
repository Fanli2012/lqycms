<?php
namespace App\Http\Logic;
use Illuminate\Support\Facades\DB;
use App\Common\ReturnData;
use App\Http\Model\UserPoint;
use App\Http\Requests\UserPointRequest;
use Validator;

class UserPointLogic extends BaseLogic
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function getModel()
    {
        return new UserPoint();
    }
    
    public function getValidate($data, $scene_name)
    {
        //数据验证
        $validate = new UserPointRequest();
        return Validator::make($data, $validate->getSceneRules($scene_name), $validate->getSceneRulesMessages());
    }
    
    //列表
    public function getList($where = array(), $order = '', $field = '*', $offset = '', $limit = '')
    {
        $res = $this->getModel()->getList($where, $order, $field, $offset, $limit);
        
        if($res['count'] > 0)
        {
            foreach($res['list'] as $k=>$v)
            {
                $res['list'][$k] = $this->getDataView($v);
            }
        }
        
        return $res;
    }
    
    //分页html
    public function getPaginate($where = array(), $order = '', $field = '*', $limit = '')
    {
        $res = $this->getModel()->getPaginate($where, $order, $field, $limit);
        
        if($res->count() > 0)
        {
            foreach($res as $k=>$v)
            {
                $res[$k] = $this->getDataView($v);
            }
        }
        
        return $res;
    }
    
    //全部列表
    public function getAll($where = array(), $order = '', $field = '*', $limit = '')
    {
        $res = $this->getModel()->getAll($where, $order, $field, $limit);
        
        if($res)
        {
            foreach($res as $k=>$v)
            {
                $res[$k] = $this->getDataView($v);
            }
        }
        
        return $res;
    }
    
    //详情
    public function getOne($where = array(), $field = '*')
    {
        $res = $this->getModel()->getOne($where, $field);
        if(!$res){return false;}
        
        $res = $this->getDataView($res);
        
        return $res;
    }
    
    /**
     * 添加一条记录，并增加或减少用户余额，会操作用户积分，谨慎使用
     * @param int    $data['user_id'] 排序
     * @param int    $data['type'] 0增加,1减少
     * @param float  $data['point'] 积分
     * @param string $data['des'] 描述
     * @return array
     */
    public function add($data = array(), $type=0)
    {
        if(empty($data)){return ReturnData::create(ReturnData::PARAMS_ERROR);}
        
        $validator = $this->getValidate($data, 'add');
        if ($validator->fails()){return ReturnData::create(ReturnData::PARAMS_ERROR, null, $validator->errors()->first());}
        
        if($data['point']<=0){return ReturnData::create(ReturnData::PARAMS_ERROR);}
        
        $data['add_time'] = time();
        
        DB::beginTransaction(); //启动事务
        
        if($data['type'] == UserPoint::USER_POINT_INCREMENT)
        {
            //增加用户余额
            model('User')->getDb()->where(array('id'=>$data['user_id']))->increment('point', $data['point']);
        }
        elseif($data['type'] == UserPoint::USER_POINT_DECREMENT)
        {
            //减少用户余额
            model('User')->getDb()->where(array('id'=>$data['user_id']))->decrement('point', $data['point']);
        }
        else
        {
            DB::rollBack(); //事务回滚
            return ReturnData::create(ReturnData::FAIL);
        }
        
        $user_point = model('User')->getDb()->where(array('id'=>$data['user_id']))->value('point'); //用户余额
        $data['user_point'] = $user_point;
        
        $res = $this->getModel()->add($data,$type);
        if($res)
        {
            DB::commit(); //事务提交
            return ReturnData::create(ReturnData::SUCCESS,$res);
        }
        
        return ReturnData::create(ReturnData::FAIL);
    }
    
    //修改
    public function edit($data, $where = array())
    {
        if(empty($data)){return ReturnData::create(ReturnData::SUCCESS);}
        
        $validator = $this->getValidate($data, 'edit');
        if ($validator->fails()){return ReturnData::create(ReturnData::PARAMS_ERROR, null, $validator->errors()->first());}
        
        $res = $this->getModel()->edit($data,$where);
        if($res){return ReturnData::create(ReturnData::SUCCESS,$res);}
        
        return ReturnData::create(ReturnData::FAIL);
    }
    
    //删除
    public function del($where)
    {
        if(empty($where)){return ReturnData::create(ReturnData::PARAMS_ERROR);}
        
        $validator = $this->getValidate($where,'del');
        if ($validator->fails()){return ReturnData::create(ReturnData::PARAMS_ERROR, null, $validator->errors()->first());}
        
        $res = $this->getModel()->del($where);
        if($res){return ReturnData::create(ReturnData::SUCCESS,$res);}
        
        return ReturnData::create(ReturnData::FAIL);
    }
    
    /**
     * 数据获取器
     * @param array $data 要转化的数据
     * @return array
     */
    private function getDataView($data = array())
    {
        return getDataAttr($this->getModel(),$data);
    }
}