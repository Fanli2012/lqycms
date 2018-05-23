<?php
namespace App\Http\Requests;

class BonusRequest extends BaseRequest
{
    //总的验证规则
    protected $rules = [
        'id' => 'required|integer',
        'name' => 'required|max:60',
        'money' => ['required','regex:/^\d{0,10}(\.\d{0,2})?$/'],
        'min_amount' => ['required','regex:/^\d{0,10}(\.\d{0,2})?$/'],
        'start_time' => 'required|date_format:"Y-m-d H:i:s"',
        'end_time' => 'required|date_format:"Y-m-d H:i:s"|after:start_time',
        'point' => 'integer|between:1,9999',
        'status' => 'integer|between:0,1',
        'add_time' => 'required|integer',
        'num' => 'integer|between:-1,999999',
    ];
    
    //总的自定义错误信息
    protected $messages = [
        'id.required' => 'ID必填',
        'id.integer' => 'ID必须为数字',
        'name.required' => '名称必填',
        'name.max' => '名称不能大于60个字',
        'money.required' => '金额必填',
        'money.regex' => '金额只能带2位小数的数字',
        'min_amount.required' => '满多少使用必填',
        'min_amount.regex' => '满多少使用只能带2位小数的数字',
        'start_time.required' => '开始时间必填',
        'start_time.date_format' => '开始时间格式不正确，格式：1990-01-01 00:00:00',
        'end_time.required' => '结束时间必填',
        'end_time.date_format' => '结束时间格式不正确，格式：1990-01-01 00:00:00',
        'end_time.after' => '结束时间必须大于开始时间',
        'point.integer' => '兑换优惠券所需积分必须是数字',
        'point.between' => '兑换优惠券所需积分只能1-9999',
        'status.integer' => '兑换优惠券所需积分必须是数字',
        'status.between' => '状态：0可用，1不可用',
        'add_time.required' => '添加时间必填',
        'add_time.integer' => '添加时间必须是数字',
        'num.integer' => '优惠券数量必须是数字',
        'num.between' => '优惠券数量只能-1-999999',
    ];
    
    //场景验证规则
    protected $scene = [
        'add'  => ['name', 'money', 'min_amount', 'start_time', 'end_time', 'point', 'status', 'add_time', 'num'],
        'edit' => ['name', 'money', 'min_amount', 'start_time', 'end_time', 'point', 'status', 'add_time', 'num'],
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