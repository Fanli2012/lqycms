<?php
namespace app\common\validate;

use think\Validate;

class Arctype extends Validate
{
    // 验证规则
    protected $rule = [
        ['id', 'require|number','ID必填|ID必须是数字'],
        ['reid', 'number','父级id必须是数字'],
        ['addtime', 'number','添加时间必须是数字'],
        ['typename', 'require|max:30','栏目名称必填|栏目名称不能超过30个字符'],
        ['seotitle', 'max:150','seo标题不能超过150个字符'],
        ['keywords', 'max:60','关键词不能超过60个字符'],
        ['description', 'max:250','描述不能超过250个字符'],
        ['listorder', 'number','排序必须是数字'],
        ['typedir', 'require|max:30','栏目别名必填|栏目别名不能超过30个字符'],
        ['templist', 'max:50','列表页模板不能超过50个字符'],
        ['temparticle', 'max:50','文章页模板不能超过50个字符'],
        ['litpic', 'max:100','封面或缩略图不能超过100个字符'],
        ['seokeyword', 'max:50','seokeyword不能超过50个字符'],
    ];
    
    protected $scene = [
        'add' => ['typename', 'typedir', 'reid', 'addtime', 'seotitle', 'keywords', 'description', 'listorder', 'templist', 'temparticle', 'litpic', 'seokeyword'],
        'del' => ['id'],
    ];
}