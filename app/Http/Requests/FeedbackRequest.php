<?php
namespace app\common\validate;

use think\Validate;

class Feedback extends Validate
{
    // 验证规则
    protected $rule = [
        ['id', 'require|number','ID必填|ID必须是数字'],
        ['content', 'require','意见反馈内容必填'],
        ['title', 'max:150','标题必填|标题不能超过150个字符'],
        ['user_id', 'number', '用户ID必须是数字'],
    ];
    
    protected $scene = [
        'add' => ['content', 'title', 'user_id'],
        'del' => ['id'],
    ];
}