<?php
namespace App\Http\Requests;

class KuaidiRequest extends BaseRequest
{
    //总的验证规则
    protected $rules = [
        'id' => 'required|integer',
        'name' => 'required|max:30',
        'code' => 'required|max:20',
        'money' => ['regex:/^\d{0,10}(\.\d{0,2})?$/'],
        'country' => 'max:20',
        'des' => 'max:150',
        'tel' => 'max:60',
        'website' => 'max:60',
        'status' => 'integer|between:0,1',
        'listorder' => 'integer',
    ];
    
    //总的自定义错误信息
    protected $messages = [
        'id.required' => 'ID必填',
        'id.integer' => 'ID必须为数字',
        'name.required' => '快递公司名称必填',
        'name.max' => '快递公司名称不能超过30个字符',
        'code.required' => '快递公司编码必填',
        'code.max' => '快递公司编码不能超过20个字符',
        'money.regex' => '快递费只能带2位小数的数字',
        'status.integer' => '状态必须是数字',
        'status.between' => '状态 0显示',
        'country.max' => '国家编码不能超过20个字符',
        'des.max' => '说明不能超过150个字符',
        'tel.max' => '电话不能超过60个字符',
        'website.max' => '官网不能超过60个字符',
        'listorder.integer' => '排序必须是数字',
        'listorder.between' => '排序只能1-9999',
    ];
    
    //场景验证规则
    protected $scene = [
        'add'  => ['name', 'code', 'money', 'country', 'des', 'tel', 'website', 'status', 'listorder'],
        'edit' => ['name', 'code', 'money', 'country', 'des', 'tel', 'website', 'status', 'listorder'],
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