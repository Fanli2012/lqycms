<?php
namespace App\Http\Requests;

class UserWithdrawRequest extends BaseRequest
{
    //总的验证规则
    protected $rules = [
        'id' => 'required|integer',
        'user_id' => 'required|integer',
        'add_time' => 'required|integer',
        'money' => ['required','regex:/^\d{0,10}(\.\d{0,2})?$/'],
        'name' => 'max:30',
        'status' => 'integer|between:0,5',
        'note' => 'max:250',
        're_note' => 'max:250',
        'bank_name' => 'max:30',
        'bank_place' => 'max:150',
        'account' => 'required|max:30',
        'method' => 'required|max:20',
        'delete_time' => 'integer',
    ];
    
    //总的自定义错误信息
    protected $messages = [
        'id.required' => 'ID必填',
        'id.integer' => 'ID必须为数字',
        'user_id.required' => '用户ID必填',
        'user_id.integer' => '用户ID必须为数字',
        'add_time.required' => '添加时间必填',
        'add_time.integer' => '添加时间格式不正确',
        'money.required' => '提现金额必填',
        'money.regex' => '提现金额格式不正确，只能带2位小数的数字',
        'name.max' => '姓名不能超过30个字符',
        'status.integer' => '状态必须是数字',
        'status.between' => '状态 0未处理,1处理中,2成功,3取消，4拒绝',
        'note.max' => '用户备注不能超过250个字符',
        're_note.max' => '回复信息不能超过250个字符',
        'bank_name.max' => '银行名称不能超过30个字符',
        'bank_place.max' => '开户行不能超过150个字符',
        'account.required' => '提现账号必填',
        'account.max' => '支付宝账号或者银行卡号不能超过30个字符',
        'method.required' => '提现方式必填',
        'method.max' => '提现方式不能超过20个字符',
        'delete_time.integer' => '删除时间格式不正确',
    ];
    
    //场景验证规则
    protected $scene = [
        'add'  => ['user_id', 'money', 'name', 'note', 'bank_name', 'bank_place', 'account', 'method'],
        'edit' => ['user_id', 'money', 'name', 'note', 'bank_name', 'bank_place', 'account', 'method'],
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