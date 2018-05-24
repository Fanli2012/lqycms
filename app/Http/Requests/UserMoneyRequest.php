<?php
namespace App\Http\Requests;

class UserMoneyRequest extends BaseRequest
{
    //总的验证规则
    protected $rules = [
        'id' => 'required|integer',
        'user_id' => 'required|integer',
        'type' => 'integer|between:0,9',
        'money' => ['required','regex:/^\d{0,10}(\.\d{0,2})?$/'],
        'add_time' => 'required|integer',
        'des' => 'required|max:100',
        'user_money' => ['required','regex:/^\d{0,10}(\.\d{0,2})?$/'],
    ];
    
    //总的自定义错误信息
    protected $messages = [
        'id.required' => 'ID必填',
        'id.integer' => 'ID必须为数字',
        'user_id.required' => '用户ID必填',
        'user_id.integer' => '用户ID必须为数字',
        'type.integer' => '类型必须为数字',
        'type.between' => '0增加,1减少',
        'money.required' => '金额必填',
        'money.regex' => '金额格式不正确，只能带2位小数的数字',
        'add_time.required' => '时间必填',
        'add_time.integer' => '时间格式不正确',
        'des.required' => '描述必填',
        'des.max' => '描述不能超过100个字符',
        'user_money.required' => '余额必填',
        'user_money.regex' => '余额格式不正确，只能带2位小数的数字',
    ];
    
    //场景验证规则
    protected $scene = [
        'add'  => ['user_id', 'type', 'money', 'des'],
        'edit' => ['user_id', 'type', 'money', 'des'],
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