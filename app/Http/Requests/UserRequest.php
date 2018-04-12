<?php
namespace app\common\validate;

use think\Validate;

class User extends Validate
{
    // 验证规则
    protected $rule = [
        ['id', 'require|number','ID必填|ID必须是数字'],
        ['user_name', 'require|max:60','用户名必填|用户名不能超过60个字符'],
        ['sex', 'in:0,1,2','性别1男2女'],
        ['password', 'require|max:50','密码必填|密码不能超过50个字符'],
        ['status', 'in:1,2,3','用户状态 1正常状态 2 删除至回收站 3锁定'],
    ];
    
    protected $scene = [
        'add' => ['user_name', 'text', 'status', 'result'],
        'del' => ['id'],
    ];
}