<?php
namespace App\Http\Requests;

class FriendlinkRequest extends BaseRequest
{
    //总的验证规则
    protected $rules = [
        'id' => 'required|integer',
        'webname' => 'required|max:60',
        'url' => 'required|max:100',
        'group_id' => 'integer|between:[1,99]',
        'listorder' => 'integer|between:[1,9999]',
    ];
    
    //总的自定义错误信息
    protected $messages = [
        'id.required' => 'ID必填',
        'id.integer' => 'ID必须为数字',
        'webname.required' => '友情链接名称必填',
        'webname.max' => '友情链接名称不能大于60个字',
        'url.required' => 'url必填',
        'url.max' => 'url不能大于100个字',
        'group_id.integer' => '分组id必须是数字',
        'group_id.between' => '分组id只能1-99',
        'listorder.integer' => '排序必须是数字',
        'listorder.between' => '排序只能1-9999',
    ];
    
    //场景验证规则
    protected $scene = [
        'add'  => ['webname', 'url', 'group_id', 'listorder'],
        'edit' => ['webname', 'url', 'group_id', 'listorder'],
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