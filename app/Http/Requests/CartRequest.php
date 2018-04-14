<?php
namespace App\Http\Requests;

class CartRequest extends BaseRequest
{
    //总的验证规则
    protected $rules = [
        'id' => 'required|integer',
        'user_id' => 'required|integer',
        'goods_id' => 'required|integer',
        'shop_id' => 'integer',
        'goods_number' => 'required|integer|between:[1,9999]',
        'type' => 'integer|between:[0,3]',
        'add_time' => 'required|integer',
    ];
    
    //总的自定义错误信息
    protected $messages = [
        'id.required' => 'ID必填',
        'id.integer' => 'ID必须为数字',
        'user_id.required' => '用户ID必填',
        'user_id.integer' => '用户ID必须为数字',
        'goods_id.required' => '商品ID必填',
        'goods_id.integer' => '商品ID必须为数字',
        'shop_id.integer' => '商店ID必须为数字',
        'goods_number.required' => '商品数量必填',
        'goods_number.integer' => '商品数量必须为数字',
        'goods_number.between' => '商品数量只能1-9999',
        'type.integer' => '购物车商品类型必须为数字',
        'type.between' => '购物车商品类型只能0-3',
        'add_time.required' => '添加时间必填',
        'add_time.integer' => '添加时间必须是数字',
    ];
    
    //场景验证规则
    protected $scene = [
        'add'  => ['user_id', 'goods_id', 'shop_id', 'goods_number', 'type', 'add_time'],
        'edit' => ['user_id', 'goods_id', 'shop_id', 'goods_number', 'type', 'add_time'],
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