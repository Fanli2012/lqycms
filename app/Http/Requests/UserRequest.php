<?php
namespace App\Http\Requests;

class UserRequest extends BaseRequest
{
    //总的验证规则
    protected $rules = [
        'id' => 'required|integer',
        'email' => 'max:60',
        'user_name' => 'required|max:60',
        'password' => 'required|max:50',
        'pay_password' => 'max:50',
        'head_img' => 'max:255',
        'sex' => 'integer|between:0,2',
        'birthday' => 'date_format:"Y-m-d"',
        'commission' => ['regex:/^\d{0,10}(\.\d{0,2})?$/'],
        'money' => ['regex:/^\d{0,10}(\.\d{0,2})?$/'],
        'frozen_money' => ['regex:/^\d{0,10}(\.\d{0,2})?$/'],
        'point' => 'integer',
        'rank_points' => 'integer',
        'address_id' => 'integer',
        'add_time' => 'integer',
        'user_rank' => 'integer|between:0,99999',
        'parent_id' => 'integer',
        'nickname' => 'max:30',
        'mobile' => 'max:20',
        'status' => 'integer|between:0,5',
        'group_id' => 'integer|between:0,99999',
        'updated_at' => 'integer',
        'signin_time' => 'date_format:"Y-m-d H:i:s"',
        'openid' => 'max:100',
        'unionid' => 'max:128',
        'push_id' => 'max:30',
        'refund_account' => 'max:30',
        'refund_name' => 'max:20',
        'consumption_money' => ['regex:/^\d{0,10}(\.\d{0,2})?$/'],
    ];
    
    //总的自定义错误信息
    protected $messages = [
        'id.required' => 'ID必填',
        'id.integer' => 'ID必须为数字',
        'email.max' => 'email不能大于60个字符',
        'user_name.required' => '用户名必填',
        'user_name.max' => '用户名不能大于60个字符',
        'password.required' => '密码必填',
        'password.max' => '密码不能大于50个字符',
        'pay_password.max' => '支付密码不能大于50个字符',
        'head_img.max' => '头像不能大于255个字符',
        'sex.integer' => '性别必须为数字',
        'sex.between' => '性别1男2女',
        'birthday.date_format' => '生日格式不正确',
        'commission.regex' => '累积佣金格式不正确，累积佣金只能带2位小数的数字',
        'money.regex' => '用户余额格式不正确，用户余额只能带2位小数的数字',
        'frozen_money.regex' => '用户冻结资金格式不正确，用户冻结资金只能带2位小数的数字',
        'point.integer' => '用户积分必须为数字',
        'rank_points.integer' => '会员等级积分必须为数字',
        'address_id.integer' => '默认收货地址ID必须为数字',
        'add_time.integer' => '注册时间必须为数字',
        'user_rank.integer' => '用户等级必须为数字',
        'user_rank.between' => '用户等级只能1-99999',
        'parent_id.integer' => '推荐人ID必须为数字',
        'nickname.max' => '昵称不能大于30个字符',
        'mobile.max' => '手机号不能大于20个字符',
        'status.integer' => '用户状态必须为数字',
        'status.between' => '用户状态 1正常状态 2 删除至回收站 3锁定',
        'group_id.integer' => '分组必须为数字',
        'group_id.between' => '分组只能1-99999',
        'updated_at.integer' => '更新时间必须为数字',
        'signin_time.date_format' => '签到时间格式不正确',
        'openid.max' => 'openid不能大于100个字符',
        'unionid.max' => 'unionid不能大于120个字符',
        'push_id.max' => 'push_id不能大于30个字符',
        'refund_account.max' => '退款账户不能大于30个字符',
        'refund_name.max' => '退款姓名不能大于20个字符',
        'consumption_money.regex' => '累计消费金额格式不正确，只能带2位小数的数字',
    ];
    
    //场景验证规则
    protected $scene = [
        'add' => ['email', 'user_name', 'password', 'pay_password', 'head_img', 'sex', 'birthday', 'commission', 'money', 'frozen_money', 'point', 'rank_points', 'address_id', 'add_time', 'user_rank', 'parent_id', 'nickname', 'mobile', 'status', 'group_id', 'updated_at', 'signin_time', 'openid', 'unionid', 'push_id', 'refund_account', 'refund_name', 'consumption_money'],
        'edit' => ['email', 'head_img', 'sex', 'birthday', 'address_id', 'nickname', 'updated_at', 'refund_account', 'refund_name'],
        'wx_register' => ['email', 'user_name', 'password', 'pay_password', 'head_img', 'add_time', 'parent_id', 'nickname', 'mobile', 'group_id', 'openid', 'unionid', 'push_id'],
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