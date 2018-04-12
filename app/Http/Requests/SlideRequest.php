<?php
namespace app\common\validate;

use think\Validate;

class Slide extends Validate
{
    // 验证规则
    protected $rule = [
        ['id', 'require|number','ID必填|ID必须是数字'],
        ['title', 'require|max:150','标题必填|标题不能超过150个字符'],
        ['url', 'max:100','跳转链接不能超过100个字符'],
        ['target', 'number', '跳转方式必须是数字'],
        ['group_id', 'number', '分组ID必须是数字'],
        ['rank', 'number','排序必须是数字'],
        ['pic', 'max:100','图片地址不能超过100个字符'],
        ['is_show', 'in:0,1','是否显示，默认0显示'],
    ];
    
    protected $scene = [
        'add' => ['title', 'url', 'target', 'group_id', 'rank', 'pic', 'is_show'],
        'del' => ['id'],
    ];
}