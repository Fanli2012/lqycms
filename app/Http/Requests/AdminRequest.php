<?php
namespace App\Http\Requests;

class AdminRequest extends BaseRequest
{
    //总的验证规则
    protected $rules = [
        'id' => 'required|integer',
        'name' => 'required|max:30',
        'email' => 'required|max:30',
        'login_time' => 'integer',
        'pwd' => 'required|max:32',
        'role_id' => 'required|integer',
        'status' => 'integer|between:0,3',
        'mobile' => 'max:20',
        'avatar' => 'max:150',
        'add_time' => 'required|integer',
    ];
    
    //总的自定义错误信息
    protected $messages = [
        'id.required' => 'ID必填',
        'id.integer' => 'ID必须为数字',
        'name.required' => '用户名必填',
        'name.max' => '用户名不能超过30个字符',
        'email.required' => '邮箱必填',
        'email.max' => '邮箱不能超过30个字符',
        'login_time.integer' => '登录时间必须是数字',
        'pwd.required' => '密码必填',
        'pwd.max' => '密码不能超过32个字符',
        'role_id.required' => '角色ID必填',
        'role_id.integer' => '角色ID必须为数字',
        'status.integer' => '用户状态必须是数字',
        'status.between' => '用户状态 0：正常； 1：禁用 ；2：未验证',
        'mobile.max' => '手机号不能超过20个字符',
        'avatar.max' => '头像不能超过150个字符',
        'add_time.required' => '添加时间必填',
        'add_time.integer' => '添加时间必须是数字',
    ];
    
    //场景验证规则
    protected $scene = [
        'add'  => ['name', 'email', 'login_time', 'pwd', 'role_id', 'status', 'mobile', 'avatar'],
        'edit' => ['name', 'email', 'login_time', 'pwd', 'role_id', 'status', 'mobile', 'avatar'],
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