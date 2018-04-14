<?php
namespace App\Http\Requests;

class GoodsImgRequest extends BaseRequest
{
    //总的验证规则
    protected $rules = [
        'id' => 'required|integer',
        'url' => 'required|max:150',
        'goods_id' => 'required|integer',
        'add_time' => 'required|integer',
        'des' => 'max:150',
        'listorder' => 'integer|between:[1,9999]',
    ];
    
    //总的自定义错误信息
    protected $messages = [
        'id.required' => 'ID必填',
        'id.integer' => 'ID必须为数字',
        'url.required' => '图片地址必填',
        'url.max' => '图片地址不能超过150个字',
        'goods_id.required' => '商品id必填',
        'goods_id.integer' => '商品id必须为数字',
        'add_time.required' => '添加时间必填',
        'add_time.integer' => '添加时间必须是数字',
        'des.max' => '图片说明信息不能超过150个字',
        'listorder.integer' => '排序必须是数字',
        'listorder.between' => '排序只能1-9999',
    ];
    
    //场景验证规则
    protected $scene = [
        'add'  => ['url', 'goods_id', 'add_time', 'des', 'listorder'],
        'edit' => ['url', 'goods_id', 'add_time', 'des', 'listorder'],
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