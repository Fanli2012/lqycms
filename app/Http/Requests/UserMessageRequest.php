<?php
namespace App\Http\Requests;

class UserMessageRequest extends BaseRequest
{
    //总的验证规则
    protected $rules = [
        'id' => 'required|integer',
        'user_id' => 'required|integer',
        'type' => 'integer|between:0,9',
        'status' => 'integer|between:0,9',
        'title' => 'max:150',
        'des' => 'required|max:250',
        'litpic' => 'max:100',
        'add_time' => 'required|integer',
    ];
    
    //总的自定义错误信息
    protected $messages = [
        'id.required' => 'ID必填',
        'id.integer' => 'ID必须为数字',
        'user_id.required' => '用户ID必填',
        'user_id.integer' => '用户ID必须为数字',
        'type.integer' => '消息类型必须为数字',
        'type.between' => '系统消息0，活动消息1',
        'status.integer' => '查看状态必须为数字',
        'status.between' => '查看状态：0未查看，1已查看',
        'title.max' => '标题不能超过150个字符',
        'des.required' => '描述必填',
        'des.max' => '描述不能超过150个字符',
        'litpic.max' => '缩略图不能超过100个字符',
        'add_time.required' => '时间必填',
        'add_time.integer' => '时间格式不正确',
    ];
    
    //场景验证规则
    protected $scene = [
        'add'  => ['user_id', 'type', 'title', 'des', 'litpic'],
        'edit' => ['title', 'des'],
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