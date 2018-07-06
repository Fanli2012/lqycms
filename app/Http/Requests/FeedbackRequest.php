<?php
namespace App\Http\Requests;

class FeedbackRequest extends BaseRequest
{
    //总的验证规则
    protected $rules = [
        'id' => 'required|integer',
        'content' => 'required',
        'add_time' => 'required|integer',
        'title' => 'max:150',
        'user_id' => 'required|integer',
        'mobile' => 'max:20',
        'type' => 'max:20',
    ];
    
    //总的自定义错误信息
    protected $messages = [
        'id.required' => 'ID必填',
        'id.integer' => 'ID必须为数字',
        'content.required' => '意见反馈内容必填',
        'add_time.required' => '添加时间必填',
        'add_time.integer' => '添加时间必须为数字',
        'title.max' => '标题不能超过150个字符',
        'user_id.required' => '发布者ID必填',
        'user_id.integer' => '发布者ID必须是数字',
        'mobile.max' => '手机号码不能超过20个字符',
        'type.max' => '意见反馈类型不能超过20个字符',
    ];
    
    //场景验证规则
    protected $scene = [
        'add'  => ['content', 'title', 'mobile', 'type'],
        'edit' => ['content', 'title', 'mobile', 'type'],
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