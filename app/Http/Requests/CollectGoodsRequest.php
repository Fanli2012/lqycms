<?php
namespace App\Http\Requests;

class CollectGoodsRequest extends BaseRequest
{
    //总的验证规则
    protected $rules = [
        'id' => 'required|integer',
        'user_id' => 'required|integer',
        'goods_id' => 'required|integer',
        'add_time' => 'required|integer',
        'is_attention' => 'integer|between:[0,1]',
    ];
    
    //总的自定义错误信息
    protected $messages = [
        'id.required' => 'ID必填',
        'id.integer' => 'ID必须为数字',
        'user_id.required' => '用户ID必填',
        'user_id.integer' => '用户ID必须为数字',
        'goods_id.required' => '商品ID必填',
        'goods_id.integer' => '商品ID必须为数字',
        'add_time.required' => '收藏时间必填',
        'add_time.integer' => '收藏时间必须是数字',
        'is_attention.integer' => '是否关注该收藏商品必须为数字',
        'is_attention.between' => '是否关注该收藏商品，1是0否',
    ];
    
    //场景验证规则
    protected $scene = [
        'add'  => ['user_id', 'goods_id', 'add_time', 'is_attention'],
        'edit' => ['user_id', 'goods_id', 'add_time', 'is_attention']
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