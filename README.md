# lqycms
基于laravel框架的开源cms管理系统，git clone https://github.com/Fanli2012/lqycms.git

PC端

![alt text](/public/images/screenshots.jpg "网站截图")

WAP端

![alt text](/public/images/wapscreenshots.png "手机站截图")

微商城

![alt text](/public/images/wscscreenshots.jpg "微商城截图")
![alt text](/public/images/wscmyscreenshots.png "微商城个人中心截图")


# 说明

1、基于Laravel 5.4

2、PHP+Mysql

3、后台登录：http://www.lqycms.com/fladmin/login，账号：admin888，密码：admin

4、恢复后台默认账号密码：http://www.lqycms.com/fladmin/recoverpwd

5、LQYCMS适用于微商城、企业建站(展示型)等二次开发。

注意：PC端跟微商城的域名是同一个域名，WAP端的域名通常是PC端的子域名，这里的案例PC端的域名是www.lqycms.com，WAP端的域名是m.lqycms.com

<strong>PC入口</strong>：http://+PC域名+/

<strong>WAP入口</strong>：http://+WAP域名+/，WAP域名解析与PC域名一致，都是指向同一目录下

<strong>微商城入口</strong>：http://+PC域名+/weixin，支付仅支持微信支付。


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

7、前台功能

<strong>PC端</strong>
1) 公司介绍
2) 产品中心
3) 新闻动态
4) 联系我们
5) 友情链接

<strong>微商城</strong>
1) 首页
2) 产品列表
3) 产品详情
4) 购物车
5) 个人中心
6) 我的收藏
7) 我的订单
8) 资金管理
9) 优惠券
10) 地址管理
11) 浏览记录
12) 文章资讯


# 安装

1、 导入数据库
1) 打开根目录下的lqycms.sql文件，将 http://www.lqycms.com 改成自己的站点根网址，格式：http://+域名
2) 导入数据库

2、 复制.env.example重命名成.env，修改相应配置APP_DOMAIN、APP_SUBDOMAIN及数据库配置，APP_SUBDOMAIN表示WAP端的域名

3、 
php composer.phar install

php artisan key:generate


4、 登录后台：http://www.lqycms.com/fladmin/login，账号：admin888，密码：admin

顶部按钮，更新缓存


# 注意
只能放在根目录
如果要开启调试模式，请修改 .env 文件， APP_ENV=local 和 APP_DEBUG=true 。
