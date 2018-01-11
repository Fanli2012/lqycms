# lqycms
基于laravel框架的开源cms管理系统，git clone https://github.com/Fanli2012/lqycms.git

![alt text](/public/images/screenshots.png "网站截图")
![alt text](/public/images/wscscreenshots.png "微商城截图")
![alt text](/public/images/wapscreenshots.png "手机站截图")


# 说明

1、基于Laravel 5.4

2、PHP+Mysql

3、后台登录：/fladmin/login，账号：admin888，密码：admin

4、恢复后台默认账号密码：/fladmin/recoverpwd

5、LQYCMS适用于微商城、企业建站(展示型)等二次开发，微商城入口http://+域名+/weixin，支付仅支持微信支付。

6、后台功能
1) 文章管理：增删改查，栏目管理
2) 单页管理
3) RBAC权限管理，角色管理
4) 商品管理：商品品牌，商品分类
5) 订单管理
6) 会员管理，会员等级管理
7) 轮播图
8) 友情链接
9) 意见反馈
10) 优惠券管理
11) 系统参数配置
12) 微信自定义菜单


# 安装

1、 导入数据库
1) 打开根目录下的lqycms.sql文件，将 http://www.lqycms.com 改成自己的站点根网址，格式：http://+域名
2) 导入数据库

2、 复制.env.example重命名成.env，修改相应配置APP_DOMAIN、APP_SUBDOMAIN及数据库配置

3、 
php composer.phar install

php artisan key:generate


4、 登录后台：/fladmin/login.php，账号：admin888，密码：admin

顶部按钮，更新缓存


# 注意
只能放在根目录
如果要开启调试模式，请修改 .env 文件， APP_ENV=local 和 APP_DEBUG=true 。