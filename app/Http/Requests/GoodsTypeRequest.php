<?php
namespace App\Http\Requests;

class GoodsTypeRequest extends BaseRequest
{
    //总的验证规则
    protected $rules = [
        'id' => 'required|integer',
        'pid' => 'integer',
        'addtime' => 'required|integer',
        'name' => 'required|max:30',
        'seotitle' => 'max:150',
        'keywords' => 'max:60',
        'description' => 'max:250',
        'typedir' => 'required|max:30',
        'templist' => 'max:50',
        'temparticle' => 'max:50',
        'litpic' => 'max:100',
        'seokeyword' => 'max:50',
        'status' => 'integer|between:[0,1]',
        'listorder' => 'integer',
        'cover_img' => 'max:100',
    ];
    
    //总的自定义错误信息
    protected $messages = [
        'id.required' => 'ID必填',
        'id.integer' => 'ID必须为数字',
        'pid.integer' => '父级id必须是数字',
        'addtime.required' => '添加时间必填',
        'addtime.integer' => '添加时间必须是数字',
        'name.required' => '栏目名称必填',
        'name.max' => '栏目名称不能超过30个字符',
        'seotitle.max' => 'seo标题不能超过150个字符',
        'keywords.max' => '关键词不能超过60个字符',
        'description.max' => '描述不能超过250个字符',
        'typedir.required' => '栏目别名必填',
        'typedir.max' => '栏目别名不能超过30个字符',
        'templist.max' => '列表页模板不能超过50个字符',
        'temparticle.max' => '文章页模板不能超过50个字符',
        'litpic.max' => '缩略图不能超过100个字符',
        'seokeyword.max' => 'seokeyword不能超过50个字符',
        'status.integer' => '状态必须是数字',
        'status.between' => '状态 1显示',
        'listorder.integer' => '排序必须是数字',
        'cover_img.max' => '封面不能超过100个字符',
    ];
    
    //场景验证规则
    protected $scene = [
        'add'  => ['pid', 'addtime', 'name', 'addtime', 'seotitle', 'keywords', 'description', 'typedir', 'templist', 'temparticle', 'litpic', 'seokeyword', 'status', 'listorder', 'cover_img'],
        'edit' => ['pid', 'addtime', 'name', 'addtime', 'seotitle', 'keywords', 'description', 'typedir', 'templist', 'temparticle', 'litpic', 'seokeyword', 'status', 'listorder', 'cover_img'],
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