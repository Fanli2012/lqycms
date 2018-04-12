<?php
namespace app\common\validate;

use think\Validate;

class Friendlink extends Validate
{
    // 验证规则
    protected $rule = [
        ['id', 'require|number','ID必填|ID必须是数字'],
        ['webname', 'require|max:60','链接名称必填|链接名称不能超过60个字符'],
        ['url', 'max:100','跳转链接不能超过100个字符'],
        ['group_id', 'number', '分组ID必须是数字'],
        ['rank', 'number','排序必须是数字'],
    ];
    
    protected $scene = [
        'add' => ['webname', 'url', 'target', 'group_id', 'rank'],
        'del' => ['id'],
    ];
}