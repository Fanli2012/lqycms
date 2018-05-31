<?php
namespace App\Http\Requests;

class CommentRequest extends BaseRequest
{
    //总的验证规则
    protected $rules = [
        'id' => 'required|integer',
        'comment_type' => 'required|integer|between:0,1',
        'id_value' => 'required|integer',
        'comment_rank' => 'integer|between:1,5',
        'add_time' => 'required|integer',
        'ip_address' => 'max:20',
        'status' => 'integer|between:0,1',
        'parent_id' => 'integer',
        'user_id' => 'required|integer',
        'is_anonymous' => 'integer|between:0,1',
        'order_id' => 'required|integer',
    ];
    
    //总的自定义错误信息
    protected $messages = [
        'id.required' => 'ID必填',
        'id.integer' => 'ID必须为数字',
        'comment_type.required' => '用户评论的类型必填',
        'comment_type.integer' => '用户评论的类型必须为数字',
        'comment_type.between' => '用户评论的类型;0评论的是商品,1评论的是文章',
        'id_value.required' => '文章或者商品的id必填',
        'id_value.integer' => '文章或者商品的id必须为数字',
        'comment_rank.integer' => '评价等级必须为数字',
        'comment_rank.between' => '评价等级，1到5星',
        'add_time.required' => '添加时间必填',
        'add_time.integer' => '添加时间必须是数字',
        'ip_address.max' => 'IP地址不能超过20个字符',
        'status.integer' => '状态必须是数字',
        'status.between' => '是否显示;1是;0隐藏',
        'parent_id.integer' => '评论的父节点必须为数字',
        'user_id.required' => '用户ID必填',
        'user_id.integer' => '用户ID必须为数字',
        'is_anonymous.integer' => '是否匿名必须是数字',
        'is_anonymous.between' => '是否匿名，0否',
        'order_id.required' => '订单ID必填',
        'order_id.integer' => '订单ID必须为数字',
    ];
    
    //场景验证规则
    protected $scene = [
        'add'  => ['comment_type', 'id_value', 'comment_rank', 'ip_address', 'status', 'parent_id', 'user_id', 'is_anonymous', 'order_id'],
        'edit' => ['comment_type', 'id_value', 'comment_rank', 'ip_address', 'status', 'parent_id', 'user_id', 'is_anonymous', 'order_id'],
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