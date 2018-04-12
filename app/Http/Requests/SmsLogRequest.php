<?php
namespace app\common\validate;

use think\Validate;

class SmsLog extends Validate
{
    // 验证规则
    protected $rule = [
        ['id', 'require|number','ID必填|ID必须是数字'],
        ['mobile', 'require|max:20','手机号必填|手机号不能超过20个字符'],
        ['text', 'require|max:200','发送的内容必填|发送的内容不能超过200个字符'],
        ['status', 'in:1,2','状态：1成功，2失败'],
        ['result', 'max:500', '返回结果不能超过500个字符'],
    ];
    
    protected $scene = [
        'add' => ['mobile', 'text', 'status', 'result'],
        'del' => ['id'],
    ];
}