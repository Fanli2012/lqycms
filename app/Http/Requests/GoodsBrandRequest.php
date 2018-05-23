<?php
namespace App\Http\Requests;

class GoodsBrandRequest extends BaseRequest
{
    //总的验证规则
    protected $rules = [
        'id' => 'required|integer',
        'pid' => 'integer',
        'add_time' => 'required|integer',
        'title' => 'required|max:150',
        'seotitle' => 'max:150',
        'keywords' => 'max:60',
        'description' => 'max:240',
        'litpic' => 'max:100',
        'status' => 'integer|between:0,1',
        'listorder' => 'integer|between:1,9999',
        'cover_img' => 'max:100',
        'click' => 'integer',
    ];
    
    //总的自定义错误信息
    protected $messages = [
        'id.required' => 'ID必填',
        'id.integer' => 'ID必须为数字',
        'pid.integer' => '父级id必须为数字',
        'add_time.required' => '添加时间必填',
        'add_time.integer' => '添加时间必须是数字',
        'title.required' => '标题必填',
        'title.max' => '标题不能超过150个字符',
        'seotitle.max' => 'seo标题不能超过150个字符',
        'keywords.max' => '关键词不能超过60个字符',
        'description.max' => '描述不能超过240个字符',
        'litpic.max' => '缩略图不能超过100个字符',
        'status.integer' => '是否显示必须是数字',
        'status.between' => '是否显示，0显示',
        'listorder.integer' => '排序必须是数字',
        'listorder.between' => '排序只能1-9999',
        'cover_img.max' => '封面不能超过100个字符',
        'click.integer' => '点击必须为数字',
    ];
    
    //场景验证规则
    protected $scene = [
        'add'  => ['pid', 'add_time', 'title', 'seotitle', 'keywords', 'description', 'litpic', 'status', 'listorder', 'cover_img', 'click'],
        'edit' => ['pid', 'add_time', 'title', 'seotitle', 'keywords', 'description', 'litpic', 'status', 'listorder', 'cover_img', 'click'],
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