<?php
namespace app\common\validate;

use think\Validate;

class GoodsBrand extends Validate
{
    // 验证规则
    protected $rule = [
        ['id', 'require|number','ID必填|ID必须是数字'],
        ['pid', 'number','父级ID必须是数字'],
        ['add_time', 'number','发布时间格式不正确'],
        ['title', 'require|max:150','标题必填|标题不能超过150个字符'],
        ['keywords', 'max:60','关键词不能超过60个字符'],
        ['seotitle', 'max:150','seo标题不能超过150个字符'],
        ['description', 'max:250','描述不能超过250个字符'],
        ['litpic', 'max:100','缩略图不能超过100个字符'],
        ['status', 'in:0,1','是否显示，0显示'],
        ['cover_img', 'max:100','封面不能超过100个字符'],
        ['click', 'number', '点击量必须是数字'],
        ['listorder', 'number|between:1,9999','排序必须是数字|排序只能1-9999'],
    ];
    
    protected $scene = [
        'add' => ['pid', 'add_time', 'title', 'keywords', 'seotitle', 'description', 'litpic', 'status', 'cover_img', 'click', 'listorder'],
        'del' => ['id'],
    ];
}