<?php
namespace app\common\validate;

use think\Validate;

class Payment extends Validate
{
    // 验证规则
    protected $rule = [
        ['id', 'require|number','ID必填|ID必须是数字'],
        ['pay_code', 'require|max:20','支付方式的英文缩写必填|支付方式的英文缩写不能超过20个字符'],
        ['pay_name', 'require|max:100','支付方式名称必填|支付方式名称不能超过100个字符'],
        ['pay_fee', 'max:10','支付费用不能超过10个字符'],
        ['status', 'in:0,1', '是否可用;0否;1是'],
        ['listorder', 'number','排序必须是数字'],
    ];
    
    protected $scene = [
        'add' => ['pay_code', 'pay_name', 'pay_fee', 'status', 'listorder'],
        'del' => ['id'],
    ];
}