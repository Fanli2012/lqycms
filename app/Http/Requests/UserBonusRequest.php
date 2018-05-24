<?php
namespace App\Http\Requests;

class UserBonusRequest extends BaseRequest
{
    //总的验证规则
    protected $rules = [
        'id' => 'required|integer',
        'bonus_id' => 'required|integer',
        'user_id' => 'required|integer',
        'used_time' => 'integer',
        'get_time' => 'required|integer',
        'status' => 'integer|between:0,2',
    ];
    
    //总的自定义错误信息
    protected $messages = [
        'id.required' => 'ID必填',
        'id.integer' => 'ID必须为数字',
        'bonus_id.required' => '红包ID必填',
        'bonus_id.integer' => '红包ID必须为数字',
        'user_id.required' => '用户ID必填',
        'user_id.integer' => '用户ID必须为数字',
        'used_time.integer' => '优惠券使用时间格式不正确',
        'get_time.required' => '优惠券获得时间必填',
        'get_time.integer' => '优惠券获得时间格式不正确',
        'status.integer' => '优惠券状态必须是数字',
        'status.between' => '优惠券状态，0未使用1已使用2已过期',
    ];
    
    //场景验证规则
    protected $scene = [
        'add'  => ['bonus_id', 'user_id'],
        'edit' => ['bonus_id', 'user_id'],
        'del'  => ['id'],
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