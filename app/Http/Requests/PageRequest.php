<?php
namespace App\Http\Requests;

class PageRequest extends BaseRequest
{
    //总的验证规则
    protected $rules = [
        'id' => 'required|integer',
        'title' => 'required|max:150',
        'seotitle' => 'max:150',
        'keywords' => 'max:100',
        'description' => 'max:250',
        'template' => 'max:30',
        'pubdate' => 'required|integer',
        'filename' => 'required|max:60',
        'litpic' => 'max:100',
        'click' => 'integer',
        'listorder' => 'integer|between:[1,9999]',
    ];
    
    //总的自定义错误信息
    protected $messages = [
        'id.required' => 'ID必填',
        'id.integer' => 'ID必须为数字',
        'title.required' => '标题必填',
        'title.max' => '标题不能超过150个字符',
        'seotitle.max' => 'seo标题不能超过150个字符',
        'keywords.max' => '关键词不能超过100个字符',
        'description.max' => '描述不能超过250个字符',
        'template.max' => '模板名不能超过30个字符',
        'pubdate.required' => '时间必填',
        'pubdate.integer' => '时间格式不正确',
        'filename.required' => '别名必填',
        'filename.max' => '别名不能超过60个字符',
        'litpic.max' => '缩略图不能超过100个字符',
        'click.integer' => '点击量必须为数字',
        'listorder.integer' => '排序必须是数字',
        'listorder.between' => '排序只能1-9999',
    ];
    
    //场景验证规则
    protected $scene = [
        'add'  => ['title', 'seotitle', 'keywords', 'description', 'template', 'pubdate', 'filename', 'litpic', 'click', 'listorder'],
        'edit' => ['title', 'seotitle', 'keywords', 'description', 'template', 'pubdate', 'filename', 'litpic', 'click', 'listorder'],
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