<?php
namespace app\common\validate;

use think\Validate;

class VerifyCode extends Validate
{
    // 验证规则
    protected $rule = [
        ['id', 'require|number','ID必填|ID必须是数字'],
        ['code', 'require|max:10','验证码必填|验证码不能超过10个字符'],
        ['type', 'in:0,1,2,3,4,5,6,7,8,9','0通用，注册，1:手机绑定业务验证码，2:密码修改业务验证码'],
        ['mobile', 'require|max:20','手机号必填|手机号不能超过20个字符'],
        ['status', 'in:0,1','0:未使用 1:已使用'],
        ['result', 'max:500', '返回结果不能超过500个字符'],
    ];
    
    protected $scene = [
        'add' => ['mobile', 'text', 'status', 'result'],
        'del' => ['id'],
    ];
}