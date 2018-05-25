<?php
namespace App\Http\Requests;
  
class UserAddressRequest extends BaseRequest
{
    //总的验证规则
    protected $rules = [
        'id' => 'required|integer',
        'user_id' => 'required|integer',
        'name' => 'required|max:60',
        'country' => 'required|integer',
        'province' => 'required|integer',
        'city' => 'required|integer',
        'district' => 'required|integer',
        'address' => 'required|max:120',
        'zipcode' => 'integer',
        'telphone' => 'max:60',
        'mobile' => 'required|max:60',
        'is_default' => 'required|integer|between:0,1',
    ];
    
    //总的自定义错误信息
    protected $messages = [
        'id.required' => 'ID必填',
        'id.integer' => 'ID必须为数字',
        'user_id.required' => '用户ID必填',
        'user_id.integer' => '用户ID必须为数字',
        'name.required' => '收货人名字必填',
        'name.max' => '收货人名字不能超过60个字符',
        'country.required' => '国家ID必填',
        'country.integer' => '国家ID必须为数字',
        'province.required' => '省份ID必填',
        'province.integer' => '省份ID必须为数字',
        'city.required' => '城市ID必填',
        'city.integer' => '城市ID必须为数字',
        'district.required' => '地区ID必填',
        'district.integer' => '地区ID必须为数字',
        'address.required' => '收货人的详细地址必填',
        'address.max' => '收货人的详细地址不能超过120个字符',
        'zipcode.integer' => '收货人邮编必须为数字',
        'telphone.max' => '固定电话不能超过60个字符',
        'mobile.required' => '收货人手机号必填',
        'mobile.max' => '收货人手机号不能超过20个字符',
        'is_default.required' => '是否默认必填',
        'is_default.integer' => '是否默认必须是数字',
        'is_default.between' => '是否默认,0:为非默认,1:默认',
    ];
    
    //场景验证规则
    protected $scene = [
        'add'  => ['user_id', 'name', 'province', 'city', 'district', 'address', 'zipcode', 'telphone', 'mobile', 'is_default'],
        'edit' => ['zipcode', 'telphone', 'is_default'],
        'del'  => ['user_id', 'id'],
    ];
    
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; //修改为true
    }
    
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return $this->rules;
    }
    
    /**
     * 获取被定义验证规则的错误消息.
     *
     * @return array
     */
    public function messages()
    {
        return $this->messages;
    }
    
    //获取场景验证规则
    public function getSceneRules($name, $fields = null)
    {
        $res = array();
        
        if(!isset($this->scene[$name]))
        {
            return false;
        }
        
        $scene = $this->scene[$name];
        if($fields != null && is_array($fields))
        {
            $scene = $fields;
        }
        
        foreach($scene as $k=>$v)
        {
            if(isset($this->rules[$v])){$res[$v] = $this->rules[$v];}
        }
        
        return $res;
    }
    
    //获取场景验证规则自定义错误信息
    public function getSceneRulesMessages()
    {
        return $this->messages;
    }
}