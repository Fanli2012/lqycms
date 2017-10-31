<?php
namespace App\Http\Model;
use App\Common\ReturnData;

class UserAddress extends BaseModel
{
	//用户收货地址
	
	protected $table = 'user_address';
	public $timestamps = false;
	
    protected $hidden = array();
    
	/**
     * 不能被批量赋值的属性
     *
     * @var array
     */
    protected $guarded = array();
    
    //获取列表
	public static function getList(array $param)
    {
        extract($param); //参数：limit，offset
        
        $limit  = isset($limit) ? $limit : 10;
        $offset = isset($offset) ? $offset : 0;
        
        $model = self::where(array('user_id'=>$user_id));
        
        $res['count'] = $model->count();
        $res['list'] = array();
        
		if($res['count']>0)
        {
            $res['list'] = $model->skip($offset)->take($limit)->get();
            
            if($res['list'])
            {
                foreach($res['list'] as $k=>$v)
                {
                    $res['list'][$k]['country_name']  = Region::getRegionName($v['country']);
                    $res['list'][$k]['province_name'] = Region::getRegionName($v['province']);
                    $res['list'][$k]['city_name']     = Region::getRegionName($v['city']);
                    $res['list'][$k]['district_name'] = Region::getRegionName($v['district']);
                }
            }
        }
        else
        {
            return false;
        }
        
        return $res;
    }
    
    //获取一条记录，不传address_id表示获取默认地址
    public static function getOne($user_id,$address_id='')
    {
        $arr = '';
        
        if ($address_id)
        {
            $arr = self::where('id',$address_id)->first();
            
            if($arr)
            {
                $arr->country_name  = Region::getRegionName($arr->country);
                $arr->province_name = Region::getRegionName($arr->province);
                $arr->city_name     = Region::getRegionName($arr->city);
                $arr->district_name = Region::getRegionName($arr->district);
            }
            
            return $arr;
        }
        
        if ($user_id > 0)
        {
            // 取默认地址
            $arr = self::join('user','user_address.id', '=', 'user.address_id')
                    ->where('user.id',$user_id)->select('user_address.id','user_address.name','country','province','city','district','address','user_address.mobile','zipcode')
                    ->first();
                    
            if($arr)
            {
                $arr->country_name  = Region::getRegionName($arr->country);
                $arr->province_name = Region::getRegionName($arr->province);
                $arr->city_name     = Region::getRegionName($arr->city);
                $arr->district_name = Region::getRegionName($arr->district);
            }
        }
        
        return $arr;
    }
    
    public static function add(array $param)
    {
        extract($param);
        
        if(UserAddress::where('user_id', $user_id)->count() >= 3)
        {
            return ReturnData::create(ReturnData::PARAMS_ERROR,null,'最多10个收货地址');
        }
        
        $model = new UserAddress;
        $model->user_id    = $user_id;
        $model->name       = $name;
        $model->address    = $address;
        $model->mobile     = $mobile;
        $model->is_default = isset($is_default) ? $is_default : 0;
        
        if(isset($country)){$model->country   = isset($country) ? $country : 0;}
        if(isset($province)){$model->province = isset($province) ? $province : 0;}
        if(isset($city)){$model->city         = isset($city) ? $city : 0;}
        if(isset($district)){$model->district = isset($district) ? $district : 0;}
        if(isset($telphone)){$model->telphone = isset($telphone) ? $telphone : '';}
        if(isset($zipcode)){$model->zipcode   = isset($zipcode) ? $zipcode : '';}
        
        if ($model->save())
        {
            $user = User::where('id', $user_id)->first();

            if (!UserAddress::where('id', $user->address_id)->first() || $model->is_default!=0)
            {
                self::setDefault($model->id,$user_id);
            }
            
            return ReturnData::create(ReturnData::SUCCESS,$model);
        }

        return ReturnData::create(ReturnData::SYSTEM_FAIL);
    }
    
    public static function modify(array $param)
    {
        extract($param);
        
        if ($model = UserAddress::where('id', $id)->where('user_id', $user_id)->first())
        {
            $model->user_id         = $user_id;
            $model->is_default = isset($is_default) ? $is_default : 0;
            
            if(isset($name)){$model->name = $name;}
            if(isset($country)){$model->country = $country;}
            if(isset($province)){$model->province = $province;}
            if(isset($city)){$model->city = $city;}
            if(isset($district)){$model->district = $district;}
            if(isset($address)){$model->address = $address;}
            if(isset($mobile)){$model->mobile = $mobile;}
            if(isset($telphone)){$model->telphone = $telphone;}
            if(isset($zipcode)){$model->zipcode = $zipcode;}
            
            if ($model->save())
            {
                if ($model->is_default!=0)
                {
                    self::setDefault($model->id,$user_id);
                }
                
                return $model->toArray();
            }
        }
        
        return false;
    }
    
    //删除一条记录
    public static function remove($id,$user_id)
    {
        if (UserAddress::where('id', $id)->where('user_id', $user_id)->delete())
        {
            if ($address = UserAddress::where('user_id', $user_id)->first())
            {
                $user = User::where('id', $user_id)->first();
                
                if($user->address_id == $id)
                {
                    $user->address_id = $address->id;
                    $user->save();
                    
                    self::where('id',$address->id)->update(array('is_default' => 1));
                }
            }
        }
        
        return true;
    }
    
    //设为默认地址
    public static function setDefault($address_id,$user_id)
    {
        if ($user_address = UserAddress::where('id', $address_id)->where('user_id', $user_id)->first())
        {
            $user_address->is_default = 1;
            $user_address->save();
            
            UserAddress::where('user_id', $user_id)->where('id', '<>', $address_id)->update(['is_default'=>0]);
            
            if($user = User::where('id', $user_id)->first())
            {
                $user->address_id = $address_id;
                $user->save();
                
                return true;
            }
        }

        return false;
    }
}