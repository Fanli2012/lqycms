<!DOCTYPE html><html><head><meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
<title><?php echo sysconfig('CMS_WEBNAME'); ?></title><meta name="keywords" content="{dede:field.keywords/}" /><meta name="description" content="{dede:field.description function='html2text(@me)'/}" /><link rel="stylesheet" href="<?php echo sysconfig('CMS_BASEHOST'); ?>/css/style.css"></head><body>
@include('home.common.header')

<style>
.brandul{margin-right:-10px;}
.brandul li{margin: 0 10px 10px 0;-webkit-box-shadow: 0 1px 0 rgba(0,0,0,.1);-moz-box-shadow: 0 1px 0 rgba(0,0,0,.1);box-shadow: 0 1px 0 rgba(0,0,0,.1);float: left;}
.brandul li a{display: block;overflow: hidden;width: 100%;height: 100%;text-decoration: none;}
.brandul li .brand-pic{width: 475px;height: 186px;}
.brandul .brand-des{vertical-align: top;line-height: 26px;height: 26px;padding-left: 10px;border-left: 1px solid #F3F3F3;border-right: 1px solid #F3F3F3;color: #000;}
.brandul .brand-des em{color:#e61414;}
.brandul .brand-des .fl{margin-left:10px;}
.brandul .brand-des .fr{margin-right:20px;}
</style>
<div class="box" style="margin-bottom:5px;margin-top:10px;">
<ul class="brandul">
<?php if($brand_list){foreach($brand_list as $k=>$v){ ?>
<li>
<a href="<?php echo route('home_goodslist',array('brand_id'=>$v['id'])); ?>" target="_blank">
<img class="brand-pic" src="<?php echo $v['litpic']; ?>">
<div class="brand-des"><span class="fl"></span>
<span class="fr"><em><?php echo $v['click']; ?></em>件已付款 &nbsp; <em>仅剩1天</em></span></div></a>
</li><?php }} ?>
</ul></div>

@include('home.common.footer')
</body></html>