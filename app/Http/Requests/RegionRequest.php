<?php
namespace app\common\validate;

use think\Validate;

class Region extends Validate
{
    // 验证规则
    protected $rule = [
        ['id', 'require|number','ID必填|ID必须是数字'],
        ['parent_id', 'number','父级ID必须是数字'],
        ['name', 'require|max:64','名称必填|名称不能超过64个字符'],
        ['type', 'in:0,1,2,3','层级，0国家，1省，2市，3区'],
        ['sort_name', 'max:50','拼音或英文简写不能超过50个字符'],
        ['area_code', 'max:10', '电话区号不能超过10个字符'],
    ];
    
    protected $scene = [
        'add' => ['name', 'parent_id', 'type', 'sort_name', 'area_code'],
        'del' => ['id'],
    ];
}