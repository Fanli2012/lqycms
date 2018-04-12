<?php
namespace app\common\validate;

use think\Validate;

class Guestbook extends Validate
{
    // 验证规则
    protected $rule = [
        ['id', 'require|number','ID必填|ID必须是数字'],
        ['title', 'require|max:150','标题必填|标题不能超过150个字符'],
        ['msg', 'require|max:250','内容必填|内容不能超过250个字符'],
        ['name', 'require|max:30','姓名必填|姓名不能超过30个字符'],
        ['phone', 'require|max:30','电话必填|电话不能超过30个字符'],
        ['email', 'require|max:60','邮箱必填|邮箱不能超过60个字符'],
        ['status', 'number', 'status必须是数字'],
        ['addtime', 'number','添加时间必须是数字'],
    ];
    
    protected $scene = [
        'add' => ['varname', 'info', 'value'],
        'del' => ['id'],
    ];
}