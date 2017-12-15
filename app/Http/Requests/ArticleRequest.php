<?php
namespace App\Http\Requests;

use Illuminate\Http\Request;

class ArticleRequest extends Request
{
    //总的验证规则
    protected $rules = [
        'id' => 'required|integer',
        'title' => 'required|max:150',
        'typeid' => 'required|integer',
        'click' => 'required|integer',
    ];
    
    //总的自定义错误信息
    protected $messages = [
        'title.max' => '标题不能大于150个字',
        'title.required' => '必须填写标题',
        'typeid.required' => '类目ID必填',
        'typeid.integer' => '栏目ID必须为数字',
        'click.integer' => '点击必须为数字',
        'id.required' => 'ID必填',
        'id.integer' => 'ID必须为数字',
    ];
    
    //场景验证规则
    protected $scene = [
        'add' => ['title','typeid','click'],
        'edit' => ['title','typeid'],
        'del' => ['id'],
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