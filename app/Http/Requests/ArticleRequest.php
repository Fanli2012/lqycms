<?php
namespace App\Http\Requests;

class ArticleRequest extends BaseRequest
{
    //总的验证规则
    protected $rules = [
        'id' => 'required|integer',
        'typeid' => 'required|integer',
        'tuijian' => 'integer',
        'click' => 'required|integer',
        'title' => 'required|max:150',
        'writer' => 'max:20',
        'source' => 'max:30',
        'litpic' => 'max:100',
        'pubdate' => 'integer',
        'add_time' => 'required|integer',
        'keywords' => 'max:60',
        'seotitle' => 'max:150',
        'description' => 'max:250',
        'ischeck' => 'between:0,2',
        'user_id' => 'integer',
    ];
    
    //总的自定义错误信息
    protected $messages = [
        'id.required' => 'ID必填',
        'id.integer' => 'ID必须为数字',
        'typeid.required' => '栏目ID必填',
        'typeid.integer' => '栏目ID必须为数字',
        'tuijian.integer' => '推荐等级必须是数字',
        'click.required' => '点击量必填',
        'click.integer' => '点击量必须为数字',
        'title.max' => '标题不能大于150个字符',
        'title.required' => '必须填写标题',
        'writer.max' => '作者不能超过20个字符',
        'source.max' => '来源不能超过30个字符',
        'litpic.max' => '缩略图不能超过100个字符',
        'pubdate.integer' => '更新时间格式不正确',
        'add_time.required' => '添加时间必填',
        'add_time.integer' => '添加时间必须是数字',
        'keywords.max' => '关键词不能超过60个字符',
        'seotitle.max' => 'seo标题不能超过150个字符',
        'description.max' => '描述不能超过250个字符',
        'ischeck.between' => '审核状态：0审核，1未审核',
        'user_id.integer' => '发布者ID必须是数字',
    ];
    
    //场景验证规则
    protected $scene = [
        'add' => ['typeid', 'title', 'tuijian', 'click', 'writer', 'source', 'litpic', 'pubdate', 'addtime', 'keywords', 'seotitle', 'description', 'ischeck', 'user_id'],
        'edit' => ['typeid', 'title', 'tuijian', 'click', 'writer', 'source', 'litpic', 'pubdate', 'addtime', 'keywords', 'seotitle', 'description', 'ischeck', 'user_id'],
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