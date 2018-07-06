<?php
namespace App\Http\Requests;

class SlideRequest extends BaseRequest
{
    //总的验证规则
    protected $rules = [
        'id' => 'required|integer',
        'title' => 'required|max:150',
        'url' => 'max:100',
        'target' => 'integer|between:0,5',
        'group_id' => 'integer',
        'listorder' => 'integer',
        'pic' => 'required|max:100',
        'is_show' => 'integer|between:0,2',
        'type' => 'integer|between:0,5'
    ];
    
    //总的自定义错误信息
    protected $messages = [
        'id.required' => 'ID必填',
        'id.integer' => 'ID必须为数字',
        'title.required' => '标题必填',
        'title.max' => '标题不能超过150个字符',
        'url.max' => 'url不能超过100个字符',
        'target.integer' => 'target必须为数字',
        'target.between' => '跳转方式，0_blank，1_self，2_parent，3_top，4framename',
        'group_id.integer' => '分组ID必须是数字',
        'listorder.integer' => '排序必须是数字',
        'pic.required' => '图片',
        'pic.max' => '图片地址不能超过100个字符',
        'is_show.integer' => '是否显示必须为数字',
        'is_show.between' => '是否显示，默认0显示',
        'type.integer' => '类型必须为数字',
        'type.between' => '类型0pc，1weixin，2app，3wap',
    ];
    
    //场景验证规则
    protected $scene = [
        'add'  => ['title', 'url', 'target', 'group_id', 'listorder', 'pic', 'is_show', 'type'],
        'edit' => ['title', 'url', 'target', 'group_id', 'listorder', 'pic', 'is_show', 'type'],
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