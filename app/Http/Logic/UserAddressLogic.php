<?php
namespace App\Http\Logic;
use App\Common\ReturnData;
use App\Http\Model\Region;
use App\Http\Model\UserAddress;
use App\Http\Requests\UserAddressRequest;
use Validator;

class UserAddressLogic extends BaseLogic
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function getModel()
    {
        return new UserAddress();
    }
    
    public function getValidate($data, $scene_name)
    {
        //数据验证
        $validate = new UserAddressRequest();
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
                $res['list'][$k] = $this->getProvinceCityDistrictText($res['list'][$k]);
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
    
    /**
     * 获取一条记录，不传id表示获取默认地址
     * @param int $where['id'] user_address表id，选填
     * @param int $where['user_id'] 用户id
     * @return array
     */
    public function getOne($where = array(), $field = '*')
    {
        //获取默认地址
        if (isset($where['id']) && $where['id']!='' && $where['id']!=0)
        {
            
        }
        else
        {
            $user_address_id = model('User')->getDb()->where(['id'=>$where['user_id']])->value('address_id');
            if($user_address_id){$where['id'] = $user_address_id;}else{$where['is_default'] = UserAddress::IS_DEFAULT;}
        }
        
        $res = $this->getModel()->getOne($where, $field);
        if(!$res){return false;}
        
        $res = $this->getDataView($res);
        $res = $this->getProvinceCityDistrictText($res);
        
        return $res;
    }
    
    //添加
    public function add($data = array(), $type=0)
    {
        if(empty($data)){return ReturnData::create(ReturnData::PARAMS_ERROR);}
        
        $validator = $this->getValidate($data, 'add');
        if ($validator->fails()){return ReturnData::create(ReturnData::PARAMS_ERROR, null, $validator->errors()->first());}
        
        if(model('UserAddress')->getDb()->where('user_id', $data['user_id'])->count() >= 10)
        {
            return ReturnData::create(ReturnData::PARAMS_ERROR,null,'最多10个收货地址');
        }
        
        $res = $this->getModel()->add($data,$type);
        if($res)
        {
            $user_address = model('User')->getDb()
                    ->join('user_address', 'user.address_id', '=', 'user_address.id')
                    ->where('user.id',$data['user_id'])
                    ->first();
            
            if (!$user_address || $data['is_default']==UserAddress::IS_DEFAULT)
            {
                $this->setDefault(['id'=>$res,'user_id'=>$data['user_id']]);
            }
            
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
        if($res)
        {
            if ($data['is_default']==UserAddress::IS_DEFAULT)
            {
                $this->setDefault(['id'=>$where['id'],'user_id'=>$where['user_id']]);
            }
            
            return ReturnData::create(ReturnData::SUCCESS,$res);
        }
        
        return ReturnData::create(ReturnData::FAIL);
    }
    
    //删除
    public function del($where)
    {
        if(empty($where)){return ReturnData::create(ReturnData::PARAMS_ERROR);}
        
        $validator = $this->getValidate($where,'del');
        if ($validator->fails()){return ReturnData::create(ReturnData::PARAMS_ERROR, null, $validator->errors()->first());}
        
        $res = $this->getModel()->del($where);
        
        if($res)
        {
            if ($address = $this->getModel()->getOne(['user_id'=>$where['user_id']]))
            {
                if(model('User')->getDb()->where(['id'=>$where['user_id'],'address_id'=>$where['id']])->update(['address_id'=>$address->id]))
                {
                    $this->getModel()->edit(array('is_default' => UserAddress::IS_DEFAULT),['id'=>$address->id]);
                }
            }
            
            return ReturnData::create(ReturnData::SUCCESS,$res);
        }
        
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
    
    /**
     * 设为默认地址
     * @param int $where['id'] user_address表id
     * @param int $where['user_id'] 用户id
     * @return array
     */
    public function setDefault($where)
    {
        if ($this->getModel()->edit(['is_default'=>UserAddress::IS_DEFAULT],$where))
        {
            $this->getModel()->getDb()->where('user_id', $where['user_id'])->where('id', '<>', $where['id'])->update(['is_default'=>0]);
            model('User')->edit(['address_id'=>$where['id']],['id'=>$where['user_id']]);
                
            return true;
        }
        
        return false;
    }
    
    // 获取默认地址
    public function userDefaultAddress($where)
    {
        $arr = [];
        $arr = $this->getModel()->getOne(array('user_id'=>$where['user_id'],'is_default'=>UserAddress::IS_DEFAULT));
        
        if (!$arr)
        {
            $arr = $this->getModel()->getOne(array('user_id'=>$where['user_id']));
        }
        
        if($arr)
        {
            $arr = $this->getProvinceCityDistrictText($arr);
        }
        
        return $arr;
    }
    
    // 获取省市区名称
    public function getProvinceCityDistrictText($data)
    {
        $data->country_name  = isset($data->country) ? model('Region')->getRegionName(['id'=>$data->country]) : '';
        $data->province_name = isset($data->province) ? model('Region')->getRegionName(['id'=>$data->province]) : '';
        $data->city_name     = isset($data->city) ? model('Region')->getRegionName(['id'=>$data->city]) : '';
        $data->district_name = isset($data->district) ? model('Region')->getRegionName(['id'=>$data->district]) : '';
        
        return $data;
    }
}