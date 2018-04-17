<?php
namespace App\Http\Requests;

class VerifyCodeRequest extends BaseRequest
{
    //总的验证规则
    protected $rules = [
        'id' => 'required|integer',
        'code' => 'required|max:10',
        'type' => 'required|integer|between:[0,6]',
        'mobile' => 'required|max:20',
        'status' => 'integer|between:[0,1]',
        'created_at' => 'required|date_format:"Y-m-d H:i:s"',
        'expired_at' => 'required|date_format:"Y-m-d H:i:s"',
    ];
    
    //总的自定义错误信息
    protected $messages = [
        'id.required' => 'ID必填',
        'id.integer' => 'ID必须为数字',
        'code.required' => '验证码必填',
        'code.max' => '验证码不能超过10个字符',
        'type.required' => '验证码类型必填',
        'type.integer' => '验证码类型必须是数字',
        'type.between' => '0通用，注册，1:手机绑定业务验证码，2:密码修改业务验证码',
        'mobile.required' => '手机号必填',
        'mobile.max' => '手机号不能超过20个字符',
        'status.integer' => '状态必须是数字',
        'status.between' => '0:未使用 1:已使用',
        'created_at.required' => '添加时间必填',
        'created_at.regex' => '添加时间格式不正确，Y-m-d H:i:s',
        'expired_at.required' => '过期时间必填',
        'expired_at.regex' => '过期时间格式不正确，Y-m-d H:i:s',
    ];
    
    //场景验证规则
    protected $scene = [
        'add'  => ['code', 'type', 'mobile', 'status', 'created_at', 'expired_at'],
        'edit' => ['code', 'type', 'mobile', 'status', 'created_at', 'expired_at'],
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