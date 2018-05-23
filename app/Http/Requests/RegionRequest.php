<?php
namespace App\Http\Requests;

class RegionRequest extends BaseRequest
{
    //总的验证规则
    protected $rules = [
        'id' => 'required|integer',
        'name' => 'required|max:64',
        'parent_id' => 'integer',
        'type' => 'integer|between:0,3',
        'sort_name' => 'max:50',
        'is_oversea' => 'integer|between:0,1',
        'area_code' => 'max:10',
        'status' => 'integer|between:0,1',
    ];
    
    //总的自定义错误信息
    protected $messages = [
        'id.required' => 'ID必填',
        'id.integer' => 'ID必须为数字',
        'name.required' => '名称必填',
        'name.max' => '名称不能超过60个字符',
        'parent_id.integer' => '父级id必须为数字',
        'type.integer' => '层级必须是数字',
        'type.between' => '层级，0国家，1省，2市，3区',
        'sort_name.max' => '拼音或英文简写不能超过50个字符',
        'is_oversea.integer' => '类型必须是数字',
        'is_oversea.between' => '0国内地址，1国外地址',
        'area_code.max' => '电话区号不能超过10个字符',
        'status.integer' => '状态必须是数字',
        'status.between' => '状态 0隐藏 1显示',
    ];
    
    //场景验证规则
    protected $scene = [
        'add'  => ['name', 'parent_id', 'type', 'sort_name', 'is_oversea', 'area_code', 'status'],
        'edit' => ['name', 'parent_id', 'type', 'sort_name', 'is_oversea', 'area_code', 'status'],
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