<?php
namespace App\Http\Requests;

class TokenRequest extends BaseRequest
{
    //总的验证规则
    protected $rules = [
        'id' => 'required|integer',
        'token' => 'required|max:128',
        'type' => 'required|integer|between:0,6',
        'uid' => 'required|integer',
        'created_at' => 'required|date_format:"Y-m-d H:i:s"',
        'expired_at' => 'required|date_format:"Y-m-d H:i:s"',
    ];
    
    //总的自定义错误信息
    protected $messages = [
        'id.required' => 'ID必填',
        'id.integer' => 'ID必须为数字',
        'token.required' => 'token必填',
        'token.max' => 'token不能超过128个字符',
        'type.required' => 'token类型必填',
        'type.integer' => 'token类型必须是数字',
        'type.between' => '0:app, 1:admin, 2:weixin, 3:wap, 4: pc',
        'uid.required' => 'UID必填',
        'uid.integer' => 'UID必须为数字',
        'created_at.required' => '添加时间必填',
        'created_at.regex' => '添加时间格式不正确，Y-m-d H:i:s',
        'expired_at.required' => '过期时间必填',
        'expired_at.regex' => '过期时间格式不正确，Y-m-d H:i:s',
    ];
    
    //场景验证规则
    protected $scene = [
        'add'  => ['token', 'type', 'uid', 'created_at', 'expired_at'],
        'edit' => ['token', 'type', 'uid', 'created_at', 'expired_at'],
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