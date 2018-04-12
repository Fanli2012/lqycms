<?php
namespace app\common\validate;

use think\Validate;

class Sysconfig extends Validate
{
    // 验证规则
    protected $rule = [
        ['id', 'require|number','ID必填|ID必须是数字'],
        ['varname', 'require|max:100','变量名必填|变量名不能超过100个字符'],
        ['info', 'require|max:100','变量值必填|变量值不能超过100个字符'],
        ['value', 'require', '变量说明必填'],
    ];
    
    protected $scene = [
        'add' => ['varname', 'info', 'value'],
        'del' => ['id'],
    ];
}