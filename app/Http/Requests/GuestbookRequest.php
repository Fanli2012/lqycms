<?php
namespace App\Http\Requests;

class GuestbookRequest extends BaseRequest
{
    //总的验证规则
    protected $rules = [
        'id' => 'required|integer',
        'title' => 'required|max:150',
        'addtime' => 'required|integer',
        'msg' => 'required|max:250',
        'status' => 'integer|between:0,1',
        'name' => 'max:30',
        'phone' => 'max:20',
        'email' => 'max:60',
    ];
    
    //总的自定义错误信息
    protected $messages = [
        'id.required' => 'ID必填',
        'id.integer' => 'ID必须为数字',
        'title.required' => '标题必填',
        'title.max' => '标题不能超过150个字符',
        'addtime.required' => '添加时间必填',
        'addtime.integer' => '添加时间必须是数字',
        'msg.required' => '描述必填',
        'msg.max' => '描述不能超过250个字符',
        'status.integer' => '状态必须是数字',
        'status.between' => '是否阅读，默认0未阅读',
        'name.max' => '姓名不能超过30个字符',
        'phone.max' => '电话不能超过20个字符',
        'email.max' => '邮箱不能超过60个字符',
    ];
    
    //场景验证规则
    protected $scene = [
        'add'  => ['title', 'addtime', 'msg', 'status', 'name', 'phone', 'email'],
        'edit' => ['title', 'addtime', 'msg', 'status', 'name', 'phone', 'email'],
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