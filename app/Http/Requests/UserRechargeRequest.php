<?php
namespace App\Http\Requests;

class UserRechargeRequest extends BaseRequest
{
    //总的验证规则
    protected $rules = [
        'id' => 'required|integer',
        'user_id' => 'required|integer',
        'money' => ['required','regex:/^\d{0,10}(\.\d{0,2})?$/'],
        'pay_time' => 'required|integer',
        'pay_type' => 'integer|between:0,3',
        'pay_money' => ['regex:/^\d{0,10}(\.\d{0,2})?$/'],
        'trade_no' => 'max:30',
        'status' => 'integer|between:0,3',
        'created_at' => 'required|integer',
        'updated_at' => 'integer',
        'recharge_sn' => 'required|max:60',
    ];
    
    //总的自定义错误信息
    protected $messages = [
        'id.required' => 'ID必填',
        'id.integer' => 'ID必须为数字',
        'user_id.required' => '用户ID必填',
        'user_id.integer' => '用户ID必须为数字',
        'money.required' => '充值金额必填',
        'money.regex' => '充值金额格式不正确，只能带2位小数的数字',
        'pay_time.required' => '充值时间必填',
        'pay_time.integer' => '充值时间格式不正确',
        'pay_type.integer' => '充值类型必须为数字',
        'pay_type.between' => '充值类型：1微信，2支付宝',
        'pay_money.regex' => '实付金额格式不正确，只能带2位小数的数字',
        'trade_no.max' => '支付流水号不能超过30个字符',
        'status.integer' => '充值状态必须为数字',
        'status.between' => '充值状态：0未处理，1已完成，2失败',
        'created_at.required' => '添加时间必填',
        'created_at.integer' => '添加时间格式不正确',
        'updated_at.integer' => '更新时间格式不正确',
        'recharge_sn.required' => '支付订单号必填',
        'recharge_sn.max' => '支付订单号不能超过60个字符',
    ];
    
    //场景验证规则
    protected $scene = [
        'add'  => ['user_id', 'money', 'recharge_sn', 'des'],
        'edit' => ['user_id', 'money', 'recharge_sn', 'des'],
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