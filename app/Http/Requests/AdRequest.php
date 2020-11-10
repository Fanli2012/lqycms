<?php
namespace App\Http\Requests;

class AdRequest extends BaseRequest
{
    //总的验证规则
    protected $rules = [
		'id' => 'required|integer',
        'name' => 'required|max:60',
        'description' => 'max:255',
        'flag' => 'max:30',
        'is_expire' => 'between:0,3',
        'start_time' => 'integer',
        'end_time' => 'integer|min:start_time',
        'add_time' => 'required|integer',
    ];
    
    //总的自定义错误信息
    protected $messages = [
		'id.required' => 'ID不能为空',
        'id.integer' => 'ID必须是数字',
        'id.gt' => 'ID格式不正确',
        'name.required' => '名称不能为空',
        'name.max' => '名称不能超过60个字符',
        'description.max' => '描述不能超过255个字符',
        'flag.max' => '标识不能超过30个字符',
        'is_expire.between' => '0永不过期',
        'start_time.integer' => '投放开始时间格式不正确',
        'end_time.integer' => '投放结束时间格式不正确',
        'end_time.min' => '投放结束时间格式不正确',
        'add_time.required' => '添加时间不能为空',
        'add_time.integer' => '添加时间格式不正确',
        'add_time.gt' => '添加时间格式不正确',
    ];
    
    //场景验证规则
    protected $scene = [
        'add' => ['name', 'description', 'flag', 'is_expire', 'start_time', 'end_time', 'add_time'],
        'edit' => ['name', 'description', 'flag', 'is_expire', 'start_time', 'end_time', 'add_time'],
        'del' => ['id'],
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