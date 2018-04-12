<?php
namespace app\common\validate;

use think\Validate;

class Tagindex extends Validate
{
    // 验证规则
    protected $rule = [
        ['id', 'require|number','ID必填|ID必须是数字'],
        ['tag', 'require|max:36','标签名称必填|标签名称不能超过10个字符'],
        ['filename', 'require|max:60','别名必填|别名不能超过60个字符'],
    ];
    
    protected $scene = [
        'add' => ['tag', 'filename'],
        'del' => ['id'],
    ];
}