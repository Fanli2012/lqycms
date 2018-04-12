<?php
namespace app\common\validate;

use think\Validate;

class Page extends Validate
{
    // 验证规则
    protected $rule = [
        ['id', 'require|number','ID必填|ID必须是数字'],
        ['click', 'number', '点击量必须是数字'],
        ['title', 'require|max:150','标题必填|标题不能超过150个字符'],
        ['filename', 'max:60','别名不能超过60个字符'],
        ['template', 'max:30','模板名称不能超过30个字符'],
        ['litpic', 'max:100','缩略图不能超过100个字符'],
        ['pubdate', 'require|number', '更新时间必填|更新时间格式不正确'],
        ['keywords', 'max:60','关键词不能超过60个字符'],
        ['seotitle', 'max:150','seo标题不能超过150个字符'],
        ['description', 'max:250','描述不能超过60个字符'],
    ];
    
    protected $scene = [
        'add' => ['title', 'tuijian', 'click', 'filename', 'template', 'litpic', 'pubdate', 'keywords', 'seotitle', 'description'],
        'del' => ['id'],
    ];
}