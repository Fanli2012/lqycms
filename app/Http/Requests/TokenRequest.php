<?php
namespace app\common\validate;

use think\Validate;

class Token extends Validate
{
    // 验证规则
    protected $rule = [
        ['id', 'require|number','ID必填|ID必须是数字'],
        ['token', 'require|max:128','token必填|token不能超过128个字符'],
        ['type', 'in:0,1,2,3,4,5,6','token类型，0:app, 1:admin, 2:weixin, 3:wap, 4: pc'],
        ['uid', 'require|number','uid必填|uid必须是数字'],
    ];
    
    protected $scene = [
        'add' => ['token', 'type', 'uid'],
        'del' => ['id'],
    ];
}