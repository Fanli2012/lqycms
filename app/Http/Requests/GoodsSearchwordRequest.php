<?php
namespace App\Http\Requests;

class GoodsSearchwordRequest extends BaseRequest
{
    //总的验证规则
    protected $rules = [
        'id' => 'required|integer',
        'name' => 'required|max:60',
        'status' => 'integer|between:[0,5]',
        'add_time' => 'required|integer',
        'listorder' => 'integer|between:[1,9999]',
        'click' => 'integer',
    ];
    
    //总的自定义错误信息
    protected $messages = [
        'id.required' => 'ID必填',
        'id.integer' => 'ID必须为数字',
        'name.required' => '标题必填',
        'name.max' => '标题不能超过60个字符',
        'status.integer' => '状态必须是数字',
        'status.between' => '状态 0显示',
        'add_time.required' => '添加时间必填',
        'add_time.integer' => '添加时间必须是数字',
        'listorder.integer' => '排序必须是数字',
        'listorder.between' => '排序只能1-9999',
        'click.integer' => '点击必须为数字',
    ];
    
    //场景验证规则
    protected $scene = [
        'add'  => ['name', 'status', 'add_time', 'listorder', 'click'],
        'edit' => ['name', 'status', 'add_time', 'listorder', 'click'],
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