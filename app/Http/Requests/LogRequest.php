<?php
namespace App\Http\Requests;

class LogRequest extends BaseRequest
{
    //总的验证规则
    protected $rules = [
        'id' => 'required|integer',
        'ip' => 'required|max:15|ip',
        'content' => 'max:250',
        'login_name' => 'max:30',
        'login_id' => 'integer',
        'url' => 'required|max:255',
        'domain_name' => 'max:60',
        'http_referer' => 'max:255',
        'http_method' => 'required|max:10',
        'add_time' => 'required|integer',
    ];

	//总的自定义错误信息
    protected $messages = [
        'id.required' => 'ID不能为空',
        'id.integer' => 'ID必须是数字',
        'ip.required' => 'IP不能为空',
        'ip.max' => 'IP不能超过15个字符',
        'ip.ip' => 'IP格式不正确',
        'content.max' => '操作内容不能超过255个字符',
        'login_name.required' => '登录名称不能为空',
        'login_name.max' => '登录名称不能超过30个字符',
        'login_id.required' => '登录ID不能为空',
        'login_id.integer' => '登录ID必须是数字',
        'url.required' => 'URL不能为空',
        'url.max' => 'URL不能超过255个字符',
        'domain_name.max' => '域名不能超过60个字符',
        'http_referer.max' => '上一个页面URL不能超过250个字符',
        'http_method.required' => '请求方式不能为空',
        'http_method.max' => '请求方式不能超过10个字符',
        'add_time.required' => '添加时间不能为空',
        'add_time.integer' => '添加时间格式不正确',
    ];

    //场景验证规则
    protected $scene = [
        'add' => ['ip', 'content', 'login_name', 'login_id', 'route', 'http_method', 'add_time'],
        'edit' => ['ip', 'content', 'login_name', 'login_id', 'route', 'http_method', 'add_time'],
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