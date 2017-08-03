<?php
namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
use App\Common\Token;

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
        
        $model = self::where('user_id', Token::$uid);
        
        $res['count'] = $model->count();
        $res['list'] = array();
        
		if($res['count']>0)
        {
            $res['list']  = $model->skip($offset)->take($limit)->get()->toArray();
        }
        else
        {
            return false;
        }
        
        return $res;
    }
    
    //获取一条记录
    public static function getOne($address_id)
    {
        $arr = array();
        
        if ($address_id)
        {
            return self::where('id',$address_id)->first()->toArray();
        }
        
        if (Token::$uid > 0)
        {
            // 取默认地址
            $arr = self::join('user','user_address.id', '=', 'user.address_id')
                    ->where('user.user_id',Token::$uid)
                    ->first()->toArray();
        }
        
        return $arr;
    }
    
    public static function add(array $param)
    {
        extract($param);
        
        $model = new UserAddress;
        $model->user_id         = Token::$uid;
        $model->name            = $name;
        $model->email           = isset($email) ? $email : '';
        $model->country         = isset($country) ? $country : 0;
        $model->province        = isset($province) ? $province : 0;
        $model->city            = isset($city) ? $city : 0;
        $model->district        = isset($district) ? $district : 0;
        $model->address         = $address;
        $model->mobile          = isset($mobile) ? $mobile : '';
        $model->telphone        = isset($telphone) ? $telphone : '';
        $model->zipcode         = isset($zipcode) ? $zipcode : '';
        $model->sign_building   = isset($sign_building) ? $sign_building : '';
        $model->best_time       = isset($best_time) ? $best_time : '';
        $model->is_default      = isset($is_default) ? $is_default : 0;
        
        if ($model->save())
        {
            $user = User::where('user_id', Token::$uid)->first();

            if (!UserAddress::where('id', $user->address_id)->first())
            {
                $user->address_id = $model->id;
                $user->save();
            }
            
            return $model->toArray();
        }

        return false;
    }
    
    public static function modify(array $param)
    {
        extract($param);
        
        if ($model = UserAddress::where('id', $id)->where('user_id', Token::$uid)->first())
        {
            $model->user_id         = Token::$uid;
            $model->name            = $name;
            $model->email           = isset($email) ? $email : '';
            $model->country         = isset($country) ? $country : 0;
            $model->province        = isset($province) ? $province : 0;
            $model->city            = isset($city) ? $city : 0;
            $model->district        = isset($district) ? $district : 0;
            $model->address         = $address;
            $model->mobile          = isset($mobile) ? $mobile : '';
            $model->telphone        = isset($telphone) ? $telphone : '';
            $model->zipcode         = isset($zipcode) ? $zipcode : '';
            $model->sign_building   = isset($sign_building) ? $sign_building : '';
            $model->best_time       = isset($best_time) ? $best_time : '';
            $model->is_default      = isset($is_default) ? $is_default : 0;
            
            if ($model->save())
            {
                return $model->toArray();
            }
        }
        
        return false;
    }
    
    //删除一条记录
    public static function remove($id)
    {
        if (UserAddress::where('id', $id)->where('user_id', Token::$uid)->delete())
        {
            if ($address = UserAddress::where('user_id', Token::$uid)->first())
            {
                $user = User::where('id', Token::$uid)->first();
                
                if($user->address_id == $id)
                {
                    $user->address_id = $address->id;
                    $user->save();
                }
            }
        }
        
        return true;
    }
    
    //设为默认地址
    public static function setDefault($id)
    {
        if (UserAddress::where('id', $id)->where('user_id', Token::$uid)->first())
        {
            if($user = User::where('id', Token::$uid)->first())
            {
                $user->address_id = $id;
                $user->save();
                
                return true;
            }
        }

        return false;
    }
}