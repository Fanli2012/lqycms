<?php
namespace App\Http\Requests;

class SysconfigRequest extends BaseRequest
{
    //总的验证规则
    protected $rules = [
        'id' => 'required|integer',
        'varname' => 'required|max:100',
        'info' => 'required|max:100',
        'is_show' => 'integer|between:[0,5]',
    ];
    
    //总的自定义错误信息
    protected $messages = [
        'id.required' => 'ID必填',
        'id.integer' => 'ID必须为数字',
        'varname.required' => '变量名必填',
        'varname.max' => '变量名不能超过100个字符',
        'info.required' => '变量值必填',
        'info.max' => '变量值不能超过100个字符',
        'is_show.integer' => '状态必须是数字',
        'is_show.between' => '是否显示，默认0显示',
    ];
    
    //场景验证规则
    protected $scene = [
        'add'  => ['varname', 'info', 'is_show'],
        'edit' => ['varname', 'info', 'is_show'],
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