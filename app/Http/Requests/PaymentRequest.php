<?php
namespace App\Http\Requests;

class PaymentRequest extends BaseRequest
{
    //总的验证规则
    protected $rules = [
        'id' => 'required|integer',
        'pay_code' => 'required|max:20',
        'pay_name' => 'required|max:100',
        'pay_fee' => ['required','regex:/^\d{0,10}(\.\d{0,1})?$/'],
        'status' => 'integer|between:[0,1]',
        'listorder' => 'integer|between:[1,9999]',
    ];
    
    //总的自定义错误信息
    protected $messages = [
        'id.required' => 'ID必填',
        'id.integer' => 'ID必须为数字',
        'pay_code.required' => '支付方式的英文缩写必填',
        'pay_code.max' => '支付方式的英文缩写不能超过20个字符',
        'pay_name.required' => '支付方式名称必填',
        'pay_name.max' => '支付方式名称不能超过100个字符',
        'pay_fee.required' => '支付费用必填',
        'pay_fee.regex' => '支付费用只能带2位小数的数字',
        'status.integer' => '状态必须是数字',
        'status.between' => '是否可用;0否;1是',
        'listorder.integer' => '排序必须是数字',
        'listorder.between' => '排序只能1-9999',
    ];
    
    //场景验证规则
    protected $scene = [
        'add'  => ['pay_code', 'pay_name', 'pay_fee', 'status', 'listorder'],
        'edit' => ['pay_code', 'pay_name', 'pay_fee', 'status', 'listorder'],
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