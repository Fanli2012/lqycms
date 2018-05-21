/*
SQLyog 企业版 - MySQL GUI v7.14 
MySQL - 5.7.14 : Database - lqycms
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

CREATE DATABASE /*!32312 IF NOT EXISTS*/`lqycms` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `lqycms`;

/*Table structure for table `ecs_push` */

DROP TABLE IF EXISTS `ecs_push`;

CREATE TABLE `ecs_push` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `title` varchar(200) NOT NULL COMMENT '标题',
  `content` varchar(200) NOT NULL COMMENT '内容',
  `photo` varchar(200) DEFAULT NULL COMMENT '图片',
  `objectId` varchar(200) DEFAULT NULL COMMENT 'leancloud返回的objectId',
  `link` varchar(200) DEFAULT NULL COMMENT '链接',
  `platform` tinyint(4) NOT NULL DEFAULT '3' COMMENT '平台类型',
  `push_type` tinyint(4) DEFAULT '0' COMMENT '任务类型 1 定时任务 0 即时推送',
  `message_type` tinyint(4) DEFAULT '1' COMMENT '消息类型 1　系统消息 ２ 物流消息',
  `isPush` tinyint(4) DEFAULT '0' COMMENT '定时任务是否已经推送',
  `push_at` timestamp NULL DEFAULT NULL COMMENT '定时推送时间',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态 0:关闭 1:开启 默认开启',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `push_user_id_index` (`user_id`),
  KEY `push_title_index` (`title`),
  KEY `push_content_index` (`content`),
  KEY `push_photo_index` (`photo`),
  KEY `push_objectid_index` (`objectId`),
  KEY `push_link_index` (`link`),
  KEY `push_status_index` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `ecs_push` */

/*Table structure for table `ecs_topic` */

DROP TABLE IF EXISTS `ecs_topic`;

CREATE TABLE `ecs_topic` (
  `topic_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '''''',
  `intro` text NOT NULL,
  `start_time` int(11) NOT NULL DEFAULT '0',
  `end_time` int(10) NOT NULL DEFAULT '0',
  `data` text NOT NULL,
  `template` varchar(255) NOT NULL DEFAULT '''''',
  `css` text NOT NULL,
  `topic_img` varchar(255) DEFAULT NULL,
  `title_pic` varchar(255) DEFAULT NULL,
  `base_style` char(6) DEFAULT NULL,
  `htmls` mediumtext,
  `keywords` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  KEY `topic_id` (`topic_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `ecs_topic` */

insert  into `ecs_topic`(`topic_id`,`title`,`intro`,`start_time`,`end_time`,`data`,`template`,`css`,`topic_img`,`title_pic`,`base_style`,`htmls`,`keywords`,`description`) values (1,'夏新优惠大酬宾','<p>夏新产品优惠开始了</p>',1241107200,1246291200,'O:8:\"stdClass\":1:{s:7:\"default\";a:1:{i:0;s:11:\"夏新N7|17\";}}','','',NULL,NULL,NULL,NULL,NULL,NULL);

/*Table structure for table `fl_access` */

DROP TABLE IF EXISTS `fl_access`;

CREATE TABLE `fl_access` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `role_id` int(11) unsigned NOT NULL DEFAULT '0',
  `menu_id` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=182 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

/*Data for the table `fl_access` */

insert  into `fl_access`(`id`,`role_id`,`menu_id`) values (1,3,1),(2,3,11),(3,3,12),(4,3,13),(5,3,14),(6,3,15),(7,3,16),(8,3,17),(9,3,18),(10,3,19),(11,3,20),(12,3,21),(13,3,22),(14,3,23),(15,3,24),(16,3,25),(17,3,32),(18,3,33),(19,3,34),(20,3,35),(21,3,36),(22,3,37),(23,3,6),(24,3,78),(25,3,83),(26,1,1),(27,1,2),(28,1,3),(29,1,4),(30,1,5),(31,1,6),(32,1,7),(33,1,8),(34,1,9),(35,1,10),(36,1,11),(37,1,12),(38,1,13),(39,1,14),(40,1,15),(41,1,16),(42,1,17),(43,1,18),(44,1,19),(45,1,20),(46,1,21),(47,1,22),(48,1,23),(49,1,24),(50,1,25),(51,1,26),(52,1,27),(53,1,28),(54,1,29),(55,1,30),(56,1,31),(57,1,32),(58,1,33),(59,1,34),(60,1,35),(61,1,36),(62,1,37),(63,1,38),(64,1,39),(65,1,40),(66,1,41),(67,1,42),(68,1,43),(69,1,44),(70,1,45),(71,1,46),(72,1,47),(73,1,48),(74,1,49),(75,1,50),(76,1,51),(77,1,52),(78,1,53),(79,1,54),(80,1,55),(81,1,56),(82,1,57),(83,1,58),(84,1,59),(85,1,60),(86,1,61),(87,1,62),(88,1,63),(89,1,64),(90,1,65),(91,1,66),(92,1,67),(93,1,68),(94,1,69),(95,1,70),(96,1,71),(97,1,72),(98,1,73),(99,1,74),(100,1,75),(101,1,76),(102,1,77),(103,1,78),(104,1,79),(105,1,80),(106,1,81),(107,1,82),(108,1,83),(109,1,84),(110,1,85),(111,1,86),(112,1,87),(113,1,88),(114,1,89),(115,1,90),(116,1,91),(117,1,92),(118,1,93),(119,1,94),(120,1,95),(121,1,96),(122,1,97),(123,1,98),(124,1,99),(125,1,100),(126,1,101),(127,1,102),(128,1,103),(129,1,104),(130,1,105),(131,1,106),(132,1,107),(133,1,108),(134,1,109),(135,1,110),(136,1,111),(137,1,112),(138,1,113),(139,1,114),(140,1,115),(141,1,116),(142,1,117),(143,2,2),(144,2,38),(145,2,39),(146,2,40),(147,2,41),(148,2,42),(149,2,50),(150,2,43),(151,2,44),(152,2,45),(153,2,46),(154,2,47),(155,2,48),(156,2,49),(157,2,51),(158,2,107),(159,2,108),(160,2,109),(161,2,110),(162,2,111),(163,2,112),(164,2,5),(165,2,7),(166,2,8),(167,2,9),(168,2,10),(169,2,104),(170,1,118),(171,1,119),(172,1,120),(173,1,121),(174,1,122),(175,1,123),(176,1,124),(177,1,125),(178,1,126),(179,1,127),(180,1,128),(181,1,129);

/*Table structure for table `fl_admin` */

DROP TABLE IF EXISTS `fl_admin`;

CREATE TABLE `fl_admin` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL DEFAULT '' COMMENT 'admin888',
  `email` varchar(30) NOT NULL DEFAULT '' COMMENT '邮箱',
  `logintime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '登录时间',
  `pwd` char(32) NOT NULL DEFAULT '' COMMENT 'admin',
  `role_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '角色id',
  `status` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '用户状态 0：正常； 1：禁用 ；2：未验证',
  `mobile` varchar(20) NOT NULL DEFAULT '' COMMENT '手机号',
  `avatar` varchar(150) NOT NULL DEFAULT '' COMMENT '头像',
  `create_at` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '注册时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `fl_admin` */

insert  into `fl_admin`(`id`,`username`,`email`,`logintime`,`pwd`,`role_id`,`status`,`mobile`,`avatar`,`create_at`) values (1,'admin888','admin@qq.com',1522285962,'21232f297a57a5a743894a0e4a801fc3',1,0,'','',4294967295),(2,'abc','abc@qq.com',1497285296,'e10adc3949ba59abbe56e057f20f883e',2,0,'','',4294967295),(3,'xyz','xyz@qq.com',0,'e10adc3949ba59abbe56e057f20f883e',1,0,'','',4294967295);

/*Table structure for table `fl_admin_role` */

DROP TABLE IF EXISTS `fl_admin_role`;

CREATE TABLE `fl_admin_role` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL DEFAULT '' COMMENT '角色名',
  `des` varchar(150) NOT NULL DEFAULT '' COMMENT '描述',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态，0启用，1禁用',
  `pid` smallint(11) unsigned NOT NULL DEFAULT '0' COMMENT '父角色id',
  `listorder` int(5) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`id`),
  UNIQUE KEY `rolename` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='角色表';

/*Data for the table `fl_admin_role` */

insert  into `fl_admin_role`(`id`,`name`,`des`,`status`,`pid`,`listorder`) values (1,'超级管理员','拥有网站最高管理员权限！',0,0,0),(2,'普通角色','',0,0,0);

/*Table structure for table `fl_appsign` */

DROP TABLE IF EXISTS `fl_appsign`;

CREATE TABLE `fl_appsign` (
  `id` int(4) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL DEFAULT '',
  `app_key` varchar(128) NOT NULL DEFAULT '',
  `app_secret` varchar(128) NOT NULL DEFAULT '',
  `type` tinyint(4) unsigned NOT NULL DEFAULT '0' COMMENT '0:app, 1:admin, 2:weixin, 3:wap, 4: pc',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='接口应用认证信息';

/*Data for the table `fl_appsign` */

insert  into `fl_appsign`(`id`,`name`,`app_key`,`app_secret`,`type`,`created_at`,`updated_at`) values (1,'W星球后台签名','WSTAR-ADMIN-KEY-20170315','WSTAR-ADMIN-SECRET-20170315',1,'2017-03-14 12:48:09','2018-03-27 15:50:06'),(2,'W星球象盟API接口签名','WSTAR-XIANGMENG-KEY-20170420','WSTAR-XIANGMENG-SECRET-20170420',1,'2017-04-20 16:48:44','2018-03-27 15:50:06'),(3,'商户管理','WSTAR-WAP-KEY-20160314','WSTAR-WAP-SECRET-20160314',1,'2017-05-02 10:32:34','2018-03-27 15:50:06'),(4,'W星球后铺API接口签名','WSTAR-HOUPU-KEY-20170502','WSTAR-HOUPU-SECRET-20170502',1,'2017-05-02 10:54:19','2018-03-27 15:50:06');

/*Table structure for table `fl_arctype` */

DROP TABLE IF EXISTS `fl_arctype`;

CREATE TABLE `fl_arctype` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '父级栏目id',
  `addtime` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `name` varchar(30) NOT NULL DEFAULT '' COMMENT '栏目名称',
  `seotitle` varchar(150) NOT NULL DEFAULT '' COMMENT 'seo标题',
  `keywords` varchar(60) NOT NULL DEFAULT '' COMMENT '关键词',
  `description` varchar(255) NOT NULL DEFAULT '' COMMENT '描述',
  `content` mediumtext COMMENT '内容',
  `typedir` varchar(30) NOT NULL DEFAULT '' COMMENT '别名',
  `templist` varchar(50) NOT NULL DEFAULT '' COMMENT '列表页模板',
  `temparticle` varchar(50) NOT NULL DEFAULT '' COMMENT '文章页模板',
  `litpic` varchar(100) NOT NULL DEFAULT '' COMMENT '封面或缩略图',
  `seokeyword` varchar(60) NOT NULL DEFAULT '' COMMENT '判断相关,可不填',
  `model` int(4) unsigned NOT NULL DEFAULT '0' COMMENT '栏目所属的模型',
  `listorder` int(5) unsigned NOT NULL DEFAULT '50' COMMENT '排序',
  `is_show` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否显示，默认0显示',
  PRIMARY KEY (`id`),
  UNIQUE KEY `typename` (`name`),
  UNIQUE KEY `typedir` (`typedir`),
  KEY `pid` (`pid`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='文章分类表';

/*Data for the table `fl_arctype` */

insert  into `fl_arctype`(`id`,`pid`,`addtime`,`name`,`seotitle`,`keywords`,`description`,`content`,`typedir`,`templist`,`temparticle`,`litpic`,`seokeyword`,`model`,`listorder`,`is_show`) values (1,0,1483345707,'新闻中心','','新闻中心','新闻中心','<p>新闻中心</p>','news','category','detail','','新闻中心',0,50,0),(2,0,1476063429,'案例中心','','案例中心','案例中心','<p>案例中心</p>','case','category','detail','','案例中心',0,50,0),(3,1,1476063419,'行业新闻','','行业新闻','行业新闻','<p>行业新闻</p>','hangye','category','detail','','行业新闻',0,50,0),(4,1,1476068069,'企业新闻','','企业新闻','企业新闻','<p>企业新闻</p>','qiye','category','detail','','企业新闻',0,50,0);

/*Table structure for table `fl_article` */

DROP TABLE IF EXISTS `fl_article`;

CREATE TABLE `fl_article` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `typeid` int(5) unsigned NOT NULL DEFAULT '0' COMMENT '栏目id',
  `tuijian` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '推荐等级',
  `click` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '点击量',
  `title` varchar(150) NOT NULL DEFAULT '' COMMENT '标题',
  `body` mediumtext COMMENT '内容',
  `writer` varchar(20) NOT NULL DEFAULT '' COMMENT '作者',
  `source` varchar(30) NOT NULL DEFAULT '' COMMENT '来源',
  `litpic` varchar(100) NOT NULL DEFAULT '' COMMENT '缩略图',
  `pubdate` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `addtime` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `keywords` varchar(60) NOT NULL DEFAULT '' COMMENT '关键词',
  `seotitle` varchar(150) NOT NULL DEFAULT '' COMMENT 'seo标题',
  `description` varchar(250) NOT NULL DEFAULT '' COMMENT '描述',
  `ischeck` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否审核，默认0审核',
  `typeid2` int(5) unsigned NOT NULL DEFAULT '0' COMMENT '副栏目id',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '是谁发布的',
  `listorder` int(5) unsigned NOT NULL DEFAULT '50' COMMENT '排序',
  PRIMARY KEY (`id`),
  KEY `writer` (`writer`),
  KEY `idx_typeid_ischeck` (`typeid`,`ischeck`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='文章表';

/*Data for the table `fl_article` */

insert  into `fl_article`(`id`,`typeid`,`tuijian`,`click`,`title`,`body`,`writer`,`source`,`litpic`,`pubdate`,`addtime`,`keywords`,`seotitle`,`description`,`ischeck`,`typeid2`,`user_id`,`listorder`) values (1,4,0,467,'移动网站建设常见问题','<p>移动网站兴起时间不长，站长有很多相似的问题。在2014年11月份的百度移动搜索沙龙上，移动专家针对站长提问较多的问题进行了统一回答，与往期沙龙的零星回答合并整理如下：<br/></p><p><br/></p><p>问：我的移动站内容和PC站是一样的，这样需不需要屏蔽百度的PC搜索蜘蛛？</p><p><br/></p><p>答：由于百度的PC搜索和移动搜索共用同一个spider，都带有baidu标示，不要进行屏蔽。Spider在抓取时会对页面进行识别，自动判断是PC页还是mobile页，因此建议站长使用规范的html5/xhtml协议语言来建设移动站。</p><p><br/></p><p>问：手机站使用xhtml与html5开发，对搜索引擎是否有区别？</p><p><br/></p><p>答：大家使用手机搜索时会发现用2G的情况下移动搜索会给你到极速版，就是保证你得到结果的速度足够快，但是结果样式比较简单。一般情况下极速版我们会优先给Xhtml的结果，触屏版优先给html5,效果更加炫酷。</p><p><br/></p><p>问：如果是URL、PC访问和移动访问分别识别不同的模版，例如我们有一个URL，PC访问是是这个模版，手机访问是那个模版。那么我们是使用相同的URL好，还是单独的做一个M站好？</p><p><br/></p><p>答：理想状态下同一套url是最优的。目前受限于机制问题，还有待进一步解决，预期14年底能够完成。目前仍然建议大家移动站使用单独的m链接。同时，暂时不要使用类似这样的url：http://m.site.com?src=http://www.site.com。</p><p><br/></p><p>问：感谢，我们是这样理解吧，未来的话如果以用户习惯来说，是同一个URL好？</p><p><br/></p><p>答：理想的技术角度看，是同一个url更好，但是目前尽量仍然使用单独的m链接。</p><p><br/></p><p>问：一个站点有M站和PC站，采用完全相同的TDK，是否有问题，手机站的SEO规则是否跟PC站相同？</p><p><br/></p><p>答：TDK代表标题、摘要、关键词是吧？先理解一下。是这样的，PC端和移动端搜索结果展现标题和摘要的字数限制等都是不同的，PC端30多个中文汉字才截断，移动端不到20个就折行了，20多个就省略看不到了。所以，建议移动站使用单独的TDK。</p><p><br/></p><p>问：如果两个站点它的TDK都是完全相同的，每一个页面，会不会导致站点被惩罚？</p><p><br/></p><p>答：这里说的两个站如果指同一个站点的PC和移动，肯定是不会导致被惩罚的。</p><p><br/></p><p>问：外链对手机站是否有效果？</p><p><br/></p><p>答：外链还是有效果的，但不要做那些垃圾外链，比如说论坛的标签里面或者说买卖链接或者是说批量的发链接有可能被惩罚。正常交换一下链接是有帮助的。0和1是明显不同的。</p><p><br/></p><p>问：百度移动搜索对我的移动站收录较少，该如何做？</p><p><br/></p><p>答：1.如果您同时具有PC站，且PC与移动站是一一对应的关系，请利用开放适配工具进行提交，既可以帮助移动站的收录又可以帮助您将PC站的排名转移至移动搜索；2.如果您只有移动站，也可以通过我们的移动sitemap工具向百度进行提交。</p>','','','',1476454862,1476063853,'移动,网站建设,常见问题','','移动网站兴起时间不长，站长有很多相似的问题。在2014年11月份的百度移动搜索沙龙上，移动专家针对站长提问较多的问题进行了统一回答，与往期沙龙的零星回答合并整理如下：问：我的',0,0,0,50),(2,2,1,353,'对百度搜索引擎友好的网站结构','<p>我们在做网站结构相关SEO工作时，都应该考虑以下四个问题：<br/></p><p>1，Baiduspider能不能找到所有网页</p><p>2，Baiduspider是否知道哪个网页是重要的</p><p>3，Baiduspider能否顺利提取网页内容</p><p>4，Baiduspider能否在网页中提炼有用信息&nbsp;</p><p><br/></p><p>下面讲的内容便是解决前两个问题的：</p><p><br/></p><p>一，友好的网站结构</p><p><br/></p><p>1，扁平or树型：一说到网站结构，大家都会提到扁平结构和树型结构，言必称“结构扁平化”，这些指的是物理结构，即基于内容聚合的目录及文件位置决定的结构。其实对于百度搜索引擎来说，只要结构合理、有逻辑性、内容有规律可循都可以，都是友好的。</p><p><br/></p><p>2，链接结构：相对于物理结构，就要说到逻辑结构：即通过内部链接形成的链接结构，逻辑结构才是搜索引擎最关注的。对于一个网站来说，网页仅仅可以通过首页——目录1——目录2一层一层follow到是远远不够的，一个优秀的链接结构应该是网状的。</p><p><br/></p><p>1）首页链接应该链向重要的频道页，频道页再链向下面的节点页或普通页面。同时，频道页、节点页和普通页面都应该可以链回到首页</p><p>2）无论哪些页面之间互相链接，都需要一个描述恰当的锚文本</p><p>3）链接不要放在JS、FLASH等搜索引擎不可见的位置，使用图片做链接入口应该完善alt标签</p><p>&nbsp; &nbsp;*百度搜索引擎目前仅支持对部分JS和FLASH进行解析，绝大多数放在JS和FLASH里的链接都是获取不到的</p><p>4）为重要页面留更多入口。百度搜索引擎认为，获得更多内部投票的网页相对来说更加重要</p><p>5） “离首页越近”的网页，越容易受到百度重视。这个“近”指的是页面离首页的点击距离。即使URL所在目录层级较深，只要在首页有入口，百度也认为这是一个非常重要的页面。</p><p>6）不要产生可怕的孤岛页面。虽然百度在提交入口、社会化挖掘方面做了许多工作，但链接抓取依然是百度获得新页面的最重要渠道</p><p><br/></p><p>二，通过导航让百度更好地认识站点</p><p><br/></p><p>对于用户，导航要解决的问题是：我在网站的什么位置，我想看上一级、甚至上上一级更多内容的入口在哪里；对于spider，导航要解决的问题是：这个页面属于哪个领域，要表达的主题是什么。所以说，清晰的导航系统不仅有助于提高用户体验，对SEO的意义也是重大的，所有SEO做得出色的网站基本都拥有清晰明确的导航。</p><p><br/></p><p>1，导航内容搜索引擎可见：有网站的导航对用户来说美观友好，对百度来说却是不可见的。目前百度还不能搞定所有的JS和FLASH，保险起见，还是使用HTML的好。图片虽然美丽，作为导航也是对搜索引擎不友好的行为。</p><p><br/></p><p>2，导航稳定：导航内容应该是相对固定的，不要让导航成为“滚动条”。</p><p><br/></p><p>3，重要网页尽可能地在导航处可以follow到：百度认为主导航中出现的链接，其重要性仅次于网站首页，所以应该尽量将站内的页面在主导航中安排个位置。当然，主导航上也不可能放过多的内容，哪些链接可以上主导航还需要SEO人员进行平衡。</p><p><br/></p><p>4，巧用面包屑导航：上面说到，导航对于用户来说，解决了“想看上一级、甚至上上一级更多内容”的问题，这个导航指的就是面包屑导航。面包屑导航可以使结构复杂庞大的大中型网站变得清晰轻盈，在spider进行页面解析时会着重查看面包屑导航内容，强烈建议使用。</p><p><br/></p><p>三，合理的domain结构</p><p><br/></p><p>除了在网站建设的时候站长会思考到底使用二级域名还是子目录，在网站运营的过程中，也会考虑是否要把子目录的内容拆分成二级域名。因为很多SEO人员认为二级域名相对独立，其首页会得到百度的重视，能获得更好的排位——其实这是一个片面的错误观点，百度会通过很多指标对同domain下的二级域名和子目录进行重要程度判断，并没有武断地认为谁天生就会比谁强一些。</p><p><br/></p><p>当SEO认为站内结构已经阻碍了网站高速发展就会考虑改版，最常见的改版便是将子目录移出主站点、单独形成二级域名。但大家都知道，改版肯定会对站点的收录排名和流量造成影响，一定要谨慎。那么在什么情况下才真的需要将子目录换成二级域名呢？其实只有一点：即子目录的内容足够丰富，且与主域的主题关联性不强！</p><p><br/></p><p>四，url结构很重要</p><p><br/></p><p>1，url结构规律化：同一个网页有不同url，会造成多个url同时被用户推荐导致权值分散；同时百度最终选择展现的那个url不一定符合你的预期。站点应该尽量不把sessionid和统计代码等不必要的内容放在url，如果一定要这样做可以通过robots禁止百度抓取这些非规范url</p><p><br/></p><p>2，最好能让用户从url即可判断出网页内容，便于蜘蛛解析的同时便于用户间传播</p><p><br/></p><p>3，url尽量短</p><p><br/></p><p>●蜘蛛喜欢：http://tieba.baidu.com.com/f?kw=百度</p><p>●蜘蛛不喜欢：http://tieba.baidu.com/f?ct=&amp;tn=&amp;rn=&amp;ln=&amp;cn=0&amp;kw=百度&amp;rs2=&amp;un=&amp;rs1=&amp;rs5=&amp;sn=&amp;rs6=&amp;nvselectvalue=0&amp;oword=百度&amp;tb=cn</p><p><br/></p><p>4，不要添加蜘蛛难以解析的字符，如</p><p>http://mp3.XXX.com/albumlist/234254;;;;;;;%B9&amp;CE%EDWF%.html</p><p>http://news.xxx.com/1233,242,111,0.shtml</p><p><br/></p><p>5，动态参数不要太多太复杂，目前百度对动态url已经有了很好的处理，但是参数过多过复杂的url有可能被蜘蛛认为不重要而抛弃。</p>','','','/images/3.jpg',1476454546,1476063905,'对,百度,搜索引擎,友,好的,网站,结构','','我们在做网站结构相关SEO工作时，都应该考虑以下四个问题：1，Baiduspider能不能找到所有网页2，Baiduspider是否知道哪个网页是重要的3，Baiduspider能否顺利提取网页内容4，Baiduspider能否在网页',0,0,0,50),(3,1,1,379,'在移动搜索展现端获得良好表现的注意事项','<p>移动网站优化和PC网站的很多方面都是相似甚至相同的，但由于移动搜索界面大小受限，移动网站在标题和摘要的撰写上有很多有别有PC端的情况。<br/></p><p><br/></p><p>1，有吸引力的title</p><p><br/></p><p>用户在百度移动搜索中输入query搜索到你的页面时，title作为最重要的内容展现在搜索结果中，主题明确、吸引眼球的title能够使用户第一时间理解你页面的主题是否符合他的需求，进而更快捷地从众多搜索结果中选择你点击你。所以，移动网页的TITLE应该是：</p><p><br/></p><p>●主题明确；</p><p><br/></p><p>●简洁扼要，不罗列，尽量不超过17个中文汉字，否则会折行；</p><p><br/></p><p>●如果你的品牌知名度高，品牌词最好能够展现出来；</p><p><br/></p><p>●在与内容相符的前提下，吸引眼球</p><p><br/></p><p>2，不唯一的description,</p><p><br/></p><p>作为搜索结果摘要的重要选择目标之一，一定不要采用默认形式，用适当的语言对页面进行进一步描述，对title的进一步补充，能够使用户更进一步理解你页面的内容与其需求是否匹配，让你的目标用户更快找到你点击你。</p><p><br/></p><p>●对title的进一步补充，准确描述页面内容，但不堆砌关键词，否则可能被认为有作弊嫌疑；</p><p><br/></p><p>●每个页面要有不同的description，尽量不适用默认一样的；</p><p><br/></p><p>●适当的长度，超出会被截断.</p>','','','',1496551932,1476063946,'在,移动,搜索,展现,端,获得,良好,表现,的,注意事项','','移动网站优化和PC网站的很多方面都是相似甚至相同的，但由于移动搜索界面大小受限，移动网站在标题和摘要的撰写上有很多有别有PC端的情况。1，有吸引力的title用户在百度移动搜索中输',0,0,1,50),(4,2,0,248,'撰写搜索引擎喜欢的标题','<p>通过观察可以发现，那些可以从搜索引擎获得大批流量的站点来说，SEO思维渗透到了每个岗位，产品人员在提交项目MRD时，网页标题的写法是必不可少的一部分；编辑对文章内容负责的同时，要设计出吸引用户和搜索引擎的标题；而不是单纯地把优化工作全部扔给SEO人员。所以，今天我们想跟产品人员和编辑说说网页标题该怎么写。<br/></p><p><br/></p><p>一，标题的结构</p><p><br/></p><p>1，标题字数控制在60个字节内：从以往的经验看，检索用户比较喜欢50个字节左右的标题；对于产品人员和编辑来说，过短的标题有可能无法全面表达网页主题；对于搜索引擎来说，标题过长意味着“超标”，只会保留前60个字节的内容。</p><p><br/></p><p>【反面case】福州到北京旅游_北京旅游天气如何_北京旅游景点介绍_北京好玩吗_现在去北京旅游会热吗</p><p><br/></p><p>2，重要内容放在标题的最前面：在众多检索结果中，用户的目光往往聚焦在标题前半段，所以重要信息内容放在标题前部非常重要。</p><p><br/></p><p>【正面case】关之琳否认脑癌发作称洗牙遭误会|关之琳|癌症_凤凰娱乐</p><p><br/></p><p>3，放置网站名称，增加曝光机会：有些站点已经在某领域有了一定的知名度和权威性，其站名名称已经成为一种品牌，可以将该品牌词体现在标题中，用户在面对众多结果时，更倾向于选择点击自己熟知网站提供的信息。即使网站目前的知名度还不够，更不应该放过每个品牌曝光的机会。</p><p><br/></p><p>【正面case:】【单电和微单的区别】-蜂鸟网</p><p><br/></p><p>【正面case】法国卢浮宫博物馆藏文物精品在中国国家博物馆展出-新华网</p><p><br/></p><p>二，标题放什么内容更吸引用户</p><p><br/></p><p>用户在百度搜索框输入关键词后，百度在对相关网页进行排序时，网页标题内容是其考虑的重要因素。同时，搜索结果页内通常会有10个结果，用户往往是通过标题和摘要来决定要点击开哪个结果。标题上关键词的选择至关重要。</p><p><br/></p><p>1，与网页内容最相关的关键词：首先，标题应该和网页内容相对应，即标题上的内容，可以在网页主体部分得到展示。一般来说，如果网页主要部分是一篇文章，网页标题的主要内容往往是文章标题；如果网页是一个综合信息的集合页，我们也要找到这些信息的共同点，通过一两个关键词将其表现在网页标题上。</p><p><br/></p><p>【正面case】婴儿哭闹的原因_婴儿期0-1岁_育儿知识_宝宝树</p><p><br/></p><p>2，选择用户更常用的关键词：同一个物品有不同的名称、同一件事情也有不同的描述，选择哪个放在title上呢？虽然百度有强大的关键词分析算法，但我们还是推荐大家使用搜索引擎用户最常用的那个。关键词的热度可以通过百度指数进行查询，目前网络上还有一些其它工具，大家也可以参考一下。</p><p><br/></p><p>如佳能有一款单反相机，标准全称是“5dmarkii”，简称“5D2”，广大搜索爱好者亲切地称之为“无敌兔”。从字面上看，“5dmarkii”输入起来比较麻烦。再看一下它们的百度指数：</p><p><br/></p><p>“5dmarkii”：257</p><p>“5D2”：875</p><p>“无敌兔”:467</p><p><br/></p><p>很明显，“5D2”由于指向清晰、朗朗上口且容易输入，最受搜索引擎用户喜爱</p><p><br/></p><p>3，选择能满足用户明确需求的关键词：能体现用户明确需求的关键词往往字数偏长，SEO人员一般称此为长尾关键词，如“杭州两日游路线”“从上海到西塘怎么走”等。我们的产品人员和编辑应该一方面了解用户需求，一方面制作可以满足用户需求的网页，通过将含有用户明确需求的关键词写在标题上来吸引搜索引擎用户的点击。</p><p><br/></p><p>【正面case】【宝宝补锌】儿童缺锌怎么办_怎样给孩子补锌-摇篮网</p><p><br/></p><p>4，在真实的前提下体现时效性：在标题放时效性关键词最重要的前提是：网页里真的有时效性内容，否则非常容易被搜索引擎惩罚。</p><p><br/></p><p>【正面case】2014-10月8万套北京北京二手房价格,真房价没水分!「链家」</p><p><br/></p><p>5，直击用户痛点，引发共鸣：还以上面那个case为例，虚假房源和房价一直是二手房买方心中的痛，“2014-10月8万套北京北京二手房价格,真房价没水分!「链家」”直面用户痛点，再配上“链家”的招牌，点击率一直居高不下。当然，这已经超越了SEO的范畴，相信编辑人员在这方面有更多经验。</p><p><br/></p><p>三，设计标题时避免做下面的事情</p><p><br/></p><p>1，欺骗用户和搜索引擎：有些网站在标题上放置过多重复意义的关键词，甚至放置与内容无关的热门关键词以吸引甚至欺骗用户和搜索引擎，这样很容易被搜索引擎判为作弊而受到惩罚，是一件非常危险的事情。所以：千万不要在标题中体现网页内没有的内容。</p><p><br/></p><p>【反面case1】青蛇完整_青蛇完整全集在线观看_青蛇完整完整版视频——该网页仅仅提供了片花视频</p><p><br/></p><p>【反面case2】李小璐不雅视频引撞脸门2万抵3万拒绝“撞楼”——该网页主要介绍的是楼盘信息</p><p><br/></p><p>2，避免多网页使用同一个标题：原则上每个网页都应该有自己独特的标题，如果整个网站的标题全部一致，将失去向搜索引擎表达含义的重要机会。</p>','','','/images/1.jpg',1476453850,1476063980,'撰写,搜索引擎,喜欢,的,标题','','通过观察可以发现，那些可以从搜索引擎获得大批流量的站点来说，SEO思维渗透到了每个岗位，产品人员在提交项目MRD时，网页标题的写法是必不可少的一部分；编辑对文章内容负责的同时',0,0,0,50),(5,3,0,337,'Baiduspider主要抓取策略类型','<p>Baiduspider在抓取过程中面对的是一个超级复杂的网络环境，为了使系统可以抓取到尽可能多的有价值资源并保持系统及实际环境中页面的一致性同时不给网站体验造成压力，会设计多种复杂的抓取策略。以下做简单介绍：<br/></p><p><br/></p><p>1、抓取友好性</p><p><br/></p><p>互联网资源庞大的数量级，这就要求抓取系统尽可能的高效利用带宽，在有限的硬件和带宽资源下尽可能多的抓取到有价值资源。这就造成了另一个问题，耗费被抓网站的带宽造成访问压力，如果程度过大将直接影响被抓网站的正常用户访问行为。因此，在抓取过程中就要进行一定的抓取压力控制，达到既不影响网站的正常用户访问又能尽量多的抓取到有价值资源的目的。</p><p><br/></p><p>通常情况下，最基本的是基于ip的压力控制。这是因为如果基于域名，可能存在一个域名对多个ip（很多大网站）或多个域名对应同一个ip（小网站共享ip）的问题。实际中，往往根据ip及域名的多种条件进行压力调配控制。同时，站长平台也推出了压力反馈工具，站长可以人工调配对自己网站的抓取压力，这时百度spider将优先按照站长的要求进行抓取压力控制。</p><p><br/></p><p>对同一个站点的抓取速度控制一般分为两类：其一，一段时间内的抓取频率；其二，一段时间内的抓取流量。同一站点不同的时间抓取速度也会不同，例如夜深人静月黑风高时候抓取的可能就会快一些，也视具体站点类型而定，主要思想是错开正常用户访问高峰，不断的调整。对于不同站点，也需要不同的抓取速度。</p><p><br/></p><p>2、常用抓取返回码示意</p><p><br/></p><p>简单介绍几种百度支持的返回码：</p><p><br/></p><p>1）最常见的404代表“NOTFOUND”，认为网页已经失效，通常将在库中删除，同时短期内如果spider再次发现这条url也不会抓取；</p><p><br/></p><p>2）503代表“ServiceUnavailable”，认为网页临时不可访问，通常网站临时关闭，带宽有限等会产生这种情况。对于网页返回503状态码，百度spider不会把这条url直接删除，同时短期内将会反复访问几次，如果网页已恢复，则正常抓取；如果继续返回503，那么这条url仍会被认为是失效链接，从库中删除。</p><p><br/></p><p>3）403代表“Forbidden”，认为网页目前禁止访问。如果是新url，spider暂时不抓取，短期内同样会反复访问几次；如果是已收录url，不会直接删除，短期内同样反复访问几次。如果网页正常访问，则正常抓取；如果仍然禁止访问，那么这条url也会被认为是失效链接，从库中删除。</p><p><br/></p><p>4）301代表是“MovedPermanently”，认为网页重定向至新url。当遇到站点迁移、域名更换、站点改版的情况时，我们推荐使用301返回码，同时使用站长平台网站改版工具，以减少改版对网站流量造成的损失。</p><p><br/></p><p>3、多种url重定向的识别</p><p><br/></p><p>互联网中一部分网页因为各种各样的原因存在url重定向状态，为了对这部分资源正常抓取，就要求spider对url重定向进行识别判断，同时防止作弊行为。重定向可分为三类：http30x重定向、metarefresh重定向和js重定向。另外，百度也支持Canonical标签，在效果上可以认为也是一种间接的重定向。</p><p><br/></p><p>4、抓取优先级调配</p><p><br/></p><p>由于互联网资源规模的巨大以及迅速的变化，对于搜索引擎来说全部抓取到并合理的更新保持一致性几乎是不可能的事情，因此这就要求抓取系统设计一套合理的抓取优先级调配策略。主要包括：深度优先遍历策略、宽度优先遍历策略、pr优先策略、反链策略、社会化分享指导策略等等。每个策略各有优劣，在实际情况中往往是多种策略结合使用以达到最优的抓取效果。</p><p><br/></p><p>5、重复url的过滤</p><p><br/></p><p>spider在抓取过程中需要判断一个页面是否已经抓取过了，如果还没有抓取再进行抓取网页的行为并放在已抓取网址集合中。判断是否已经抓取其中涉及到最核心的是快速查找并对比，同时涉及到url归一化识别，例如一个url中包含大量无效参数而实际是同一个页面，这将视为同一个url来对待。</p><p><br/></p><p>6、暗网数据的获取</p><p><br/></p><p>互联网中存在着大量的搜索引擎暂时无法抓取到的数据，被称为暗网数据。一方面，很多网站的大量数据是存在于网络数据库中，spider难以采用抓取网页的方式获得完整内容；另一方面，由于网络环境、网站本身不符合规范、孤岛等等问题，也会造成搜索引擎无法抓取。目前来说，对于暗网数据的获取主要思路仍然是通过开放平台采用数据提交的方式来解决，例如“百度站长平台”“百度开放平台”等等。</p><p><br/></p><p>7、抓取反作弊</p><p><br/></p><p>spider在抓取过程中往往会遇到所谓抓取黑洞或者面临大量低质量页面的困扰，这就要求抓取系统中同样需要设计一套完善的抓取反作弊系统。例如分析url特征、分析页面大小及内容、分析站点规模对应抓取规模等等。</p>','','','',1476454079,1476064033,'Baiduspider,主要,抓取,策略,类型','','Baiduspider在抓取过程中面对的是一个超级复杂的网络环境，为了使系统可以抓取到尽可能多的有价值资源并保持系统及实际环境中页面的一致性同时不给网站体验造成压力，会设计多种复杂',0,0,0,50),(6,1,0,396,'百度移动搜索优化前期准备工作','<p><strong>域名：</strong><br/></p><p><br/></p><p>与PC网站一样，域名是用户对一个网站的第一印象。一个好的移动域名，不仅容易记忆、易于输入，还能方便用户向其他人推荐。</p><p><br/></p><p>域名应尽量简短易懂，越短的域名记忆成本越低，越容易理解的域名能让用户更直观了解网站主旨。移动站域名建议多采用m.a.com/3g.a.com/wap.a.com等，避免使用过于复杂或技术性的形式，例如adcbxxx.a.com/html5.a.com等。</p><p><br/></p><p><strong>服务器：</strong></p><p><br/></p><p>选择正规空间服务商，避免与大量垃圾网站共用IP，保证网站访问速度和稳定性。其他这里不再赘述，默认有PC网站基础。</p><p><br/></p><p><strong>网站语言：</strong></p><p><br/></p><p>根据终端以及技术的发展，我们强烈建议使用html5作为移动站建站语言，并且根据不同终端机型进行自动适配。</p>','','','',1476454177,1476064079,'百度,移动,搜索,优化,前期,准备工作','','域名：与PC网站一样，域名是用户对一个网站的第一印象。一个好的移动域名，不仅容易记忆、易于输入，还能方便用户向其他人推荐。域名应尽量简短易懂，越短的域名记忆成本越低，越',0,0,0,50),(7,4,0,225,'Baiduspider抓取过程中涉及的网络协议','<p>百度搜索引擎会设计复杂的抓取策略，其实搜索引擎与资源提供者之间存在相互依赖的关系，其中搜索引擎需要站长为其提供资源，否则搜索引擎就无法满足用户检索需求；而站长需要通过搜索引擎将自己的内容推广出去获取更多的受众。spider抓取系统直接涉及互联网资源提供者的利益，为了使搜素引擎与站长能够达到双赢，在抓取过程中双方必须遵守一定的规范，以便于双方的数据处理及对接。这种过程中遵守的规范也就是日常中我们所说的一些网络协议。<br/></p><p><br/></p><p>以下简单列举：</p><p><br/></p><p>http协议：超文本传输协议，是互联网上应用最为广泛的一种网络协议，客户端和服务器端请求和应答的标准。客户端一般情况是指终端用户，服务器端即指网站。终端用户通过浏览器、蜘蛛等向服务器指定端口发送http请求。发送http请求会返回对应的httpheader信息，可以看到包括是否成功、服务器类型、网页最近更新时间等内容。</p><p><br/></p><p>https协议：实际是加密版http，一种更加安全的数据传输协议。</p><p><br/></p><p>UA属性：UA即user-agent，是http协议中的一个属性，代表了终端的身份，向服务器端表明我是谁来干嘛，进而服务器端可以根据不同的身份来做出不同的反馈结果。</p><p><br/></p><p>robots协议：robots.txt是搜索引擎访问一个网站时要访问的第一个文件，用以来确定哪些是被允许抓取的哪些是被禁止抓取的。robots.txt必须放在网站根目录下，且文件名要小写。详细的robots.txt写法可参考http://www.robotstxt.org。百度严格按照robots协议执行，另外，同样支持网页内容中添加的名为robots的meta标签，index、follow、nofollow等指令。</p>','','','',1476454131,1476064125,'Baiduspider,抓取,过程中,涉及,的,网络,协议','','百度搜索引擎会设计复杂的抓取策略，其实搜索引擎与资源提供者之间存在相互依赖的关系，其中搜索引擎需要站长为其提供资源，否则搜索引擎就无法满足用户检索需求；而站长需要通过',0,0,0,50),(8,4,1,281,'如何在百度移动搜索获得良好的排序','<p>同PC端的需求一样，收录问题解决后面临的就是排序问题了。在介绍排序原则之前先简休介绍一下移动搜索结果的构成，移动搜索主要有如下几类结果构成：移动页面、转码页面、PC页面。<br/></p><p><br/></p><p>整体上，移动搜索的结果是由PC搜索结果加入更多的移动端特征后进一步调整而来，优先对移动页面进行排序。其中，移动页面结果包括移动适配提交的与PC一一对应的移动页以及单独的移动页面。百度移动搜索引擎中为更好满足用户信息需求，会同时为用户提供PC网页和mobile网页，但目前大多数PC页在移动终端中直接浏览的体验较差（交互、兼容和流量等）。因此，我们会对百度搜索结果中缺乏可替代mobile资源的PC页进行格式转换，变为适合手机浏览的mobile网页，使其能在移动终端浏览器有较好的浏览体验，这便是转码页面。其他PC页面，是百度经过各种策略识别发现其没有对应的移动页面资源、且转码后体验不佳的情况下保留的一种结果类型。对于后两者我们强烈建议站长进行移动化。</p><p><br/></p><p>下面我们主要来说说如何才能在百度移动搜索获得良好的排序：</p><p><br/></p><p>1，需要主旨明确的标题：</p><p><br/></p><p>网页的title用于告诉用户和搜索引擎这个网页的主题是什么，搜索引擎判断一个页面内容权重时，title是主要因素之一。每个页面的内容都是不同的，都应该有独一无二的title。移动站的标题应该注意如下：</p><p><br/></p><p>1）主题明确，涵盖页面主旨内容；</p><p><br/></p><p>2）不罗列关键词，使用户能够快速分辨出主题，最好不超过17个中文汉字，否则在搜索结果中会被折行，超过24个会被截断；</p><p><br/></p><p>3）重要内容往左放，保持语义通顺；</p><p><br/></p><p>4）使用用户熟知或习惯用语</p><p><br/></p><p>百度建议不同层级页面的标题按照如下的形式来命名：</p><p><br/></p><p>●首页标题：网站名称_核心服务or核心产品</p><p><br/></p><p>●频道页标题：（频道核心服务_）频道名称_网站名称</p><p><br/></p><p>●详情页标题：文章标题_频道名称_网站名称</p><p><br/></p><p>2，优质的原创内容建设、整合系列服务：</p><p><br/></p><p>网站的服务对象是用户，搜索引擎只是网站普通用户中的一员，因此，一切从用户角度出发提供用户需要的原创内容、整合系列服务非常重要，每天保持一定数量的原创内容更新，同时可以对优质内容、系列服务进行整合形成专题。但是，鉴于技术的现状，仍然要注意如下几点：</p><p><br/></p><p>1）不要使用ajax技术在希望搜索引擎可读的地方；</p><p><br/></p><p>2）不将主要内容创建在iframe框架中；</p><p><br/></p><p>3）移动端很多内容使用图片，搜索引擎目前无法理解复杂图片，请使用alt标签进行标记；</p><p><br/></p><p>3，做好终端适配：</p><p><br/></p><p>随着移动互联网的发展，越来越多的用户使用移动设备访问网站，百度移动搜索会对移动站给予优先排序的机会，对于有PC网站的站长，我们强烈建议您做以下工作：</p><p><br/></p><p>1、做好自适配，将移动终端的访问自主适配跳转至移动版站点；</p><p><br/></p><p>2、为了更快地告知百度移动搜索您PC网站与移动站内容的一一对应关系，建议使用站长平台移动适配工具进行适配关系提交。</p><p><br/></p><p>3、同时还可以使用如下Meta标签协议规范：</p><p><br/></p><p>●如果该网页只适合在电脑上进行浏览，例如（http://www.sina.com.cn/），在html中加入如下meta：</p><p><br/></p><p>&lt;meta name=&quot;applicable-device&quot; content=&quot;pc&quot;&gt;</p><p><br/></p><p>●如果该网页只适合在移动设备上进行浏览，例如（http://3g.sina.com.cn/），在html中加入如下meta：</p><p><br/></p><p>&lt;meta name=&quot;applicable-device&quot; content=&quot;mobile&quot;&gt;</p><p><br/></p><p>●如果网页采用了响应式网页设计，例如（http://cdc.tencent.com/）不需要经过url自适配跳转就可以根据浏览器的屏幕大小自适应的展现合适的效果，同时适合在移动设备和电脑上进行浏览，在html中加入如下meta：</p><p><br/></p><p>&lt;meta name=&quot;applicable-device&quot; content=&quot;pc,mobile&quot;&gt;</p><p><br/></p><p>4，地理信息标注有助于获得更精准的流量：</p><p><br/></p><p>为了方便用户根据自身位置查找或使用本地信息与服务，百度移动搜索将根据用户地理位置信息优先将具有地域属性的内容展现给用户，如果是提供地域性信息服务的站点，可以通过为自己网页添加地理位置信息Meta标注，让目标用户在百度移动搜索中更快的找到您网站的内容。具体用法可见下一小节《如何为移动站点添加地理位置信息》</p><p><br/></p><p>5，尽量快的加载速度：</p><p><br/></p><p>移动互联网上，网站的打开速度对用户体验的影响更加凸显。实验表明一个页面的打开时间超过4~5s，绝大部分用户选择关闭。因此，加载速度也是百度移动搜索中一个重要的排序因素，站长需要在这方面进行专项优化。</p><p><br/></p><p>6，搜索结果转码：</p><p><br/></p><p>在移动终端中直接浏览PC页面体验较差（交互、兼容和流量等）。为改善搜索用户的浏览体验，我们会对搜索结果中缺乏可替代移动资源的PC页（无移动站）进行格式转换，变为适合手机浏览的移动网页。如想了解更多可参考：转码声明。我们强烈建议没有移动化的站长进行网站移动化，提交移动适配，将转码流量领回家。</p>','','','',1476454326,1476064196,'如,何在,百度,移动,搜索,获得,良,好的,排序','','同PC端的需求一样，收录问题解决后面临的就是排序问题了。在介绍排序原则之前先简休介绍一下移动搜索结果的构成，移动搜索主要有如下几类结果构成：移动页面、转码页面、PC页面。整',0,0,0,50),(9,2,3,404,'网页优化的大忌','<p>网页进行正常优化，有助于搜索引擎更好地了解网页主体内容，而网页优化同样是一柄双刃剑，搞不好会造成费力不讨好、甚至被搜索引擎惩罚的后果。在百度看来，网页优化的大忌有三点：<br/></p><p><br/></p><p>1，关键词过度堆彻：有些站点为了提高网站的相关性，在TITLE、description、keywords等地方进行关键词堆彻，非旦无法起到优化作用，还有可能被惩罚。</p><p><br/></p><p>*隐藏关键词我们就不用说了，完全是黑帽SEO的范畴，已不在优化之列。</p><p><br/></p><p>2，关键词过度优化：一些网页过度强调文章中的关键词，甚至将关键词生硬地穿插在文章中，这些都极容易被搜索引擎识别并惩罚。</p><p><br/></p><p>3，经常改变网页的TITLE和Description：每一次更换网页的TITLE和Description等标签，都有一个百度发现解析记录的过程，没有一个准确的时间段可以描述，如果这个过程时间很短可能不会造成恶劣影响，但如果时间较长，则有可能影响搜索用户的体验。所以说，网页的各种标签应该在网站建设阶段设计好。</p>','','','/images/2.jpg',1476453839,1476064241,'网页,优化,的,大忌','','网页进行正常优化，有助于搜索引擎更好地了解网页主体内容，而网页优化同样是一柄双刃剑，搞不好会造成费力不讨好、甚至被搜索引擎惩罚的后果。在百度看来，网页优化的大忌有三点',0,0,0,50),(10,3,0,394,'百度优先建重要库的原则','<p>Baiduspider抓了多少页面并不是最重要的，重要的是有多少页面被建索引库，即我们常说的“建库”。众所周知，搜索引擎的索引库是分层级的，优质的网页会被分配到重要索引库，普通网页会待在普通库，再差一些的网页会被分配到低级库去当补充材料。目前60%的检索需求只调用重要索引库即可满足，这也就解释了为什么有些网站的收录量超高流量却一直不理想。<br/></p><p><br/></p><p>那么，哪些网页可以进入优质索引库呢。其实总的原则就是一个：对用户的价值。包括却不仅于：</p><p><br/></p><p>1，有时效性且有价值的页面：在这里，时效性和价值是并列关系，缺一不可。有些站点为了产生时效性内容页面做了大量采集工作，产生了一堆无价值面页，也是百度不愿看到的.</p><p><br/></p><p>2，内容优质的专题页面：专题页面的内容不一定完全是原创的，即可以很好地把各方内容整合在一起，或者增加一些新鲜的内容，比如观点和评论，给用户更丰富全面的内容。</p><p><br/></p><p>3，高价值原创内容页面：百度把原创定义为花费一定成本、大量经验积累提取后形成的文章。千万不要再问我们伪原创是不是原创。</p><p><br/></p><p>4，重要个人页面：这里仅举一个例子，科比在新浪微博开户了，即使他不经常更新，但对于百度来说，它仍然是一个极重要的页面。</p>','','','',1476454498,1476064284,'百度,优先,建,重要,库,的,原则','','Baiduspider抓了多少页面并不是最重要的，重要的是有多少页面被建索引库，即我们常说的“建库”。众所周知，搜索引擎的索引库是分层级的，优质的网页会被分配到重要索引库，普通网页',0,0,0,50),(11,3,0,486,'禁止百度移动搜索对网页进行转码的方法','<p>在百度移动搜索引擎中，为了更好地满足用户需求，会同时为用户提供PC网页和mobile网页，但目前受交互、兼容和流量等因素影响，PC页在移动终端中的直接浏览体验较差。因此，百度移动搜索对缺乏可替代mobile资源的PC页进行格式转码，将其转换为适合手机浏览的mobile页，使其能够在移动终端浏览器有较好的浏览体验。为了最大程度改善PC页在手机上的浏览体验，转码时会去除PC页中不能在手机浏览器上浏览的内容，并改善不适用mobile的交互功能。目前不仅百度移动搜索提供转码技术，各大搜索引擎均有并提供类似的技术。<br/></p><p><br/></p><p>那么，如果站长不希望自己的站点被转码、依然希望手机端用户浏览PC页该如何操作呢？可以使用no-transform协议，no-transform协议为如下两种形式：</p><p><br/></p><p>第一种，HTTPResponse中显式声明Cache-control为no-transform。</p><p><br/></p><p>第二种，meta标签中显式声明Cache-control为no-tranform，格式为：</p><p><br/></p><p>&lt;head&gt;</p><p><br/></p><p>&lt;meta http-equiv=&quot;Cache-Control&quot; content=&quot;no-transform&quot;/&gt;</p><p><br/></p><p>&lt;/head&gt;</p><p><br/></p><p>如果站点不希望页面被转码，可添加此协议，当用户通过百度移动搜索进入该网站时会进入原网页浏览。</p><p><br/></p><p>还有一种情况，即站点本身有对应的mobile页面所以不希望被转码时，建议站长使用百度移动搜索的移动适配服务，百度会帮助用户直接进入对应的mobile页面。</p>','','','',1476454369,1476064353,'禁止,百度,移动,搜索,对,网页,进行,转,码,的,方法','','在百度移动搜索引擎中，为了更好地满足用户需求，会同时为用户提供PC网页和mobile网页，但目前受交互、兼容和流量等因素影响，PC页在移动终端中的直接浏览体验较差。因此，百度移动搜',0,0,0,50),(12,4,0,384,'网站内容创作的大忌','<p>网站制作内容是一件持续性投入的工作，在人力、技术、财力上都需要较大投入，一些站点急于求成寻找捷径，制作了很多垃圾内容，最终被搜索引擎惩罚，可谓得不偿失。希望站长抛弃以下行为，从《百度网页搜索质量白皮书》中寻找答案。<br/></p><p><br/></p><p>1，站内大量重复内容：很多网站，尤其是商业网站，往往使用同一个模板，不同网页的主体内容高度相似或相同，仅一些TITLE等标签进行了改变。比如一些招投标网站，为了让更多的地区得到投标内容，他们制作了大量页面，标题采用地区+内容的方式，而页面的主体内容都是完全相同的。再如下图，同样仅标题和图片不同，主体内容相对，对于百度搜索引擎来说，都属于站内大量重复内容。</p><p><br/></p><p>2，利用与站点无关的热词引流：有些网站，尤其是新闻源站点紧盯百度的时效性热词，与自己网站文章的标题进行整合，其实就是我们常说的标题党，如“李娜退役隐情体育明星豪宅全揭秘”，用户点击后自然看不到关于李娜退役隐情的内容。此种行为一经发现，网站会被取消新闻源资格，即使内容真的是原创，也会因此行为遭受牵连。</p><p><br/></p><p>3，制作低质静态搜索结果页或TAG标签页：很多网站都采用了将站内搜索结果页转为静态页面的方式，整合站点资源，以期形成相关性得分高的页面。但实际来看，很多站点通过站内搜索或者tag生成的页面相关性并不好，或者说产生了许多对百度搜索结果造成负面影响的页面。如果整个目录都存在这样的现象，那么被惩罚的可能性就非常大了。如下方截图，用户搜“列车时刻表”，这样的页面对他来说毫无价值。该页面所在的目录或站点做了很多类似内容的页面，且已经对作用造成恶劣影响时，极容易受到搜索引擎的惩罚。</p><p><br/></p><p>4，不负责任的采集：首先需要澄清的是，百度说的拒绝采集，指的是大量复制互联网上已有内容，对采集的内容不加整理即全部推至线上的“偷懒”行为。对于将采集来的内容进行再加工高效整合后，产出内容丰富的高质量网页，百度没有拒绝理由。所以，我们说，百度不喜欢不负责任的偷懒采集行为。</p><p><br/></p><p>5，伪原创：上面我们说百度不喜欢不负责任的采集，于是有些人开始动起了伪装原创的脑筋。采集内容后对部分关键词进行批量修改，企图让百度认为这些都是独特内容，然而内容已经是面目全非，甚至无法读通——这也是百度不喜欢的，风险很大。还是刚才说的观点，百度不排斥站点采集内容，关键是如何应用采集的内容和数据，如何整合成用户和搜索引擎都需要的内容才是站长应该考虑的内容。</p>','','','',1483178699,1476454002,'网站,内容,创作,的,大忌','','网站制作内容是一件持续性投入的工作，在人力、技术、财力上都需要较大投入，一些站点急于求成寻找捷径，制作了很多垃圾内容，最终被搜索引擎惩罚，可谓得不偿失。希望站长抛弃以',1,0,1,50),(13,3,0,461,'获得流量的基础——良好收录','<p>搜索引擎作为网站的普通访客，对网站的抓取索引、对站点/页面的价值判定以及排序，都是从用户体验出发。因此，原则上网站任何对用户体验的改进，都是对搜索引擎的改进。但是限于当前整体的网络环境以及技术性原因，落实用户体验的具体手段也是需要考虑对搜索引擎友好性的，使之在满足用户体验的前提下也会让搜索引擎更易理解处理。那么，面向移动搜索引擎的网站建设，主要分为三个部分：如何更好的让百度移动搜索收录网站中的内容、如何在移动搜索中获得更好的排名、如何让用户从众多的搜索结果中快速地找到并点击你的网站。简单来说，就是收录、排序、展现。下面我们将从收录开始介绍：<br/></p><p><br/></p><p><strong>机器可读：</strong></p><p><br/></p><p>与PCspider一样，百度通过一个叫Baiduspider2.0的程序抓取移动互联网上的网页，经过处理后建入移动索引中。当前Baiduspider只能读懂文本内容，flash、图片等非文本内容暂时不能很好处理，放置在flash、图片中的文字，百度只能简单识别。建议使用文本而不是flash、图片、Javascript等来显示重要的内容或链接，搜索引擎暂时无法识别Flash、图片、复杂Javascript中的内容；同时仅存在于flash、Javascript中包含链接指向的网页，百度移动搜索同样可能无法收录。不要在希望搜索引擎可读的地方使用Ajax技术，比如标题、导航、内容等等。</p><p><br/></p><p><strong>结构扁平：</strong></p><p><br/></p><p>移动站点同样应该有清晰的结构以及更浅的链接深度，这能够使用户快速地获取有用信息，也能使搜索引擎快速理解网站中的每一个页面所处的结构层次。网站结构建议采用树型结构，树型结构通常分为以下三个层级：首页——频道——详情页。</p><p><br/></p><p><strong>网状链接：</strong></p><p><br/></p><p>理想的网站结构是树型扁平，从首页到内容页的层级尽量少，这样更有利于搜索引擎进行处理。同时，网站内的链接也应该采用网状结构，网站上每个网页都要有指向上、下级网页以及相关内容的链接，避免出现链接孤岛：首页有到频道页的链接，频道页有到首页和普通内容页的链接、普通内容页有到上级频道以及首页的链接、内容相关的网页间互相有链接。网站中每一个网页，都应该是网站结构的一部分，都应该能通过其他网页链接到，这样才能使baiduspider尽可能全地遍历网站内容。同时，重要内容应该距离首页更近，有利于价值传递。</p><p><br/></p><p><strong>简单易懂的URL：</strong></p><p><br/></p><p>具有良好描述性、规范、简单的URL，有利于用户更方便地记忆和直观判断网页内容，也有利于搜索引擎更有效地抓取和理解网页。网站设计之初，就应该有合理的URL规划。我们认为：</p><p><br/></p><p>1、对于移动站首页一般采用m.a.com/3g.a.com/wap.a.com；</p><p><br/></p><p>2、频道页采用m.a.com/n1/、m.a.com/n2/（其对应于PC站点的频道n2.a.com），当然，n1、n2直接可读更佳；</p><p><br/></p><p>3、详情页的URL尽量短，减少无效参数，例如统计参数等，保证同一页面只有一套URL地址，不同形式的URL301跳转到正常URL上；</p><p><br/></p><p>4、Robots封禁baiduspider抓取您不想展示给用户的URL形式以及不愿被百度抓取的私密数据。</p><p><br/></p><p><strong>涵盖主旨的anchor：</strong></p><p><br/></p><p>anchor即锚文本，对一个链接的描述性文字，锚文本写得越简洁明确，用户越易明白该指向网页的主旨内容。用户发现你的网页是从其他网页上的链接，锚文本是该网页的唯一介绍。跟普通用户相同，搜索引擎spider在刚发现一个网页时，锚文本也是对该页面理解的唯一因素，同时对于最终的排序起到具有一定的作用。</p><p><br/></p><p><strong>合理的返回码：</strong></p><p><br/></p><p>百度spider在进行抓取和处理时，是根据http协议规范来设置相应逻辑的，常用的几个返回码如下：</p><p><br/></p><p>404，百度会认为网页已失效已删除，通常在索引中删除，短期内spider再次遇到也不会抓取。建议内容删除、网页失效等的情况下使用404返回码，告知百度spider该页面已失效。同时网站中尽量减少死链的累计。如果网站临时关闭或抓取压力过大，不要直接返回404，使用503。</p><p><br/></p><p>301，永久性重定向，百度会认为当前URL永久跳转至新URL。当网站改版、更换域名等情况下，建议使用301，同时配合使用站长平台的网站改版工具。</p><p><br/></p><p>503，百度会认为临时不可访问，不会直接删除，短期内再来检查几次。如果网站临时性关闭建议使用503。</p>','','','',1476454233,1476064847,'获得,流量,的,基础,—,—,良好,收录','','搜索引擎作为网站的普通访客，对网站的抓取索引、对站点/页面的价值判定以及排序，都是从用户体验出发。因此，原则上网站任何对用户体验的改进，都是对搜索引擎的改进。但是限于当',0,0,0,50),(14,4,0,330,'知名站点优化注意事项','<p>百度需要优质站点为搜索引擎数据库源源不断地输入物料，同时优质站点也需要从百度获得搜索引擎用户，并将这些搜索引擎用户转化为自己的用户。知名站点可以视为优质站点的一部分，是指已经有较高用户知名度的网站。那么，站点越是知名，就越应从长远考虑，以用户体验为重，积极、合理的进行网站优化，远离作弊和恶意SEO行为，建立与百度更加稳固的合作关系。<br/></p><p><br/></p><p>但我们经常可以遗憾地看到一些知名站点使用了不够合理的内容建设方式，比如：大量不同内容的页面均使用同一标题；通过图片的方式展现网页中的重要信息（新闻、联系电话等）；重要页面通过flash建设，未使用文字说明等。</p><p><br/></p><p>类似的方式，都会使搜索引擎对网站内容的理解造成困难，最终影响网站在搜索引擎中的表现。我们建议您采取对搜索引擎友好的方式进行网站建设，具体内容可参考《百度搜索引擎优化指南》以及《百度搜索引擎网页质量白皮书》。</p><p><br/></p><p>知名站点对搜索引擎，乃至整个互联网欢迎的影响通常是巨大的，若使用恶意的作弊行为，其产生的影响也就越坏。例如：</p><p><br/></p><p>●出售首页的友情链接。</p><p><br/></p><p>●大量采集其他网站的内容，原创内容比例极低，甚至大量采集网站主题无关的内容，或机器批量生成没有价值的页面。</p><p><br/></p><p>●网站被大量广告内容占领。</p><p><br/></p><p>知名站点一旦有恶意的作弊行为，所产生的恶劣影响将是巨大的，有可能会受到搜索引擎更为严格的惩罚。知名站点更应从长远考虑，提升用户口碑，用高质量的内容赢得用户青睐。不应为了短期的流量，不顾用户的体验，做有损品牌形象的事情。</p><p><br/></p><p>此外，知名站点也是各路作弊者的“众矢之的”，容易被恶意利用。站点越知名，被利用的价值就越大。我们建议您建立防范意识，避免由于被作弊者利用引起的不必要风险。</p><p><br/></p><p>●您的站点是否足够安全？当网站被黑客攻击时，是否有足够的应对机制？</p><p><br/></p><p>●由用户贡献内容的功能，是否做好了应对作弊的措施？</p><p><br/></p><p>●对于不想让搜索引擎收录的内容，是否在robot.txt中清晰指明？</p>','百度站长','','',1483178708,1476453609,'知名,站点,优化,注意事项','','百度需要优质站点为搜索引擎数据库源源不断地输入物料，同时优质站点也需要从百度获得搜索引擎用户，并将这些搜索引擎用户转化为自己的用户。知名站点可以视为优质站点的一部分，',0,0,1,50),(15,3,0,427,'获得关键词数据的渠道有哪些','<p>上面说到了站点收集关键词的方向，那么通过什么渠道可以获取关键词数据呢。关键词收集也可以叫关键词拓展，其实就是思路的拓展。这个思路在工作岗位中的表现不同：产品运营的角度，可能是个不断深挖行业用户需求、了解需求、站在用户角度想问题设计产品；而从搜索营销、seo角度它则成为深挖行业用户需求的具体体现。那么获取关键词数据的主要渠道有哪些呢：<br/></p><p><br/></p><p>1，公开渠道：</p><p><br/></p><p>1）几家搜索引擎搜索结果相关搜索、SUG</p><p><br/></p><p>2）几家大的社交、媒体（微博）的相关搜索</p><p><br/></p><p>3）各搜索引擎的风云榜</p><p><br/></p><p>4）竞价关键词获取工具（搜索引擎一般都提供）</p><p><br/></p><p>5）百度司南工具</p><p><br/></p><p>6）cnzz数据中心（http://data.cnzz.com/）；</p><p><br/></p><p>2，通过站内工具：</p><p><br/></p><p>1）Log日志关键词数据；</p><p><br/></p><p>2）站内搜索关键词数据；</p><p><br/></p><p>3）商务通、商桥等在线咨询工具内的关键词；</p><p><br/></p><p>3，观察竞争对手：</p><p><br/></p><p>1）竞争对手网站上的tag页；</p><p><br/></p><p>2）竞争对手（尤其是对seo很重视的）站点title；</p><p><br/></p><p>3）竞争对手竞价关键词；</p><p><br/></p><p>4）竞争对手页面keyword；</p><p><br/></p><p>4，购买：</p><p><br/></p><p>1）寻找数据公司、工具服务商，购买数据</p><p><br/></p><p>5，常识拓展：</p><p><br/></p><p>1）问答类（百度知道、知乎）相关问题的提问挖掘</p><p><br/></p><p>2）内容评论中的需求挖掘，主题下的评论一定是跟这个主题紧密相关的关注点、bbs评论</p><p><br/></p><p>3）通过了解行业用户组合关键词，如：地区+关键词</p><p><br/></p><p>最后，就像大家知道的那样，即便这项工作真的很重要，但在如今碎片需求满足程度和信息内容大爆发的情况下，关注关键词背后的深层需求的分析、内容的差异提供、需求针对的产品细化，比不停的扩大关键词量要更重要的多。</p>','','','',1522304646,1476453964,'获得,关键词,数据,的,渠道,有,哪些','','上面说到了站点收集关键词的方向，那么通过什么渠道可以获取关键词数据呢。关键词收集也可以叫关键词拓展，其实就是思路的拓展。这个思路在工作岗位中的表现不同：产品运营的角度',0,0,1,50);

/*Table structure for table `fl_attachment` */

DROP TABLE IF EXISTS `fl_attachment`;

CREATE TABLE `fl_attachment` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '上传用户ID',
  `storage_type` tinyint(11) unsigned NOT NULL DEFAULT '2' COMMENT '附件存储类型: 0.本地自有服务器存储, 1.普通外部URL链接, 2.阿里云OSS云存储',
  `file_key` varchar(256) NOT NULL DEFAULT '' COMMENT '存储平台的key值',
  `file_url` varchar(256) NOT NULL DEFAULT '' COMMENT '文件Url访问地址',
  `filesize` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '文件大小, 以KB记',
  `ip` varchar(20) NOT NULL DEFAULT '' COMMENT '文件上传IP地址',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  `updated_at` timestamp NULL DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`),
  KEY `file_url` (`file_url`(255)),
  KEY `admin_id` (`user_id`),
  KEY `storage_type` (`storage_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `fl_attachment` */

/*Table structure for table `fl_bonus` */

DROP TABLE IF EXISTS `fl_bonus`;

CREATE TABLE `fl_bonus` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '优惠券就是红包',
  `name` varchar(60) NOT NULL DEFAULT '' COMMENT '名称',
  `money` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '金额',
  `min_amount` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '满多少使用',
  `start_time` datetime NOT NULL COMMENT '开始时间',
  `end_time` datetime NOT NULL COMMENT '结束时间',
  `point` int(5) unsigned NOT NULL DEFAULT '0' COMMENT '兑换优惠券所需积分,如果是0表示禁止兑换',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态：0可用，1不可用',
  `add_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `num` int(11) NOT NULL DEFAULT '-1' COMMENT '优惠券数量，预留，-1表示不限',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='优惠券表';

/*Data for the table `fl_bonus` */

insert  into `fl_bonus`(`id`,`name`,`money`,`min_amount`,`start_time`,`end_time`,`point`,`status`,`add_time`,`num`) values (1,'用户红包','12.00','11.00','2010-10-10 00:00:00','2018-10-10 00:00:00',0,1,0,10),(2,'商品红包','10.00','2.00','2010-10-10 00:00:00','2018-10-10 00:00:00',0,0,0,1),(3,'订单红包','20.00','1500.00','2010-10-10 00:00:00','2018-10-10 00:00:00',0,0,0,2),(4,'线下红包','5.00','4.00','2010-10-10 00:00:00','2018-10-10 00:00:00',0,0,0,4);

/*Table structure for table `fl_cart` */

DROP TABLE IF EXISTS `fl_cart`;

CREATE TABLE `fl_cart` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `goods_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '商品id',
  `shop_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '商品所属的商店id，预留',
  `goods_number` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '商品数量',
  `goods_attr` text COMMENT '商品属性',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '购物车商品类型;0普通;1团够;2拍卖;3夺宝奇兵',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='购物车表';

/*Data for the table `fl_cart` */

insert  into `fl_cart`(`id`,`user_id`,`goods_id`,`shop_id`,`goods_number`,`goods_attr`,`type`,`add_time`) values (9,3,2,0,1,'',0,1520569330);

/*Table structure for table `fl_collect_goods` */

DROP TABLE IF EXISTS `fl_collect_goods`;

CREATE TABLE `fl_collect_goods` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '该条收藏记录的会员id，取值于users的user_id',
  `goods_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '收藏的商品id，取值于goods的goods_id',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '收藏时间',
  `is_attention` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否关注该收藏商品;1是;0否',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `goods_id` (`goods_id`),
  KEY `is_attention` (`is_attention`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='商品/文章收藏表';

/*Data for the table `fl_collect_goods` */

insert  into `fl_collect_goods`(`id`,`user_id`,`goods_id`,`add_time`,`is_attention`) values (1,1,1,1,0),(6,5,3,1509102460,0),(9,5,4,1509380131,0),(11,3,1,1512660255,0),(12,3,4,1513612675,0);

/*Table structure for table `fl_comment` */

DROP TABLE IF EXISTS `fl_comment`;

CREATE TABLE `fl_comment` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `comment_type` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '用户评论的类型;0评论的是商品,1评论的是文章',
  `id_value` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '文章或者商品的id,文章对应的是article的article_id;商品对应的是goods的goods_id',
  `content` text COMMENT '评论的内容',
  `comment_rank` tinyint(1) unsigned NOT NULL DEFAULT '5' COMMENT '该文章或者商品的重星级;只有1到5星;由数字代替;其中5代表5星',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '评论的时间',
  `ip_address` varchar(20) NOT NULL DEFAULT '' COMMENT '评论时的用户IP',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否被管理员批准显示;1是;0未批准显示',
  `parent_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '评论的父节点,取值该表的comment_id字段,如果该字段为0,则是一个普通评论,否则该条评论就是该字段的值所对应的评论的回复',
  `user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '发表该评论的用户的用户id,取值user的user_id',
  `is_anonymous` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否匿名，0否',
  PRIMARY KEY (`id`),
  KEY `idx_comment_type_user_id` (`comment_type`,`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='商品/文章评论表';

/*Data for the table `fl_comment` */

insert  into `fl_comment`(`id`,`comment_type`,`id_value`,`content`,`comment_rank`,`add_time`,`ip_address`,`status`,`parent_id`,`user_id`,`is_anonymous`) values (4,0,60,'商品非常好用，超级喜欢',5,1462949841,'180.169.8.10',1,0,1,0),(5,0,59,'非常喜欢此商品，感觉太棒了',5,1462949877,'180.169.8.10',0,0,1,0),(6,0,59,'样子非常不错，超级喜欢',5,1462949929,'180.169.8.10',0,0,1,0),(9,0,10,'qw22e',3,1502381975,'127.0.0.1',1,0,1,0),(21,0,3,'dfhgds',5,1513057776,'127.0.0.1',1,0,3,1),(22,0,4,'sfgsdg',5,1513057776,'127.0.0.1',1,0,3,1);

/*Table structure for table `fl_feedback` */

DROP TABLE IF EXISTS `fl_feedback`;

CREATE TABLE `fl_feedback` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `content` text COMMENT '意见反馈内容',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `title` varchar(150) NOT NULL DEFAULT '' COMMENT '标题，选填',
  `mobile` varchar(20) NOT NULL DEFAULT '' COMMENT '手机号码，选填',
  `type` varchar(20) NOT NULL DEFAULT '' COMMENT '意见反馈类型，选填',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

/*Data for the table `fl_feedback` */

insert  into `fl_feedback`(`id`,`content`,`add_time`,`user_id`,`title`,`mobile`,`type`) values (1,'发过火对光反射',4294967295,127,'','',''),(3,'content六角恐龙',4294967295,1,'title螺丝款计划','',''),(4,'asfa',4294967295,3,'','',''),(5,'sdgsd',4294967295,3,'','15280719685','积分/优惠券'),(6,'dgsg',4294967295,3,'','','购物流程');

/*Table structure for table `fl_friendlink` */

DROP TABLE IF EXISTS `fl_friendlink`;

CREATE TABLE `fl_friendlink` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `webname` varchar(60) NOT NULL DEFAULT '' COMMENT '友情链接名称',
  `url` varchar(100) NOT NULL DEFAULT '' COMMENT '友情链接url',
  `group_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '分组id',
  `listorder` int(5) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='友情链接表';

/*Data for the table `fl_friendlink` */

insert  into `fl_friendlink`(`id`,`webname`,`url`,`group_id`,`listorder`) values (1,'股票知识','http://www.1104.org/',0,0),(2,'炒股入门知识','http://www.pe7.org/',0,0);

/*Table structure for table `fl_goods` */

DROP TABLE IF EXISTS `fl_goods`;

CREATE TABLE `fl_goods` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `typeid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '栏目id',
  `tuijian` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '推荐等级',
  `click` int(8) unsigned NOT NULL DEFAULT '0' COMMENT '点击量',
  `title` varchar(150) NOT NULL DEFAULT '' COMMENT '标题',
  `body` mediumtext COMMENT '内容',
  `sn` varchar(60) NOT NULL DEFAULT '' COMMENT '货号',
  `price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '产品价格',
  `litpic` varchar(100) NOT NULL DEFAULT '' COMMENT '缩略图',
  `pubdate` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `keywords` varchar(60) NOT NULL DEFAULT '' COMMENT '关键词',
  `seotitle` varchar(150) NOT NULL DEFAULT '' COMMENT 'seo标题',
  `description` varchar(240) NOT NULL DEFAULT '' COMMENT '描述',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '商品状态 0正常 1已删除 2下架 3申请上架',
  `shipping_fee` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '运费',
  `market_price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '原价',
  `goods_number` int(5) unsigned NOT NULL DEFAULT '0' COMMENT '库存',
  `user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '谁发布的',
  `sale` int(8) unsigned NOT NULL DEFAULT '0' COMMENT '销量',
  `cost_price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '成本价格',
  `goods_weight` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '重量',
  `point` int(6) unsigned NOT NULL DEFAULT '0' COMMENT '购买该商品时每笔成功交易赠送的积分数量',
  `comments` int(8) unsigned NOT NULL DEFAULT '0' COMMENT '评论次数',
  `promote_start_date` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '促销价格开始日期',
  `promote_price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '促销价格',
  `promote_end_date` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '促销价格结束日期',
  `goods_img` varchar(250) NOT NULL DEFAULT '' COMMENT '商品的实际大小图片，如进入该商品页时介绍商品属性所显示的大图片',
  `warn_number` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '商品报警数量',
  `spec` mediumtext COMMENT '商品规格，json',
  `listorder` int(5) unsigned NOT NULL DEFAULT '50' COMMENT '排序',
  `brand_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '商品品牌',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_uqe_sn` (`sn`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='商品表';

/*Data for the table `fl_goods` */

insert  into `fl_goods`(`id`,`typeid`,`tuijian`,`click`,`title`,`body`,`sn`,`price`,`litpic`,`pubdate`,`add_time`,`keywords`,`seotitle`,`description`,`status`,`shipping_fee`,`market_price`,`goods_number`,`user_id`,`sale`,`cost_price`,`goods_weight`,`point`,`comments`,`promote_start_date`,`promote_price`,`promote_end_date`,`goods_img`,`warn_number`,`spec`,`listorder`,`brand_id`) values (1,2,1,5701,'示例产品一','<p>是的发生</p>','sn123456','45000.00','/uploads/2018/04/1.jpg',1512273964,1496577749,'示例,产品,一','','是的发生',0,'0.00','50000.00',99,1,123,'0.00','0.00',0,0,0,'0.00',0,'/uploads/2017/06/201706041951031181.jpg',0,'',50,0),(2,1,1,38,'示例产品二','说的是','sn987','1.00','/uploads/2018/04/2.jpg',1496578330,1496578313,'产品,示例,二','','',0,'3.00','2.00',106,1,67,'0.00','0.00',0,0,0,'0.00',0,'/uploads/2017/06/201706042011354141.jpg',0,'',50,0),(3,1,0,39,'示例产品三','是的发生','sn232143','5.10','/uploads/2018/04/3.jpg',1496578380,1496578380,'示例,产品,三','','',0,'3.00','4.00',103,1,99,'0.00','0.00',0,0,0,'0.00',0,'/uploads/2017/06/201706042012428057.jpg',0,'',50,1),(4,1,0,116,'示例产品四','<p>电热熔</p>','sn9809702','5.00','/uploads/2018/04/4.jpg',1519736409,1496578429,'示例,产品,四','','电热熔',0,'3.00','6.00',91,1,345,'0.00','0.00',0,0,1518435963,'2.00',1519905139,'/uploads/2017/06/201706042013331349.jpg',0,'',50,0),(5,1,0,13,'示例产品五','就回家好看','kjkhk3','989.00','/uploads/2018/04/5.jpg',1522849406,1522849066,'示例,产品,五','','',0,'898.00','98.00',8989,1,1234,'0.00','0.00',0,0,1523281235,'909.00',1524750039,'',1,'',50,0);

/*Table structure for table `fl_goods_brand` */

DROP TABLE IF EXISTS `fl_goods_brand`;

CREATE TABLE `fl_goods_brand` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '父级id',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `title` varchar(150) NOT NULL DEFAULT '' COMMENT '名称',
  `seotitle` varchar(150) NOT NULL DEFAULT '' COMMENT 'seo标题',
  `keywords` varchar(60) NOT NULL DEFAULT '' COMMENT '关键词',
  `description` varchar(240) NOT NULL DEFAULT '' COMMENT '描述',
  `content` text COMMENT '内容',
  `litpic` varchar(100) NOT NULL DEFAULT '' COMMENT '缩略图',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否显示，0显示',
  `listorder` int(5) unsigned NOT NULL DEFAULT '50' COMMENT '排序',
  `cover_img` varchar(100) NOT NULL DEFAULT '' COMMENT '封面',
  `click` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '点击量',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='商品品牌表';

/*Data for the table `fl_goods_brand` */

insert  into `fl_goods_brand`(`id`,`pid`,`add_time`,`title`,`seotitle`,`keywords`,`description`,`content`,`litpic`,`status`,`listorder`,`cover_img`,`click`) values (1,0,1496576972,'书籍','','','','<p>书籍</p>','/uploads/2017/12/1472434992773488209.jpg',0,50,'',0),(2,0,1496576993,'数码','','','','','/uploads/2017/12/1472434939893485963.jpg',1,50,'',0),(3,0,1500994389,'qq2','qq','qq','','<p>qq2</p>','/uploads/2017/12/1472435142739815095.jpg',0,2,'/uploads/2017/12/201712030021046553.jpg',2);

/*Table structure for table `fl_goods_img` */

DROP TABLE IF EXISTS `fl_goods_img`;

CREATE TABLE `fl_goods_img` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `url` varchar(150) NOT NULL DEFAULT '' COMMENT '图片地址',
  `goods_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '产品id',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `des` varchar(150) NOT NULL DEFAULT '' COMMENT '图片说明信息',
  `listorder` int(5) unsigned NOT NULL DEFAULT '50' COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='商品图片表';

/*Data for the table `fl_goods_img` */

/*Table structure for table `fl_goods_searchword` */

DROP TABLE IF EXISTS `fl_goods_searchword`;

CREATE TABLE `fl_goods_searchword` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(60) NOT NULL DEFAULT '' COMMENT '标题',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0显示',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0',
  `listorder` int(11) unsigned NOT NULL DEFAULT '50' COMMENT '排序，升序',
  `click` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '搜索次数',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='商品搜索词表';

/*Data for the table `fl_goods_searchword` */

insert  into `fl_goods_searchword`(`id`,`name`,`status`,`add_time`,`listorder`,`click`) values (3,'示例',0,1456292804,2,14),(4,'一',0,1456292815,4,4),(5,'二',0,0,50,4);

/*Table structure for table `fl_goods_type` */

DROP TABLE IF EXISTS `fl_goods_type`;

CREATE TABLE `fl_goods_type` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '父级栏目id',
  `addtime` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `name` varchar(30) NOT NULL DEFAULT '' COMMENT '栏目名称',
  `seotitle` varchar(150) NOT NULL DEFAULT '' COMMENT 'seo标题',
  `keywords` varchar(60) NOT NULL DEFAULT '' COMMENT '关键词',
  `description` varchar(255) NOT NULL DEFAULT '' COMMENT '描述',
  `content` text COMMENT '内容',
  `typedir` varchar(30) NOT NULL DEFAULT '' COMMENT '别名',
  `templist` varchar(50) NOT NULL DEFAULT '' COMMENT '列表页模板',
  `temparticle` varchar(50) NOT NULL DEFAULT '' COMMENT '详情页模板',
  `litpic` varchar(100) NOT NULL DEFAULT '' COMMENT '缩略图',
  `seokeyword` varchar(60) NOT NULL DEFAULT '' COMMENT '判断相关,可不填',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否显示,1显示',
  `listorder` int(5) unsigned NOT NULL DEFAULT '50' COMMENT '排序',
  `cover_img` varchar(100) NOT NULL DEFAULT '' COMMENT '封面',
  PRIMARY KEY (`id`),
  UNIQUE KEY `typename` (`name`),
  UNIQUE KEY `typedir` (`typedir`),
  KEY `pid` (`pid`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='商品分类表';

/*Data for the table `fl_goods_type` */

insert  into `fl_goods_type`(`id`,`pid`,`addtime`,`name`,`seotitle`,`keywords`,`description`,`content`,`typedir`,`templist`,`temparticle`,`litpic`,`seokeyword`,`status`,`listorder`,`cover_img`) values (1,0,1496576972,'手机数码','','','','<p>书籍</p>','shuma','goodscat','goods','','',1,50,''),(2,0,1496576993,'食品保健','','','','','food','goodscat','goods','','',1,50,''),(3,0,1500994389,'母婴玩具','','','','<p>qq</p>','muying','goodscat','goods','','',1,50,'');

/*Table structure for table `fl_guestbook` */

DROP TABLE IF EXISTS `fl_guestbook`;

CREATE TABLE `fl_guestbook` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(150) NOT NULL DEFAULT '' COMMENT '标题',
  `addtime` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `msg` varchar(250) NOT NULL DEFAULT '' COMMENT '描述',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否阅读，默认0未阅读',
  `name` varchar(30) NOT NULL DEFAULT '' COMMENT '姓名',
  `phone` varchar(20) NOT NULL DEFAULT '' COMMENT '电话',
  `email` varchar(60) NOT NULL DEFAULT '' COMMENT '邮箱',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='用户留言表';

/*Data for the table `fl_guestbook` */

insert  into `fl_guestbook`(`id`,`title`,`addtime`,`msg`,`status`,`name`,`phone`,`email`) values (3,'在移动搜索展现端获得良好表现的注意事项',1476063946,'移动网站优化和PC网站的很多方面都是相似甚至相同的，但由于移动搜索界面大小受限，移动网站在标题和摘要的撰写上有很多有别有PC端的情况。1，有吸引力的title用户在百度移动搜索中输',0,'','',''),(4,'撰写搜索引擎喜欢的标题',1476063980,'通过观察可以发现，那些可以从搜索引擎获得大批流量的站点来说，SEO思维渗透到了每个岗位，产品人员在提交项目MRD时，网页标题的写法是必不可少的一部分；编辑对文章内容负责的同时',0,'','',''),(5,'Baiduspider主要抓取策略类型',1476064033,'Baiduspider在抓取过程中面对的是一个超级复杂的网络环境，为了使系统可以抓取到尽可能多的有价值资源并保持系统及实际环境中页面的一致性同时不给网站体验造成压力，会设计多种复杂',0,'','',''),(6,'百度移动搜索优化前期准备工作',1476064079,'域名：与PC网站一样，域名是用户对一个网站的第一印象。一个好的移动域名，不仅容易记忆、易于输入，还能方便用户向其他人推荐。域名应尽量简短易懂，越短的域名记忆成本越低，越',0,'','',''),(9,'网页优化的大忌',1476064241,'网页进行正常优化，有助于搜索引擎更好地了解网页主体内容，而网页优化同样是一柄双刃剑，搞不好会造成费力不讨好、甚至被搜索引擎惩罚的后果。在百度看来，网页优化的大忌有三点',0,'','',''),(10,'百度优先建重要库的原则',1476064284,'Baiduspider抓了多少页面并不是最重要的，重要的是有多少页面被建索引库，即我们常说的“建库”。众所周知，搜索引擎的索引库是分层级的，优质的网页会被分配到重要索引库，普通网页',0,'','','');

/*Table structure for table `fl_keyword` */

DROP TABLE IF EXISTS `fl_keyword`;

CREATE TABLE `fl_keyword` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `keyword` varchar(30) NOT NULL DEFAULT '' COMMENT '关键词',
  `rpurl` varchar(150) NOT NULL DEFAULT '' COMMENT '链接网址',
  PRIMARY KEY (`id`),
  UNIQUE KEY `keyword` (`keyword`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `fl_keyword` */

insert  into `fl_keyword`(`id`,`keyword`,`rpurl`) values (1,'优化','http://www.pe7.org/'),(2,'搜索引擎','http://www.baidu.com/'),(3,'百度移动','http://www.ui.com'),(4,'MACD','http://www.baidu.com/');

/*Table structure for table `fl_kuaidi` */

DROP TABLE IF EXISTS `fl_kuaidi`;

CREATE TABLE `fl_kuaidi` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL DEFAULT '' COMMENT '快递公司名称',
  `code` varchar(20) NOT NULL DEFAULT '' COMMENT '公司编码',
  `money` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '金额',
  `country` varchar(20) NOT NULL DEFAULT '' COMMENT '国家编码',
  `des` varchar(150) NOT NULL DEFAULT '' COMMENT '说明',
  `tel` varchar(60) NOT NULL DEFAULT '' COMMENT '电话',
  `website` varchar(60) NOT NULL DEFAULT '' COMMENT '官网',
  `listorder` int(5) unsigned NOT NULL DEFAULT '50' COMMENT '排序',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否显示，0显示',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='快递表';

/*Data for the table `fl_kuaidi` */

insert  into `fl_kuaidi`(`id`,`name`,`code`,`money`,`country`,`des`,`tel`,`website`,`listorder`,`status`) values (1,'顺丰','shunfeng','0.00','','','95338','http://www.sf-express.com',50,0),(2,'EMS','ems','0.00','CN','','11183','http://www.ems.com.cn/',50,0),(3,'申通','shentong','0.00','','','95543','http://www.sto.cn',50,0),(4,'圆通','yuantong','0.00','','','95554','http://www.yto.net.cn/',50,0),(5,'中通','zhongtong','0.00','','','95311','http://www.zto.cn',50,0),(6,'汇通','huitongkuaidi','0.00','','特指百世汇通、百世快递，百世物流（百世快运）请用baishiwuliu','95320','http://www.800bestex.com/',50,0),(7,'韵达','yunda','0.00','','','95546','http://www.yundaex.com',50,0),(8,'宅急送','zhaijisong','0.00','','','400-6789-000','http://www.zjs.com.cn',50,0),(9,'德邦','debangwuliu','0.00','','','95353','http://www.deppon.com',50,0),(10,'天天','tiantian','0.00','','','400-188-8888','http://www.ttkdex.com',50,0),(11,'全峰','quanfengkuaidi','0.00','','','400-100-0001','http://www.qfkd.com.cn',50,0),(12,'邮政小包','youzhengguonei','0.00','','','','',50,0),(13,'国通快递','guotongkuaidi','0.00','','','','',50,0),(14,'快捷快递','kuaijiesudi','0.00','','','','',50,0);

/*Table structure for table `fl_menu` */

DROP TABLE IF EXISTS `fl_menu`;

CREATE TABLE `fl_menu` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '菜单名称',
  `pid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '父级id',
  `action` varchar(50) NOT NULL DEFAULT '' COMMENT '操作名称',
  `data` varchar(50) NOT NULL DEFAULT '' COMMENT '额外参数',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '菜单类型 1：权限认证+菜单；0：只作为菜单',
  `icon` varchar(50) NOT NULL DEFAULT '' COMMENT '菜单图标',
  `des` varchar(250) NOT NULL DEFAULT '' COMMENT '备注',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态，1显示，0不显示',
  `listorder` int(5) unsigned NOT NULL DEFAULT '50' COMMENT '排序ID',
  PRIMARY KEY (`id`),
  KEY `status` (`status`),
  KEY `parentid` (`pid`)
) ENGINE=InnoDB AUTO_INCREMENT=130 DEFAULT CHARSET=utf8 COMMENT='后台菜单表';

/*Data for the table `fl_menu` */

insert  into `fl_menu`(`id`,`name`,`pid`,`action`,`data`,`type`,`icon`,`des`,`status`,`listorder`) values (1,'文章管理',0,'article_default','',0,'glyphicon glyphicon-pencil','',1,0),(2,'商品管理',0,'goods_default','',0,'glyphicon glyphicon-shopping-cart','',1,10),(3,'菜单管理',0,'menu_default','',0,'glyphicon glyphicon-th-list','',1,20),(4,'用户管理',0,'user_default','',0,'glyphicon glyphicon-user','',1,30),(5,'批量维护',0,'extension_default','',0,'glyphicon glyphicon-cloud','',1,40),(6,'设置',0,'sysconfig_default','',0,'glyphicon glyphicon-wrench','',1,1000),(7,'页面跳转',5,'admin_jump','',1,'','',0,1),(8,'后台首页',5,'admin','',1,'','',0,2),(9,'更新系统参数配置',5,'admin_index_upconfig','',1,'','',0,3),(10,'更新缓存',5,'admin_index_upcache','',1,'','',0,4),(11,'文章列表',1,'admin_article','',1,'','',1,50),(12,'发布文章',1,'admin_article_add','',1,'','',1,50),(13,'发布文章提交',12,'admin_article_doadd','',1,'','',0,50),(14,'文章修改',1,'admin_article_edit','',1,'','',0,50),(15,'文章修改提交',14,'admin_article_doedit','',1,'','',0,50),(16,'文章删除',1,'admin_article_del','',1,'','',0,50),(17,'重复文档检测',1,'admin_article_repetarc','',1,'','',1,50),(18,'文章推荐',1,'admin_article_recommendarc','',1,'','',0,50),(19,'文章是否存在',1,'admin_article_articleexists','',1,'','',0,50),(20,'文章栏目',1,'admin_category','',1,'','',1,50),(21,'文章栏目添加',20,'admin_category_add','',1,'','',0,50),(22,'文章栏目添加提交',21,'admin_category_doadd','',1,'','',0,50),(23,'文章栏目修改',20,'admin_category_edit','',1,'','',0,50),(24,'文章栏目修改提交',23,'admin_category_doedit','',1,'','',0,50),(25,'文章栏目删除',20,'admin_category_del','',1,'','',0,50),(26,'Tag标签管理',5,'admin_tag','',1,'','',1,50),(27,'Tag标签添加',26,'admin_tag_add','',1,'','',0,50),(28,'Tag标签添加提交',27,'admin_tag_doadd','',1,'','',0,50),(29,'Tag标签修改',26,'admin_tag_edit','',1,'','',0,50),(30,'Tag标签修改提交',29,'admin_tag_doedit','',1,'','',0,50),(31,'Tag标签删除',26,'admin_tag_del','',1,'','',0,50),(32,'单页管理',1,'admin_page','',1,'','',1,50),(33,'单页添加',32,'admin_page_add','',1,'','',0,50),(34,'单页添加提交',33,'admin_page_doadd','',1,'','',0,50),(35,'单页修改',32,'admin_page_edit','',1,'','',0,50),(36,'单页修改提交',35,'admin_page_doedit','',1,'','',0,50),(37,'单页删除',32,'admin_page_del','',1,'','',0,50),(38,'商品列表',2,'admin_goods','',1,'','',1,50),(39,'商品添加',2,'admin_goods_add','',1,'','',1,50),(40,'商品添加提交',39,'admin_goods_doadd','',1,'','',0,50),(41,'商品修改',2,'admin_goods_edit','',1,'','',0,50),(42,'商品修改提交',41,'admin_goods_doedit','',1,'','',0,50),(43,'商品删除',2,'admin_goods_del','',1,'','',0,50),(44,'重复商品',2,'admin_goods_recommendarc','',1,'','',0,50),(45,'商品是否存在',2,'admin_goods_goodsexists','',1,'','',0,50),(46,'商品分类',2,'admin_goodstype','',1,'','',1,50),(47,'商品分类添加',46,'admin_goodstype_add','',1,'','',1,50),(48,'商品分类添加提交',47,'admin_goodstype_doadd','',1,'','',0,50),(49,'商品分类修改',46,'admin_producttype_edit','',1,'','',0,50),(50,'商品分类修改提交',42,'admin_producttype_doedit','',1,'','',0,50),(51,'商品分类删除',46,'admin_goodstype_del','',1,'','',0,50),(52,'友情链接',5,'admin_friendlink','',1,'','',1,50),(53,'友情链接添加',52,'admin_friendlink_add','',1,'','',0,50),(54,'友情链接添加提交',53,'admin_friendlink_doadd','',1,'','',0,50),(55,'友情链接修改',52,'admin_friendlink_edit','',1,'','',0,50),(56,'友情链接修改提交',55,'admin_friendlink_doedit','',1,'','',0,50),(57,'友情链接删除',52,'admin_friendlink_del','',1,'','',0,50),(58,'关键词管理',5,'admin_keyword','',1,'','',1,50),(59,'关键词添加',58,'admin_keyword_add','',1,'','',0,50),(60,'关键词添加提交',59,'admin_keyword_doadd','',1,'','',0,50),(61,'关键词修改',58,'admin_keyword_edit','',1,'','',0,50),(62,'关键词修改提交',61,'admin_keyword_doedit','',1,'','',0,50),(63,'关键词删除',58,'admin_keyword_del','',1,'','',0,50),(64,'搜索关键词',5,'admin_searchword','',1,'','',1,50),(65,'搜索关键词添加',64,'admin_searchword_add','',1,'','',0,50),(66,'搜索关键词添加提交',65,'admin_searchword_doadd','',1,'','',0,50),(67,'搜索关键词修改',64,'admin_searchword_edit','',1,'','',0,50),(68,'搜索关键词修改提交',67,'admin_searchword_doedit','',1,'','',0,50),(69,'搜索关键词删除',64,'admin_searchword_del','',1,'','',0,50),(70,'轮播图',5,'admin_slide','',1,'','',1,50),(71,'轮播图添加',70,'admin_slide_add','',1,'','',0,50),(72,'轮播图添加提交',71,'admin_slide_doadd','',1,'','',0,50),(73,'轮播图修改',70,'admin_slide_edit','',1,'','',0,50),(74,'轮播图修改提交',73,'admin_slide_doedit','',1,'','',0,50),(75,'轮播图删除',70,'admin_slide_del','',1,'','',0,50),(76,'在线留言',5,'admin_guestbook','',1,'','',1,50),(77,'在线留言删除',76,'admin_guestbook_del','',1,'','',0,50),(78,'系统基本参数',6,'admin_sysconfig','',1,'','',1,50),(79,'系统参数添加',78,'admin_sysconfig_add','',1,'','',0,50),(80,'系统参数添加提交',79,'admin_sysconfig_doadd','',1,'','',0,50),(81,'系统参数修改',78,'admin_sysconfig_edit','',1,'','',0,50),(82,'系统参数修改提交',81,'admin_sysconfig_doedit','',1,'','',0,50),(83,'系统参数删除',78,'admin_sysconfig_del','',1,'','',0,50),(84,'管理员',4,'admin_admin','',1,'','',1,50),(85,'管理员添加',84,'admin_admin_add','',1,'','',0,50),(86,'管理员添加提交',85,'admin_admin_doadd','',1,'','',0,50),(87,'管理员修改',84,'admin_admin_edit','',1,'','',0,50),(88,'管理员修改提交',87,'admin_admin_doedit','',1,'','',0,50),(89,'管理员删除',84,'admin_admin_del','',1,'','',0,50),(90,'角色管理',4,'admin_adminrole','',1,'','',1,50),(91,'角色添加',90,'admin_adminrole_add','',1,'','',0,50),(92,'角色添加修改',91,'admin_adminrole_doadd','',1,'','',0,50),(93,'角色修改',90,'admin_adminrole_edit','',1,'','',0,50),(94,'角色修改提交',93,'admin_adminrole_doedit','',1,'','',0,50),(95,'角色删除',90,'admin_adminrole_del','',1,'','',0,50),(96,'后台菜单',3,'admin_menu','',1,'','',1,50),(97,'菜单添加',96,'admin_menu_add','',1,'','',0,50),(98,'菜单添加提交',97,'admin_menu_doadd','',1,'','',0,50),(99,'菜单修改',96,'admin_menu_edit','',1,'','',0,50),(100,'菜单修改提交',99,'admin_menu_doedit','',1,'','',0,50),(101,'菜单删除',96,'admin_menu_del','',1,'','',0,50),(102,'权限设置',90,'admin_adminrole_permissions','',1,'','',0,50),(103,'权限设置提交',102,'admin_adminrole_dopermissions','',1,'','',0,50),(104,'欢迎页面',5,'admin_welcome','',1,'','',0,5),(105,'微信开发管理',0,'weixin_default','',0,'glyphicon glyphicon-th-large','',1,50),(106,'微信自定义菜单',105,'admin_weixinmenu','',1,'','',1,50),(107,'商品品牌',2,'admin_goodsbrand','',1,'','',1,50),(108,'品牌添加',107,'admin_goodsbrand_add','',1,'','',0,50),(109,'品牌添加提交',108,'admin_goodsbrand_doadd','',1,'','',0,50),(110,'品牌修改',107,'admin_goodsbrand_edit','',1,'','',0,50),(111,'品牌修改提交',110,'admin_goodsbrand_doedit','',1,'','',0,50),(112,'品牌删除',107,'admin_goodsbrand_del','',1,'','',0,50),(113,'订单管理',0,'order_default','',0,'glyphicon glyphicon-credit-card','',1,50),(114,'订单列表',113,'admin_order','',1,'','',1,50),(115,'订单详情',113,'admin_order_detail','',1,'','',0,50),(116,'订单修改',113,'admin_order_edit','',1,'','',0,50),(117,'订单修改提交',116,'admin_order_doedit','',1,'','',0,50),(118,'会员管理',4,'admin_user','',1,'','',1,50),(119,'提现申请',4,'admin_userwithdraw','',1,'','',1,50),(120,'意见反馈',5,'admin_feedback','',1,'','',1,50),(121,'意见反馈删除',120,'admin_feedback_del','',1,'','',0,50),(122,'快递管理',113,'admin_kuaidi','',1,'','',1,50),(123,'快递添加',122,'admin_kuaidi_add','',1,'','',0,50),(124,'快递修改',122,'admin_kuaidi_edit','',1,'','',0,50),(125,'快递删除',122,'admin_kuaidi_del','',1,'','',0,50),(126,'优惠券管理',2,'admin_bonus','',1,'','',1,50),(127,'优惠券添加',126,'admin_bonus_add','',1,'','',0,50),(128,'优惠券啊修改',126,'admin_bonus_edit','',1,'','',0,50),(129,'优惠券删除',126,'admin_bonus_del','',1,'','',0,50);

/*Table structure for table `fl_order` */

DROP TABLE IF EXISTS `fl_order`;

CREATE TABLE `fl_order` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `order_sn` varchar(30) NOT NULL DEFAULT '' COMMENT '订单号',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `shop_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '商家id',
  `add_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '订单生成时间',
  `order_status` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '订单状态，0生成订单,1已取消(客户触发),2无效(管理员触发),3完成订单',
  `refund_status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '退货退款(订单完成后)，0无退货，1有退货，2退货成功，3拒绝',
  `shipping_status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '商品配送情况;0未发货,1已发货,2已收货',
  `pay_status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '支付状态;0未付款;1已付款',
  `goods_amount` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '商品的总金额',
  `order_amount` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '应付金额=商品总价+运费-优惠(积分、红包)',
  `discount` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '优惠金额',
  `pay_money` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '支付金额',
  `pay_id` tinyint(4) unsigned NOT NULL DEFAULT '0' COMMENT '支付方式',
  `pay_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '订单支付时间',
  `pay_name` varchar(30) NOT NULL DEFAULT '' COMMENT '支付方式名称',
  `out_trade_no` varchar(60) NOT NULL DEFAULT '' COMMENT '支付订单号',
  `shipping_name` varchar(20) NOT NULL DEFAULT '' COMMENT '配送方式名称',
  `shipping_id` tinyint(4) unsigned NOT NULL DEFAULT '0' COMMENT '配送方式',
  `shipping_sn` varchar(30) NOT NULL DEFAULT '' COMMENT '发货单',
  `shipping_fee` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '配送费用',
  `shipping_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '发货时间',
  `name` varchar(10) NOT NULL DEFAULT '' COMMENT '收货人姓名',
  `province` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '省份',
  `city` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '城市',
  `district` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '区域',
  `address` varchar(250) NOT NULL DEFAULT '' COMMENT '地址',
  `zipcode` varchar(10) NOT NULL DEFAULT '' COMMENT '邮编',
  `mobile` varchar(60) NOT NULL DEFAULT '' COMMENT '电话',
  `message` varchar(250) NOT NULL DEFAULT '' COMMENT '买家留言',
  `is_comment` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否评论，1已评价',
  `integral_money` decimal(10,2) unsigned DEFAULT '0.00' COMMENT '使用积分金额',
  `integral` int(10) unsigned DEFAULT '0' COMMENT '使用的积分的数量',
  `bonus_money` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '使用优惠劵支付金额',
  `bonus_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '优惠券id',
  `is_delete` tinyint(1) unsigned DEFAULT '0' COMMENT '是否删除，1删除',
  `note` varchar(240) DEFAULT '' COMMENT '商家/后台操作备注',
  `invoice` tinyint(1) unsigned DEFAULT '0' COMMENT '发票：0不索要，1个人，2企业',
  `invoice_title` varchar(100) DEFAULT '' COMMENT '发票抬头',
  `invoice_taxpayer_number` varchar(100) DEFAULT '' COMMENT '纳税人识别号',
  `place_type` tinyint(3) DEFAULT '0' COMMENT '订单来源,1pc，2weixin，3app，4wap',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='订单表';

/*Data for the table `fl_order` */

insert  into `fl_order`(`id`,`order_sn`,`user_id`,`shop_id`,`add_time`,`order_status`,`refund_status`,`shipping_status`,`pay_status`,`goods_amount`,`order_amount`,`discount`,`pay_money`,`pay_id`,`pay_time`,`pay_name`,`out_trade_no`,`shipping_name`,`shipping_id`,`shipping_sn`,`shipping_fee`,`shipping_time`,`name`,`province`,`city`,`district`,`address`,`zipcode`,`mobile`,`message`,`is_comment`,`integral_money`,`integral`,`bonus_money`,`bonus_id`,`is_delete`,`note`,`invoice`,`invoice_title`,`invoice_taxpayer_number`,`place_type`) values (1,'201712122241067479',3,0,1513089666,0,0,0,0,'45000.00','45000.00','0.00','0.00',0,0,'','','',0,'','0.00',0,'Kenny G',1,52129,72,'阿斯达','','15280719357','',0,'0.00',0,'0.00',0,0,'',0,'','',2),(2,'201712122241285027',3,0,1513089688,0,0,0,1,'5.00','5.00','0.00','5.00',1,1513089694,'余额支付','','无须物流',0,'dsfgd','0.00',0,'Kenny G',1,52129,72,'阿斯达','','15280719357','',0,'0.00',0,'0.00',0,0,'',0,'','',2),(3,'201712141038364533',3,0,1513219116,3,1,0,0,'6.10','6.10','0.00','0.00',0,0,'','','',0,'','0.00',0,'李宗盛',16,1329,1331,'红糖100号','','15280765456','梵蒂冈的士大夫',0,'0.00',0,'0.00',0,0,'',1,'繁橙科技有限公司','213124321',2),(4,'201802272006071588',3,0,1519733167,0,0,0,0,'2.00','2.00','0.00','0.00',0,0,'','','',0,'','0.00',0,'李宗盛',16,1329,1331,'红糖100号','','15280765456','',0,'0.00',0,'0.00',0,0,'',0,'','',2);

/*Table structure for table `fl_order_goods` */

DROP TABLE IF EXISTS `fl_order_goods`;

CREATE TABLE `fl_order_goods` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '订单id',
  `goods_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '商品id',
  `goods_name` varchar(120) NOT NULL DEFAULT '' COMMENT '商品名称',
  `goods_number` smallint(5) unsigned NOT NULL DEFAULT '1' COMMENT '商品数量',
  `market_price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '市场价格',
  `goods_price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '商品价格',
  `goods_attr` text COMMENT '商品属性',
  `goods_img` varchar(150) NOT NULL DEFAULT '' COMMENT '商品缩略图',
  `refund_status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '退货状态，0无退货，1退款中，2退款成功，3不同意退款',
  `refund_reason` varchar(100) NOT NULL DEFAULT '' COMMENT '退货原因，客户操作',
  `refund_handle_des` varchar(240) NOT NULL DEFAULT '' COMMENT '退货处理结果，管理员操作',
  `refund_sn` varchar(30) NOT NULL DEFAULT '' COMMENT '退货单号',
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  KEY `goods_id` (`goods_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='订单商品表';

/*Data for the table `fl_order_goods` */

insert  into `fl_order_goods`(`id`,`order_id`,`goods_id`,`goods_name`,`goods_number`,`market_price`,`goods_price`,`goods_attr`,`goods_img`,`refund_status`,`refund_reason`,`refund_handle_des`,`refund_sn`) values (1,1,1,'示例产品一',1,'50000.00','45000.00','','/uploads/2017/06/201706041951031181.jpg',0,'','',''),(2,2,4,'示例产品四2',1,'6.00','5.00','','/uploads/2017/06/201706042013331349.jpg',0,'','',''),(3,3,2,'示例产品二',1,'2.00','1.00','','/uploads/2017/06/201706042011354141.jpg',0,'','',''),(4,3,3,'示例产品三',1,'4.00','5.10','','/uploads/2017/06/201706042012428057.jpg',0,'','',''),(5,4,4,'示例产品四2',1,'6.00','2.00','','/uploads/2017/06/201706042013331349.jpg',0,'','','');

/*Table structure for table `fl_page` */

DROP TABLE IF EXISTS `fl_page`;

CREATE TABLE `fl_page` (
  `id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(150) NOT NULL DEFAULT '' COMMENT '单页标题',
  `seotitle` varchar(150) NOT NULL DEFAULT '' COMMENT 'seo标题',
  `keywords` varchar(100) NOT NULL DEFAULT '' COMMENT '关键词',
  `template` varchar(30) NOT NULL DEFAULT '' COMMENT '模板名称',
  `description` varchar(250) NOT NULL DEFAULT '' COMMENT '页面摘要信息',
  `pubdate` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `body` mediumtext COMMENT '内容',
  `filename` varchar(60) NOT NULL DEFAULT '' COMMENT '别名',
  `litpic` varchar(100) NOT NULL DEFAULT '' COMMENT '缩略图',
  `click` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '点击量',
  `listorder` int(5) unsigned NOT NULL DEFAULT '50' COMMENT '排序',
  PRIMARY KEY (`id`),
  UNIQUE KEY `filename` (`filename`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='单页面表';

/*Data for the table `fl_page` */

insert  into `fl_page`(`id`,`title`,`seotitle`,`keywords`,`template`,`description`,`pubdate`,`body`,`filename`,`litpic`,`click`,`listorder`) values (1,'公司简介','','公司简介','page','LQYCMS企业网站管理系统采用PHP+Mysql架构，全站内置了SEO搜索引擎优化机制，支持用户自定义界面语言，拥有企业网站常用的模块功能（企业简介模块、新闻模块、产品模块、下载模块、图片模块、招聘模块、在线留言、反馈系统、在线交流、友情链接、会员与权限管理）。强大灵活的后台管理功能、静态页面生成功能、个性化模块添加功能、不同栏目自定义FLASH样式功能等可为企业打造出大气漂亮且具有营销力的',1496540889,'<p>我们专注于网络信息化及网络营销领域，通过整合团队专业的市场营销理念与网络技术为客户提供优质的网络营销服务。</p><p><br/></p><p>我们的主要业务包括：网站系统开发、网站建设、网站推广、空间域名以及网络营销策划与运行。</p><p><br/></p><p>我们主打产品——LQYCMS企业网站管理系统采用PHP+Mysql架构，全站内置了SEO搜索引擎优化机制，支持用户自定义界面语言，拥有企业网站常用的模块功能（企业简介模块、新闻模块、产品模块、下载模块、图片模块、招聘模块、在线留言、反馈系统、在线交流、友情链接、会员与权限管理）。强大灵活的后台管理功能、静态页面生成功能、个性化模块添加功能、不同栏目自定义FLASH样式功能等可为企业打造出大气漂亮且具有营销力的精品网站。</p><p><br/></p><p>我们秉承“为合作伙伴创造价值”的核心价值观，并以“诚实、宽容、创新、服务”为企业精神，通过自主创新和真诚合作为电子商务及信息服务行业创造价值。</p><p><br/></p><p><strong>关于“为合作伙伴创造价值”</strong></p><p><br/></p><p>我们认为客户、供应商、公司股东、公司员工等一切和自身有合作关系的单位和个人都是自己的合作伙伴，并只有通过努力为合作伙伴创造价值，才能体现自身的价值并获得发展和成功。</p><p><br/></p><p><strong>关于“诚实、宽容、创新、服务”</strong></p><p><br/></p><p>我们认为诚信是一切合作的基础，宽容是解决问题的前提，创新是发展事业的利器，服务是创造价值的根本。</p>','about','',393,50),(2,'联系我们','','','page','',1496540844,'<p>XX有限公司</p><p>地址：XX市XX区XXX号XXX栋XXX房</p><p>电话：0000-888888 13300000000</p><p>Q &nbsp;Q：374861669</p><p>邮编：000000</p><p>邮箱：374861669@</p><p>网址：www.1104.org</p>','contact','',259,50),(3,'企业文化','','','page','​企业文化，或称组织文化（Corporate Culture或Organizational Culture），是一个组织由其价值观、信念、仪式、符号、处事方式等组成的其特有的文化形象。',1496541077,'<p>企业文化，或称组织文化（Corporate Culture或Organizational Culture），是一个组织由其价值观、信念、仪式、符号、处事方式等组成的其特有的文化形象。<br/></p><p><br/></p><p>职工文化，也称企业职工文化，是与企业文化相对应的文化形态，职工文化以职工为本，是一种素质文化，企业文化以企业为本，是一种管理文化。</p><p>企业文化是在一定的条件下，企业生产经营和管理活动中所创造的具有该企业特色的精神财富和物质形态。它包括文化观念、价值观念、企业精神、道德规范、行为准则、历史传统、企业制度、文化环境、企业产品等。其中价值观是企业文化的核心。</p><p><br/></p><p>企业文化是企业的灵魂，是推动企业发展的不竭动力。它包含着非常丰富的内容，其核心是企业的精神和价值观。这里的价值观不是泛指企业管理中的各种文化现象，而是企业或企业中的员工在从事商品生产与经营中所持有的价值观念。</p>','culture','',264,50),(4,'招贤纳士','','','page','',1496541317,'<p><strong>PHP技术支持</strong></p><p><br/></p><p>主要工作内容：</p><p>1. 负责MetInfo企业网站管理系统技术支持；</p><p>2. 为客服人员提供技术支持；</p><p>&nbsp;</p><p>岗位要求：&nbsp;</p><p><br/></p><p>php能看懂且对PHP感兴趣，理解面向对象基本概念，写过一些小程序；</p><p>懂MySql数据库备份、恢复等基本操作，熟悉PHP环境的搭建和配置；</p><p>javascript能看懂，了解jquery等js框架；</p><p>html/css会写，懂linux的优先；</p><p>擅长网上查找资料解决问题；</p><p>有PHP作品（留言板，blog等）的优先；</p><p>做事要有耐心，性格谦和，学习能力强，能吃苦耐劳，愿意同公司共同发展。</p><p>如果你对我们的职位感兴趣，且符合我们的基本要求，请将个人简历投递至xxx@qq.com，或者直接与我们取得联系！</p><p><br/></p><p><br/></p><p><strong>网络销售</strong></p><p><br/></p><p>大专以上学历，一年以上网络销售经验；</p><p>熟悉网络推广，熟悉网站建设基本流程；</p><p>有网站制作相关工作经验者优先；</p><p>学习能力强，能吃苦耐劳，愿意同公司共同发展；</p><p>本岗位招收兼职，投递简历时请说明自己的工作意愿；</p><p>如果你对我们的职位感兴趣，且符合我们的基本要求，请将个人简历投递至xxx@qq.com，或者直接与我们取得联系！</p><p><br/></p><p><br/></p><p><strong>网页UI设计师</strong></p><p><br/></p><p>主要工作内容：负责MetInfo界面和公司网站的界面设计等，重视用户体验。</p><p><br/></p><p>岗位要求：</p><p>视觉设计、平面设计或美术相关专业，大专以上学历。</p><p>具有良好的创意设计能力及良好的色彩感，有较高的美术功底，较强的网页设计能力和整体布局感。</p><p>精通photoshop、Illustrator、Fireworks、Dreamweaver等图形设计工具中至少两种。</p><p>了解网页交互设计知识，对作品有不断追求完美的精神特质。</p><p>有网站UI设计同等职位工作经验、能提供过往作品者优先。</p>','jobs','',460,50),(5,'用户注册协议','用户注册协议','','page','',1519694248,'<p>尊敬的客户，欢迎您注册成为本网站用户，在注册前请仔细阅读如下服务条款。本协议双方为用户与公司，适用于用户注册使用本网站服务的全部活动。<br/></p><p><br/></p><p>在注册本网站之前，请您务必认真阅读并充分理解本协议全部内容。您点击本协议下方的“注册”按钮，并按照本网站注册程序成功成为注册为用户，即视为您已经充分理解和同意本协议全部内容，并签署了本协议，本协议立即在您与本公司之间产生合同法律效力，您使用本网站服务的全部活动将受到本协议的约束并应承担相应的责任和义务。</p><p><br/></p><p><strong>1、协议组成说明</strong></p><p><br/></p><p>1.1本协议的内容包括本协议以下全部条款以及本网站已经公示发布的及将来可能公示发布的各项规则，该等规则均为本协议不可分割的一部分，与本协议以下所列条款具有同等法律效力。</p><p><br/></p><p>1.2本网站有权根据需要修改本协议的内容。如以下条款或本网站各项规则有任何变更，本网站将在网站上刊载公告，不再向用户作个别通知。经修订的相关条款和规则一经公告，即于公告规定的特定生效日期自动生效。请您及时关注本网站关于相关条款和规则的公告，如不同意该变更，请您在变更公告刊载之日起72小时内以您在本网站注册时提供的个人邮箱向本网站公布的的服务邮箱发送邮件或拨打客服电话表明希望终止本协议（&quot;注册终止申请&quot;），本网站确认收到您的邮件和电话后将与您协商本协议终止后双方义务的履行。如您在本条所述时限内未发送注册终止申请，则本条所述时限届满之时，视为您已经同意接受该等变更，并应遵照修改后的协议履行应尽义务，经修订的相关条款和规则一经公告，即于公告规定的特定生效日期自动生效并对您产生法律约束力。</p><p><br/></p><p>1.3本协议不涉及您与本网站的其他用户之间因网上交易而产生的法律关系及法律纠纷。但您在此不可撤销地同意，您将全面接受并履行与本网站其他用户在本网站签订的任何电子法律文本，并承诺按照该法律文本享有和（或）放弃相应的权利、承担和（或）豁免相应的义务。</p><p><br/></p><p><strong>2、用户注册需知</strong></p><p><br/></p><p>2.1注册成为本网站用户必须满足如下主体资格条件：您必须是中国大陆公民，年龄在18周岁以上，且具有完全的民事权利能力及民事行为能力。如不具备上述资格，您应立即停止在本网站的注册程序、停止使用本网站服务，若违反前述规定注册使用本网站服务，本网站有权随时终止您的注册进程及本网站服务，并保留终止您的用户资格、追究您或您的监护人相关法律责任的权利。</p><p><br/></p><p>2.2在注册时和使用本网站服务的所有期间，您应根据本网站的要求提供您自身的真实资料和信息，并保证自注册之时起至使用本网站服务的所有期间，其所提交的所有资料和信息（包括但不限于真实姓名、电子邮件地址、联系电话、个人身份信息等）真实、准确、完整、有效和合法，复印件与原件一致，并如有变更，请及时更新，如因用户未及时更新信息和资料导致本网站无法向用户提供服务或发生错误，由此产生的法律责任和后果由用户自己承担。如使用他人信息和文件注册使用本网站服务或向本网站提供的信息和资料不符合上述规定，由此引起的一切责任和后果均由用户本人全部承担，本公司及本网站不因此承担任何法律责任，如因此而给本公司及本网站造成损失，用户应当承担赔偿本公司及本网站损失的责任。</p><p><br/></p><p><strong>3、服务变更、中断或终止</strong></p><p><br/></p><p>3.1鉴于网络服务的特殊性，用户同意本网站有权随时变更、中断或终止部分或全部的网络服务（包括收费网络服务）。如变更、中断或终止的网络服务属于免费网络服务，本网站无需通知用户，也无需对任何用户或任何第三方承担任何责任；如变更、中断或终止的网络服务属于收费网络服务，本网站应当在变更、中断或终止之前事先通知用户，并应向受影响的用户提供等值的替代性的收费网络服务，如用户不愿意接受替代性的收费网络服务，就该用户已经向本网站支付的服务费，本网站应当按照该用户实际使用相应收费网络服务的情况扣除相应服务费之后将剩余的服务费退还给该用户。</p><p><br/></p><p>3.2用户理解，本网站需要定期或不定期地对提供网络服务的平台（如互联网网站、移动网络等）或相关的设备进行检修或者维护，如因此类情况而造成收费网络服务在合理时间内的中断，本网站无需为此承担任何责任，但本网站应尽可能事先进行通告。</p><p><br/></p><p><strong>4、用户使用规则</strong></p><p><br/></p><p>4.1您不得利用本网站或本网站服务从事任何不符合中国法律法规或侵犯他人权益的活动。不得自行发布、转载、传送含有下列内容之一的信息，本网站在发现您从事该等活动和发布信息时，有权基于本网站的独立判断直接删除您在本网站上作出的相关信息，有权不经通知而立即停止您对本网站的全部或部分功能的使用（包括但不限于中止、终止、限制您使用本网站服务）而无需通知您，亦无需承担任何责任。如因此而给本公司及本网站造成损失的，应当赔偿本公司及本网站的损失。</p><p><br/></p><p>（1）违反宪法确定的基本原则的；</p><p><br/></p><p>（2）危害国家安全，泄露国家机密，颠覆国家政权，破坏国家统一的；</p><p><br/></p><p>（3）损害国家荣誉和利益的；</p><p><br/></p><p>（4）煽动民族仇恨、民族歧视，破坏民族团结的；</p><p><br/></p><p>（5）破坏国家宗教政策，宣扬邪教和封建迷信的；</p><p><br/></p><p>（6）散布谣言，扰乱社会秩序，破坏社会稳定的；</p><p><br/></p><p>（7）散布淫秽、色情、赌博、暴力、恐怖或者教唆犯罪的；</p><p><br/></p><p>（8）侮辱或者诽谤他人，侵害他人合法权益的；</p><p><br/></p><p>（9）煽动非法集会、结社、游行、示威、聚众扰乱社会秩序的；</p><p><br/></p><p>（10）以非法民间组织名义活动的；</p><p><br/></p><p>（11）含有法律、行政法规禁止的其他内容的。</p><p><br/></p><p>4.2在使用本网站时，您不得违反下述规定，如有违反任意一条，本网站基于本网站的独立判断直接删除您在本网站上作出的相关信息，有权要求您改正或直接采取必要的措施禁止（包括但不限于中止、终止、限制您使用本网站服务）而无需通知您，亦无需承担任何责任。如因此而给本公司及本网站造成损失的，您应当赔偿本公司及本网站的损失。</p><p><br/></p><p>（1）不得为任何非法目的而使用网络服务系统；</p><p><br/></p><p>（2）遵守所有与网络服务有关的网络协议、规定和程序；</p><p><br/></p><p>（3）不得利用本网站进行任何可能对互联网的正常运转造成不利影响的行为；</p><p><br/></p><p>（4）不得利用本网站进行任何不利于本网站或侵犯本公司利益的行为或言论。</p><p><br/></p><p>4.3账户安全及管理：</p><p><br/></p><p>4.3.1您在注册时向本网站提交的电子邮箱、用户名、密码及安全问题答案是您在本网站的唯一识别信息。您注册成功后，您应当妥善保管自己的用户名和密码，并对自己的用户名及密码安全性负责，不得将注册的电子邮箱、用户名、密码及安全问题答案转让、赠与或授权给第三方使用。您确认使用您的用户名和密码登陆本网站后在本网站的一切行为以及以您在本网站注册时提交的个人电子邮箱发送邮件的行为均代表您本人，并由您承担相应的法律后果，本公司及本网站不承担任何责任。</p><p><br/></p><p>4.3.2协助义务：您如发现有第三人冒用或盗用您账户及密码，或其他任何未经合法授权的情形，应立即以有效方式通知本网站，要求本网站暂停相关服务，否则由此产生的一切责任由您本人承担。同时，您理解本网站对您的请求采取行动需要合理期限，在此之前，本网站对第三人使用该服务所导致的损失不承担任何责任。</p><p><br/></p><p>4.3.3本网站有权基于单方独立判断，在其认为可能发生危害交易安全等情形时，不经通知而先行暂停、中断或终止向您提供本协议项下的全部或部分服务（包括收费服务），并将注册资料移除或删除，且无需对您或任何第三方承担任何责任。前述情形包括但不限于：</p><p><br/></p><p>（1）本网站认为您提供的个人资料不具有真实性、有效性或完整性；</p><p><br/></p><p>（2）本网站发现异常交易或有疑义或有违法之虞时；</p><p><br/></p><p>（3）本网站认为您的账户涉嫌洗钱、套现、传销、被冒用或其他本网站认为有风险之情形；</p><p><br/></p><p>（4）本网站认为您已经违反本协议中规定的各类规则及精神；</p><p><br/></p><p>（5）您在使用本网站收费服务时未按规定向本公司（含关联企业）支付相应的服务费用；</p><p><br/></p><p>（6）用户账户已连续三年内未实际使用且账户中余额为零；</p><p><br/></p><p>（7）本网站基于交易安全等原因，根据其单独判断需先行暂停、中断或终止向您提供本协议项下的全部或部分用户服务（包括收费服务），并将注册资料移除或删除的其他情形。</p><p><br/></p><p>4.3.4您同意，在必要时，本网站无需进行事先通知即有权终止提供用户账户服务，并可能立即暂停、关闭或删除您账户及该用户账户中所有相关资料及档案。</p><p><br/></p><p>4.4知识产权：</p><p><br/></p><p>4.4.1本网站的所有内容，包括但不限于文本、数据、图片、音频、视频、源代码和其他所有信息，均由本公司及本网站享有知识产权。未经本网站事先书面同意，不得复制、模仿、改编、传播、公布、展示或以任何其他方式侵犯本网站的知识产权。未经本公司书面同意,您不得将本网站包含的资料等任何内容发布到任何其他网站或者服务器。任何未经授权对本网站内容的使用均属于违法行为,本公司有权追究法律责任。注册用户未经本网站的明确书面同意不许下载（除了页面缓存）或修改平台或其任何部分。</p><p><br/></p><p><strong>5、用户隐私保护及授权</strong></p><p><br/></p><p>5.1您同意本网站在业务运营中收集和储存您的用户信息，包括但不限于您自行提供的资料和信息，以及本网站自行收集、取得的您在本网站的交易记录和使用信息等。本网站收集和储存您的用户信息的主要目的在于提高为您提供服务的效率和质量。</p><p><br/></p><p>5.2本网站不对外公开或第三方提供单个用户的注册资料及用户在使用网络服务时存储在本网站的非公开内容，但下列情况除外：</p><p><br/></p><p>（1）事先获得用户的明确授权；</p><p><br/></p><p>（2）根据有关的法律法规要求；</p><p><br/></p><p>（3）按照相关政府主管部门的要求；</p><p><br/></p><p>（4）为维护社会公众的利益。</p><p><br/></p><p>5.3本网站可能会与第三方合作向用户提供相关的网络服务，在此情况下，如该第三方同意承担与本站同等的保护用户隐私的责任，则本站有权将用户的注册资料等提供给该第三方。</p><p><br/></p><p>5.4本网站按照您在本网站上的行为自动追踪关于您的某些资料。在不透露注册用户的隐私资料的前提下，本网站有权对整个用户数据库进行分析并对用户数据库进行商业上的利用。</p><p><br/></p><p>5.5您同意，本公司及本网站可在本网站平台的某些网页上使用数据收集装置。</p><p><br/></p><p><strong>6、责任限制</strong></p><p><br/></p><p>6.1基于互联网的特殊性，本公司无法保证本网站的服务不会中断，对于包括但不限于本公司、本网站及相关第三方的设备、系统存在缺陷，计算机发生故障、遭到病毒、黑客攻击或者发生地震、海啸等不可抗力而造成服务中断或因此给您造成的损失，本公司不承担任何责任，有关损失由您自己承担。</p><p><br/></p><p>6.2本公司无义务监测本网站内容。您对于本网站披露的信息、选择使用本网站提供的服务，选择参与交易等，应当自行判断真实性和承担风险，由此而产生的法律责任和后果由您自己承担，本公司不承担任何责任。</p><p><br/></p><p>6.3与本公司合作的第三方机构向您提供的服务由第三方机构自行负责，本公司不对此等服务承担任何责任。</p><p><br/></p><p>6.4本网站的内容可能涉及第三方所有的信息或第三方网站，该等信息或第三方网站的真实性、可靠性、有效性等由相关第三方负责，您对该等信息或第三方网站自行判断并承担风险，与本网站和本公司无关。</p><p><br/></p><p>6.5无论如何，本公司对您承担的违约赔偿（如有）总额不超过向您收取的服务费用总额。</p><p><br/></p><p><strong>7、风险提示</strong></p><p><br/></p><p>7.1您了解并认可，任何通过本网站进行的交易并不能避免以下风险的产生，本网站不能也没有义务为如下风险负责：</p><p><br/></p><p>（1）宏观经济风险：因宏观经济形势变化，可能引起价格等方面的异常波动，您有可能遭受损失；</p><p><br/></p><p>（2）政策风险：有关法律、法规及相关政策、规则发生变化，可能引起价格等方面异常波动，您有可能遭受损失；</p><p><br/></p><p>（3）违约风险：因其他交易方无力或无意愿按时足额履约，您有可能遭受损失；</p><p><br/></p><p>（4）利率风险：市场利率变化可能对购买或持有产品的实际收益产生影响；</p><p><br/></p><p>（5）不可抗力因素导致的风险；</p><p><br/></p><p>（6）因您的过错导致的任何损失，该过错包括但不限于：操作不当、遗忘或泄露密码、密码被他人破解、您使用的计算机系统被第三方侵入、您委托他人代理交易时他人恶意或不当操作而造成的损失。</p><p><br/></p><p>7.2除按照规则运作还款风险金外（还款风险金规则以本网站最新公告为准），本网站不对任何您及/或任何交易提供任何担保或条件，无论是明示、默示或法定的。本网站不能也不试图对您发布的信息进行控制，对该等信息，本网站不承担任何形式的证明、鉴定服务。本网站不能完全保证平台内容的真实性、充分性、可靠性、准确性、完整性和有效性，并且无需承担任何由此引起的法律责任。您依赖于您的独立判断进行交易，您应对其作出的判断承担全部责任。</p><p><br/></p><p>7.3以上并不能揭示您通过本网站进行交易的全部风险及市场的全部情形。您在做出交易决策前，应全面了解相关交易，谨慎决策，并自行承担全部风险。</p><p><br/></p><p><strong>8、其他</strong></p><p><br/></p><p>8.1本协议的订立、执行、解释及争议解决均适用中华人民共和国法律（不包括香港、澳门、台湾地区）。本协议条款具有可分性，部分无效不影响其它部门效力。本网站对本协议拥有最终的解释权。</p><p><br/></p><p>8.2如果你是本网站注册用户，本协议条款将对您持续有效，有效期至您注销或者被关闭账户后。</p>','agreement','',300,50),(6,'帮助中心','','帮助中心','page','帮助中心',1522409345,'<p>帮助中心</p>','help','',226,50);

/*Table structure for table `fl_payment` */

DROP TABLE IF EXISTS `fl_payment`;

CREATE TABLE `fl_payment` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pay_code` varchar(20) NOT NULL DEFAULT '' COMMENT '支付方式的英文缩写',
  `pay_name` varchar(100) NOT NULL DEFAULT '' COMMENT '支付方式名称',
  `pay_fee` decimal(10,1) unsigned NOT NULL DEFAULT '0.0' COMMENT '支付费用',
  `pay_des` text COMMENT '支付方式描述',
  `pay_config` text COMMENT '支付方式的配置信息,包括商户号和密钥什么的',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否可用;0否;1是',
  `listorder` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`id`),
  UNIQUE KEY `pay_code` (`pay_code`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='支付方式表';

/*Data for the table `fl_payment` */

insert  into `fl_payment`(`id`,`pay_code`,`pay_name`,`pay_fee`,`pay_des`,`pay_config`,`status`,`listorder`) values (1,'balance','余额支付','0.0','使用帐户余额支付。只有会员才能使用，通过设置信用额度，可以透支。','a:0:{}',1,0),(2,'weixin','微信','0.0','微信','a:0:{}',1,0),(3,'alipay','支付宝','0.0','支付宝','a:0:{}',1,0),(4,'cod','货到付款','0.0','开通城市：×××\r\n货到付款区域：×××','a:0:{}',0,0),(5,'bank','银行汇款/转帐','0.0','银行名称\r\n收款人信息：全称 ××× ；帐号或地址 ××× ；开户行 ×××。\r\n注意事项：办理电汇时，请在电汇单“汇款用途”一栏处注明您的订单号。','a:0:{}',0,0);

/*Table structure for table `fl_refund` */

DROP TABLE IF EXISTS `fl_refund`;

CREATE TABLE `fl_refund` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '售后编号',
  `order_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '订单id',
  `goods_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '商品id',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `add_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '退货申请时间',
  `check_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '退款审核时间',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0申请退款，1同意，2不同意',
  `type` varchar(30) NOT NULL DEFAULT '' COMMENT '售后类型：仅退款，退货退款',
  `money` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '退款金额',
  `des` varchar(250) NOT NULL DEFAULT '' COMMENT '退款说明',
  `reason` varchar(60) NOT NULL DEFAULT '' COMMENT '退款原因',
  `shipping_sn` varchar(60) NOT NULL DEFAULT '' COMMENT '快递单号',
  `shipping_name` varchar(30) NOT NULL DEFAULT '' COMMENT '快递公司',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='退款申请表';

/*Data for the table `fl_refund` */

/*Table structure for table `fl_search` */

DROP TABLE IF EXISTS `fl_search`;

CREATE TABLE `fl_search` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(36) NOT NULL DEFAULT '' COMMENT '搜索词名称',
  `title` varchar(60) NOT NULL DEFAULT '' COMMENT 'seo标题',
  `description` varchar(150) NOT NULL DEFAULT '' COMMENT '描述',
  `content` text COMMENT '内容',
  `pubdate` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `keywords` varchar(100) NOT NULL DEFAULT '' COMMENT '关键词',
  `click` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '点击量',
  `litpic` varchar(100) NOT NULL DEFAULT '' COMMENT '缩略图或封面',
  `template` varchar(30) NOT NULL DEFAULT '' COMMENT '模板名称',
  `filename` varchar(60) NOT NULL DEFAULT '' COMMENT '别名',
  `ischeck` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否审核，默认0未审核',
  `showaway` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '显示方式，默认0显示列表，1显示文章',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='搜索词表';

/*Data for the table `fl_search` */

insert  into `fl_search`(`id`,`name`,`title`,`description`,`content`,`pubdate`,`keywords`,`click`,`litpic`,`template`,`filename`,`ischeck`,`showaway`) values (1,'全本小说','全本小说_免费全本小说_全本免费小说_好看的全本小说_全本小说推荐','全本小说_免费全本小说_全本免费小说_好看的全本小说_全本小说推荐','<p>全本小说_免费全本小说_全本免费小说_好看的全本小说_全本小说推荐</p>',1486627422,'全本小说',319,'/zc/uploads/2017/02/201702091603283821.jpg','tag','quanbenxiaoshuo',0,0),(2,'星河','','','',1486643716,'',480,'/zc/uploads/2017/02/201702092035101085.jpg','tag','liuwenyang',1,0),(3,'柳文扬','','','',1486634456,'',249,'','','',0,0),(4,'凡尔纳','','','',1486634577,'',478,'','','',0,0);

/*Table structure for table `fl_searchword` */

DROP TABLE IF EXISTS `fl_searchword`;

CREATE TABLE `fl_searchword` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(36) NOT NULL DEFAULT '' COMMENT '名称',
  `title` varchar(60) NOT NULL DEFAULT '' COMMENT 'seo标题',
  `description` varchar(150) NOT NULL DEFAULT '' COMMENT '描述',
  `content` text COMMENT '内容',
  `pubdate` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `keywords` varchar(100) NOT NULL DEFAULT '' COMMENT '关键词',
  `click` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '点击量',
  `litpic` varchar(100) NOT NULL DEFAULT '' COMMENT '缩略图或封面',
  `template` varchar(30) NOT NULL DEFAULT '' COMMENT '模板名称',
  `filename` varchar(60) NOT NULL DEFAULT '' COMMENT '别名',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `fl_searchword` */

insert  into `fl_searchword`(`id`,`name`,`title`,`description`,`content`,`pubdate`,`keywords`,`click`,`litpic`,`template`,`filename`) values (1,'百度金融2','百度金融title2','百度金融description2','<p>百度金融content2</p>',1496229526,'百度金融keywords2',250,'/uploads/2017/05/201705311643481302.png','tag2','bdjr2'),(2,'李彦宏','李彦宏title','李彦宏description','<p>李彦宏content</p>',1484910609,'李彦宏keywords',361,'','tag','leo'),(3,'asd','asd','asd','<p>asdsa</p>',1496229768,'asd',209,'','tag','asd');

/*Table structure for table `fl_session` */

DROP TABLE IF EXISTS `fl_session`;

CREATE TABLE `fl_session` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `session_id` varchar(250) NOT NULL COMMENT 'session_id',
  `session_expire` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '过期时间',
  `session_data` blob NOT NULL COMMENT 'session数据',
  PRIMARY KEY (`id`),
  UNIQUE KEY `session_id` (`session_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `fl_session` */

/*Table structure for table `fl_slide` */

DROP TABLE IF EXISTS `fl_slide`;

CREATE TABLE `fl_slide` (
  `id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(60) NOT NULL DEFAULT '',
  `url` varchar(100) NOT NULL DEFAULT '' COMMENT '跳转的url',
  `target` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '0_blank,1_self',
  `group_id` smallint(5) unsigned NOT NULL DEFAULT '0',
  `pic` varchar(100) NOT NULL DEFAULT '' COMMENT '图片地址',
  `listorder` int(5) unsigned NOT NULL DEFAULT '50' COMMENT '排序',
  `is_show` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否显示，默认0显示',
  `type` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '0pc，1weixin，2app，3wap',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='轮播图表';

/*Data for the table `fl_slide` */

insert  into `fl_slide`(`id`,`title`,`url`,`target`,`group_id`,`pic`,`listorder`,`is_show`,`type`) values (1,'1','http://www.baidu.com',0,0,'/uploads/2017/09/201709242246099096.jpg',0,0,1),(2,'2','http://www.sina.com',0,0,'/uploads/2017/09/201709242246091005.jpg',0,0,0),(3,'3','http://www.163.com',0,0,'/uploads/2017/09/201709242246091160.jpg',0,0,0);

/*Table structure for table `fl_sms_log` */

DROP TABLE IF EXISTS `fl_sms_log`;

CREATE TABLE `fl_sms_log` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `mobile` varchar(20) NOT NULL DEFAULT '' COMMENT '手机号',
  `text` varchar(200) NOT NULL DEFAULT '' COMMENT '发送的内容',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '1成功，2失败',
  `result` varchar(512) NOT NULL DEFAULT '' COMMENT '返回结果',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='短信发送记录表';

/*Data for the table `fl_sms_log` */

insert  into `fl_sms_log`(`id`,`mobile`,`text`,`status`,`result`,`created_at`) values (1,'15280719357','【后铺网】您在后铺商城的验证码是，千万别告诉别人哦',1,'{\"code\":0,\"msg\":\"\\u53d1\\u9001\\u6210\\u529f\",\"count\":1,\"fee\":0.05,\"unit\":\"RMB\",\"mobile\":\"15280719357\",\"sid\":16862570132}','2017-08-07 11:48:45'),(2,'15280719357','【后铺网】您的验证码是3403，有效期20分钟。',1,'{\"code\":0,\"msg\":\"\\u53d1\\u9001\\u6210\\u529f\",\"count\":1,\"fee\":0.05,\"unit\":\"RMB\",\"mobile\":\"15280719357\",\"sid\":16863109816}','2017-08-07 12:12:39'),(3,'15280719357','【后铺网】您的验证码是2429，有效期20分钟。',1,'{\"code\":0,\"msg\":\"\\u53d1\\u9001\\u6210\\u529f\",\"count\":1,\"fee\":0.05,\"unit\":\"RMB\",\"mobile\":\"15280719357\",\"sid\":16863116688}','2017-08-07 12:13:03');

/*Table structure for table `fl_special` */

DROP TABLE IF EXISTS `fl_special`;

CREATE TABLE `fl_special` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(150) NOT NULL DEFAULT '' COMMENT '标题',
  `seotitle` varchar(150) NOT NULL DEFAULT '' COMMENT 'seo标题',
  `keywords` varchar(100) NOT NULL DEFAULT '' COMMENT '关键词',
  `description` varchar(250) NOT NULL DEFAULT '' COMMENT '页面摘要信息',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  `body` text COMMENT '内容',
  `litpic` varchar(100) NOT NULL DEFAULT '' COMMENT '缩略图',
  `click` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '点击量',
  `listorder` int(5) unsigned NOT NULL DEFAULT '50' COMMENT '排序',
  `updated_at` timestamp NULL DEFAULT NULL COMMENT '更新时间',
  `cover_pic` varchar(100) NOT NULL DEFAULT '' COMMENT '封面',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='专题';

/*Data for the table `fl_special` */

insert  into `fl_special`(`id`,`title`,`seotitle`,`keywords`,`description`,`created_at`,`body`,`litpic`,`click`,`listorder`,`updated_at`,`cover_pic`) values (1,'公司简介','','公司简介','LQYCMS企业网站管理系统采用PHP+Mysql架构，全站内置了SEO搜索引擎优化机制，支持用户自定义界面语言，拥有企业网站常用的模块功能（企业简介模块、新闻模块、产品模块、下载模块、图片模块、招聘模块、在线留言、反馈系统、在线交流、友情链接、会员与权限管理）。强大灵活的后台管理功能、静态页面生成功能、个性化模块添加功能、不同栏目自定义FLASH样式功能等可为企业打造出大气漂亮且具有营销力的','0000-00-00 00:00:00','<p>我们专注于网络信息化及网络营销领域，通过整合团队专业的市场营销理念与网络技术为客户提供优质的网络营销服务。</p><p><br/></p><p>我们的主要业务包括：网站系统开发、网站建设、网站推广、空间域名以及网络营销策划与运行。</p><p><br/></p><p>我们主打产品——LQYCMS企业网站管理系统采用PHP+Mysql架构，全站内置了SEO搜索引擎优化机制，支持用户自定义界面语言，拥有企业网站常用的模块功能（企业简介模块、新闻模块、产品模块、下载模块、图片模块、招聘模块、在线留言、反馈系统、在线交流、友情链接、会员与权限管理）。强大灵活的后台管理功能、静态页面生成功能、个性化模块添加功能、不同栏目自定义FLASH样式功能等可为企业打造出大气漂亮且具有营销力的精品网站。</p><p><br/></p><p>我们秉承“为合作伙伴创造价值”的核心价值观，并以“诚实、宽容、创新、服务”为企业精神，通过自主创新和真诚合作为电子商务及信息服务行业创造价值。</p><p><br/></p><p><strong>关于“为合作伙伴创造价值”</strong></p><p><br/></p><p>我们认为客户、供应商、公司股东、公司员工等一切和自身有合作关系的单位和个人都是自己的合作伙伴，并只有通过努力为合作伙伴创造价值，才能体现自身的价值并获得发展和成功。</p><p><br/></p><p><strong>关于“诚实、宽容、创新、服务”</strong></p><p><br/></p><p>我们认为诚信是一切合作的基础，宽容是解决问题的前提，创新是发展事业的利器，服务是创造价值的根本。</p>','',393,50,'2018-03-27 16:47:57',''),(2,'联系我们','','','','0000-00-00 00:00:00','<p>XX有限公司</p><p>地址：XX市XX区XXX号XXX栋XXX房</p><p>电话：0000-888888 13300000000</p><p>Q &nbsp;Q：374861669</p><p>邮编：000000</p><p>邮箱：374861669@</p><p>网址：www.1104.org</p>','',259,50,'2018-03-27 16:47:57',''),(3,'企业文化','','','​企业文化，或称组织文化（Corporate Culture或Organizational Culture），是一个组织由其价值观、信念、仪式、符号、处事方式等组成的其特有的文化形象。','0000-00-00 00:00:00','<p>企业文化，或称组织文化（Corporate Culture或Organizational Culture），是一个组织由其价值观、信念、仪式、符号、处事方式等组成的其特有的文化形象。<br/></p><p><br/></p><p>职工文化，也称企业职工文化，是与企业文化相对应的文化形态，职工文化以职工为本，是一种素质文化，企业文化以企业为本，是一种管理文化。</p><p>企业文化是在一定的条件下，企业生产经营和管理活动中所创造的具有该企业特色的精神财富和物质形态。它包括文化观念、价值观念、企业精神、道德规范、行为准则、历史传统、企业制度、文化环境、企业产品等。其中价值观是企业文化的核心。</p><p><br/></p><p>企业文化是企业的灵魂，是推动企业发展的不竭动力。它包含着非常丰富的内容，其核心是企业的精神和价值观。这里的价值观不是泛指企业管理中的各种文化现象，而是企业或企业中的员工在从事商品生产与经营中所持有的价值观念。</p>','',264,50,'2018-03-27 16:47:57',''),(4,'招贤纳士','','','','0000-00-00 00:00:00','<p><strong>PHP技术支持</strong></p><p><br/></p><p>主要工作内容：</p><p>1. 负责MetInfo企业网站管理系统技术支持；</p><p>2. 为客服人员提供技术支持；</p><p>&nbsp;</p><p>岗位要求：&nbsp;</p><p><br/></p><p>php能看懂且对PHP感兴趣，理解面向对象基本概念，写过一些小程序；</p><p>懂MySql数据库备份、恢复等基本操作，熟悉PHP环境的搭建和配置；</p><p>javascript能看懂，了解jquery等js框架；</p><p>html/css会写，懂linux的优先；</p><p>擅长网上查找资料解决问题；</p><p>有PHP作品（留言板，blog等）的优先；</p><p>做事要有耐心，性格谦和，学习能力强，能吃苦耐劳，愿意同公司共同发展。</p><p>如果你对我们的职位感兴趣，且符合我们的基本要求，请将个人简历投递至xxx@qq.com，或者直接与我们取得联系！</p><p><br/></p><p><br/></p><p><strong>网络销售</strong></p><p><br/></p><p>大专以上学历，一年以上网络销售经验；</p><p>熟悉网络推广，熟悉网站建设基本流程；</p><p>有网站制作相关工作经验者优先；</p><p>学习能力强，能吃苦耐劳，愿意同公司共同发展；</p><p>本岗位招收兼职，投递简历时请说明自己的工作意愿；</p><p>如果你对我们的职位感兴趣，且符合我们的基本要求，请将个人简历投递至xxx@qq.com，或者直接与我们取得联系！</p><p><br/></p><p><br/></p><p><strong>网页UI设计师</strong></p><p><br/></p><p>主要工作内容：负责MetInfo界面和公司网站的界面设计等，重视用户体验。</p><p><br/></p><p>岗位要求：</p><p>视觉设计、平面设计或美术相关专业，大专以上学历。</p><p>具有良好的创意设计能力及良好的色彩感，有较高的美术功底，较强的网页设计能力和整体布局感。</p><p>精通photoshop、Illustrator、Fireworks、Dreamweaver等图形设计工具中至少两种。</p><p>了解网页交互设计知识，对作品有不断追求完美的精神特质。</p><p>有网站UI设计同等职位工作经验、能提供过往作品者优先。</p>','',460,50,'2018-03-27 16:47:57','');

/*Table structure for table `fl_tagindex` */

DROP TABLE IF EXISTS `fl_tagindex`;

CREATE TABLE `fl_tagindex` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `tag` varchar(36) NOT NULL DEFAULT '' COMMENT '标签名称',
  `title` varchar(60) NOT NULL DEFAULT '' COMMENT 'seo标题',
  `description` varchar(150) NOT NULL DEFAULT '' COMMENT '描述',
  `content` text COMMENT '内容',
  `pubdate` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `keywords` varchar(100) NOT NULL DEFAULT '' COMMENT '关键词',
  `click` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '点击量',
  `litpic` varchar(100) NOT NULL DEFAULT '' COMMENT '缩略图或封面',
  `template` varchar(30) NOT NULL DEFAULT '' COMMENT '模板名称',
  `filename` varchar(60) NOT NULL DEFAULT '' COMMENT '别名',
  `ischeck` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否审核，默认0审核',
  PRIMARY KEY (`id`),
  UNIQUE KEY `tag` (`tag`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='tag标签表';

/*Data for the table `fl_tagindex` */

insert  into `fl_tagindex`(`id`,`tag`,`title`,`description`,`content`,`pubdate`,`keywords`,`click`,`litpic`,`template`,`filename`,`ischeck`) values (1,'百度金融2','百度金融title2','百度金融description2','<p>百度金融content2</p>',1496229526,'百度金融keywords2',250,'/uploads/2017/05/201705311643481302.png','tag2','bdjr2',0),(2,'李彦宏','李彦宏title','李彦宏description','<p>李彦宏content</p>',1484910609,'李彦宏keywords',361,'','tag','leo',0),(3,'asd','asd','asd','<p>asdsa</p>',1496229768,'asd',209,'','tag','asd',1);

/*Table structure for table `fl_taglist` */

DROP TABLE IF EXISTS `fl_taglist`;

CREATE TABLE `fl_taglist` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `tid` int(11) unsigned NOT NULL COMMENT '标签id',
  `aid` int(11) unsigned NOT NULL COMMENT '文章id',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_tid_aid` (`tid`,`aid`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='tag标签-文章关系表';

/*Data for the table `fl_taglist` */

insert  into `fl_taglist`(`id`,`tid`,`aid`) values (1,1,2),(2,1,5),(3,1,13),(4,2,10),(5,2,12);

/*Table structure for table `fl_token` */

DROP TABLE IF EXISTS `fl_token`;

CREATE TABLE `fl_token` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `token` varchar(128) NOT NULL DEFAULT '',
  `type` tinyint(4) unsigned NOT NULL DEFAULT '0' COMMENT '0:app, 1:admin, 2:weixin, 3:wap, 4: pc',
  `uid` int(11) unsigned NOT NULL DEFAULT '0',
  `data` text COMMENT 'token相关信息,json_encode字串',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `expired_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='token表';

/*Data for the table `fl_token` */

insert  into `fl_token`(`id`,`token`,`type`,`uid`,`data`,`created_at`,`expired_at`) values (1,'72d623d26a1a6d61186a97f9ccf752f7',1,1,'','2017-08-07 13:29:01','2018-05-22 11:15:27'),(2,'70a0c1ba8fb4a4c394dd2bdf7d6106ec',2,3,'','2018-03-09 12:22:03','2018-04-08 12:22:03'),(3,'0ecd2dd522d64f10d39ba95d4fb6adc2',2,3,'','2018-03-30 14:38:19','2018-04-29 14:38:19'),(4,'1f23ce0f617ea608ce69ba826169ab95',2,3,'','2018-04-08 10:34:19','2018-05-08 10:34:19');

/*Table structure for table `fl_user` */

DROP TABLE IF EXISTS `fl_user`;

CREATE TABLE `fl_user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(60) NOT NULL DEFAULT '' COMMENT '邮箱',
  `user_name` varchar(60) NOT NULL DEFAULT '' COMMENT '用户名',
  `password` varchar(50) NOT NULL DEFAULT '' COMMENT '密码',
  `pay_password` varchar(50) NOT NULL DEFAULT '' COMMENT '支付密码',
  `head_img` varchar(255) NOT NULL DEFAULT '' COMMENT '头像',
  `sex` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '性别1男2女',
  `birthday` date NOT NULL DEFAULT '1990-01-01' COMMENT '生日',
  `commission` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '累积佣金，只增不减，单位：元',
  `money` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '用户余额，单位：元',
  `frozen_money` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '用户冻结资金，单位：元',
  `point` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户能用积分',
  `rank_points` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '会员等级积分',
  `address_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '收货信息id,表值表user_address',
  `add_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '注册时间',
  `user_rank` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '用户等级',
  `parent_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '推荐人id',
  `nickname` varchar(30) NOT NULL DEFAULT '' COMMENT '昵称',
  `mobile` varchar(20) NOT NULL DEFAULT '' COMMENT '手机号码',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '用户状态 1正常状态 2 删除至回收站 3锁定',
  `group_id` int(5) unsigned NOT NULL DEFAULT '0' COMMENT '分组',
  `updated_at` timestamp NULL DEFAULT NULL COMMENT '更新时间',
  `signin_time` timestamp NULL DEFAULT NULL COMMENT '签到时间',
  `openid` varchar(100) NOT NULL DEFAULT '' COMMENT 'openid',
  `unionid` varchar(128) NOT NULL DEFAULT '' COMMENT 'unionid',
  `push_id` varchar(30) NOT NULL DEFAULT '' COMMENT '推送id',
  `refund_account` varchar(30) NOT NULL DEFAULT '' COMMENT '退款账户，支付宝账号',
  `refund_name` varchar(20) NOT NULL DEFAULT '' COMMENT '退款姓名',
  `consumption_money` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '累计消费金额',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='会员表';

/*Data for the table `fl_user` */

insert  into `fl_user`(`id`,`email`,`user_name`,`password`,`pay_password`,`head_img`,`sex`,`birthday`,`commission`,`money`,`frozen_money`,`point`,`rank_points`,`address_id`,`add_time`,`user_rank`,`parent_id`,`nickname`,`mobile`,`status`,`group_id`,`updated_at`,`signin_time`,`openid`,`unionid`,`push_id`,`refund_account`,`refund_name`,`consumption_money`) values (1,'ecshop@ecshop.com','ecshop','e10adc3949ba59abbe56e057f20f883e','123123','/uploads/2017/06/201706041951031181.jpg',0,'1960-03-03','0.00','234.00','0.00',20,0,11,0,0,3,'','15280719355',0,0,'2018-03-27 16:55:20','2017-08-11 00:24:20','','','','','','0.00'),(2,'vip@ecshop.com','vip','e10adc3949ba59abbe56e057f20f883e','','/uploads/2017/06/201706041951031181.jpg',0,'1949-01-01','0.00','0.00','0.00',0,0,0,0,0,3,'','15280719356',2,0,'2018-03-27 16:55:20','2018-03-27 16:55:20','','','','','','0.00'),(3,'374861669@qq.com','FLi','e10adc3949ba59abbe56e057f20f883e','202cb962ac59075b964b07152d234b70','/uploads/2017/10/201710131156534963.jpeg',2,'1990-01-01','12.00','118.00','0.00',0,0,14,0,0,0,'阿什顿','15280719357',1,0,'2018-03-27 16:55:20','2018-03-27 16:55:20','','','','1234','4321','0.00'),(4,'','ockGfuLHR3lHQqBNTaTeBzPg-rNs','','','http://wx.qlogo.cn/mmopen/vi_32/tLnN9s8TMx2iaBK8gC3h62sBxQbZP9DvETG19nYyrlGgDAGVLVkJunA2bibmBvsExicP1QNYrULrAGjHAJias0vz4A/0',1,'1990-01-01','0.00','0.00','0.00',0,0,0,0,0,3,'林一峰','',1,0,'2018-03-27 16:55:20','2018-03-27 16:55:20','ockGfuLHR3lHQqBNTaTeBzPg-rNs','','','','','0.00');

/*Table structure for table `fl_user_address` */

DROP TABLE IF EXISTS `fl_user_address`;

CREATE TABLE `fl_user_address` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL DEFAULT '0',
  `name` varchar(60) NOT NULL DEFAULT '' COMMENT '收货人的名字',
  `country` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '收货人的国家',
  `province` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '收货人的省份',
  `city` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '收货人城市',
  `district` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '收货人的地区',
  `address` varchar(120) NOT NULL DEFAULT '' COMMENT '收货人的详细地址',
  `zipcode` varchar(60) NOT NULL DEFAULT '' COMMENT '收货人的邮编',
  `telphone` varchar(60) NOT NULL DEFAULT '' COMMENT '收货人的电话',
  `mobile` varchar(60) NOT NULL DEFAULT '' COMMENT '收货人的手机号',
  `is_default` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否默认,0:为非默认,1:默认',
  PRIMARY KEY (`id`),
  KEY `idx_user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='收货地址表';

/*Data for the table `fl_user_address` */

insert  into `fl_user_address`(`id`,`user_id`,`name`,`country`,`province`,`city`,`district`,`address`,`zipcode`,`telphone`,`mobile`,`is_default`) values (1,1,'刘先生',0,1,32767,72,'海兴大厦','','010-25851234','13986765412',0),(2,2,'叶先生',1,2,52,510,'通州区旗舰凯旋小区','','13588104710','',0),(4,1,'梁朝伟',0,2,32767,72,'dasd2','','','assds2',0),(8,1,'韩寒',0,1,32767,72,'师范大学','','','15280719357',0),(9,1,'范蠡',0,1,32767,72,'士大夫','','','15280719234',0),(10,1,'谢霆锋',0,16,1315,32767,'阿斯顿','','','13912356543',0),(11,1,'林逸',0,16,1332,1337,'阿斯顿','','','13912356543',1),(12,3,'Kenny G',0,1,52129,72,'阿斯达','','','15280719357',0),(13,3,'许巍',0,1,52129,2805,'东风公司','','','15280719357',0),(14,3,'李宗盛',0,16,1329,1331,'红糖100号','','','15280765456',1),(15,3,'周杰伦',0,1,52129,72,'阿斯达','','','15278765456',0);

/*Table structure for table `fl_user_bonus` */

DROP TABLE IF EXISTS `fl_user_bonus`;

CREATE TABLE `fl_user_bonus` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `bonus_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '优惠券id',
  `user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `used_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '优惠券使用的时间，0表示未使用',
  `get_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '优惠券获得时间',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0未使用1已使用2已过期',
  PRIMARY KEY (`id`),
  KEY `idx_user_id_status` (`user_id`,`status`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='用户优惠券表';

/*Data for the table `fl_user_bonus` */

insert  into `fl_user_bonus`(`id`,`bonus_id`,`user_id`,`used_time`,`get_time`,`status`) values (1,1,5,1242142681,0,0),(2,4,3,1511963798,0,1),(3,4,5,0,0,0),(4,2,5,0,0,0),(5,3,5,0,0,0),(6,4,0,0,0,0),(7,4,0,0,0,0),(8,4,0,0,0,0),(9,4,0,0,0,0),(10,4,0,0,0,0),(11,4,0,0,0,0),(24,3,1,0,0,0),(25,3,1,0,0,0),(26,3,1,0,0,0),(27,3,1,0,0,0),(28,3,1,0,0,0),(29,3,1,0,0,0),(30,3,1,0,0,0),(31,3,1,0,0,0),(32,1,1,0,0,0),(33,3,3,0,1512660179,0),(34,2,3,0,1512660192,0);

/*Table structure for table `fl_user_goods_history` */

DROP TABLE IF EXISTS `fl_user_goods_history`;

CREATE TABLE `fl_user_goods_history` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `goods_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '商品ID',
  `user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '会员ID',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '浏览时间',
  PRIMARY KEY (`id`),
  KEY `idx_user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='商品浏览历史表';

/*Data for the table `fl_user_goods_history` */

insert  into `fl_user_goods_history`(`id`,`goods_id`,`user_id`,`add_time`) values (1,3,3,1512211519),(2,2,3,1512213451),(3,1,3,1512234528),(4,4,3,1513089678),(5,5,3,1523438828);

/*Table structure for table `fl_user_message` */

DROP TABLE IF EXISTS `fl_user_message`;

CREATE TABLE `fl_user_message` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户id，如果id为0表示所有人',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '系统消息0，活动消息',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '查看状态：0未查看，1已查看',
  `title` varchar(150) NOT NULL DEFAULT '' COMMENT '标题',
  `des` varchar(250) NOT NULL DEFAULT '' COMMENT '说明',
  `litpic` varchar(100) NOT NULL DEFAULT '' COMMENT '缩略图',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  PRIMARY KEY (`id`),
  KEY `idx_user_id_status_type` (`user_id`,`status`,`type`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='用户消息表';

/*Data for the table `fl_user_message` */

insert  into `fl_user_message`(`id`,`user_id`,`type`,`status`,`title`,`des`,`litpic`,`add_time`) values (1,0,0,0,'保修结果反馈','啥地方撒旦啥地方撒旦啥地方撒旦啥地方撒旦啥地方撒旦啥地方撒旦啥地方撒旦','',1511963795),(2,3,1,0,'认证通知','士大夫撒旦官方店士大夫撒旦官方店士大夫撒旦官方店士大夫撒旦官方店士大夫撒旦官方店士大夫撒旦官方店','',1511963796),(3,3,0,0,'暂时无法修改头像和昵称','阿萨德股份三阿萨德股份三大阿萨德股份三大阿萨德股份三大阿萨德股份三大阿萨德股份三大','',1511963797),(4,1,0,0,'立即用处4','电风扇归属地电风扇归属地电风扇归属地电风扇归属地电风扇归属地','',1511963798),(5,0,0,0,'立即用处5','阿萨德股份三阿萨德股份三大阿萨德股份三大阿萨德股份三大阿萨德股份三大阿萨德股份三大','',1511963798),(6,3,2,0,'立即用处6','阿萨德股份三阿萨德股份三大阿萨德股份三大阿萨德股份三大阿萨德股份三大阿萨德股份三大','',1511963798),(7,3,1,0,'立即用处7','阿萨德股份三阿萨德股份三大阿萨德股份三大阿萨德股份三大阿萨德股份三大阿萨德股份三大','',1511963798),(8,3,0,0,'立即用处8','阿萨德股份三阿萨德股份三大阿萨德股份三大阿萨德股份三大阿萨德股份三大阿萨德股份三大','',1511963798);

/*Table structure for table `fl_user_money` */

DROP TABLE IF EXISTS `fl_user_money`;

CREATE TABLE `fl_user_money` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL DEFAULT '0',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0增加,1减少',
  `money` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '金额',
  `add_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `des` varchar(100) NOT NULL DEFAULT '' COMMENT '描述',
  `user_money` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '余额，每次增减后面的金额记录',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='用户余额明细';

/*Data for the table `fl_user_money` */

insert  into `fl_user_money`(`id`,`user_id`,`type`,`money`,`add_time`,`des`,`user_money`) values (1,1,0,'12.00',1502158888,'微信转账','23.00'),(2,1,1,'23.00',1502158888,'士大夫','34.00'),(3,3,1,'5.00',1513089694,'订单余额支付','118.00'),(4,3,0,'0.00',1514200726,'退货-返余额','118.00'),(5,3,0,'0.00',1514201382,'退货-返余额','118.00'),(6,3,0,'0.00',1514201562,'退货-返余额','118.00');

/*Table structure for table `fl_user_point` */

DROP TABLE IF EXISTS `fl_user_point`;

CREATE TABLE `fl_user_point` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL DEFAULT '0',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0增加,1减少',
  `point` int(6) unsigned NOT NULL DEFAULT '0' COMMENT '积分',
  `add_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `des` varchar(250) NOT NULL DEFAULT '' COMMENT '备注',
  `user_point` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '每次增减后的积分',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='用户积分明细';

/*Data for the table `fl_user_point` */

insert  into `fl_user_point`(`id`,`user_id`,`type`,`point`,`add_time`,`des`,`user_point`) values (1,1,1,82,1502158888,'等等',1),(2,1,0,82,1502158912,'林路',2),(3,1,1,5,1502158888,'签到',3),(4,1,1,5,1502158888,'签到',4),(5,1,1,5,1502158888,'签到',5),(6,1,1,5,1502158888,'签到',1);

/*Table structure for table `fl_user_rank` */

DROP TABLE IF EXISTS `fl_user_rank`;

CREATE TABLE `fl_user_rank` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(30) NOT NULL DEFAULT '' COMMENT '会员等级名称',
  `min_points` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '该等级的最低积分',
  `max_points` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '该等级的最高积分',
  `discount` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '该会员等级的商品折扣',
  `listorder` int(5) unsigned NOT NULL DEFAULT '50' COMMENT '排序',
  `rank` int(5) unsigned NOT NULL DEFAULT '0' COMMENT '等级',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='用户等级表';

/*Data for the table `fl_user_rank` */

insert  into `fl_user_rank`(`id`,`title`,`min_points`,`max_points`,`discount`,`listorder`,`rank`) values (1,'注册用户',0,10000,100,50,0),(2,'vip',10000,10000000,95,50,0),(3,'代销用户',0,0,90,50,0);

/*Table structure for table `fl_user_recharge` */

DROP TABLE IF EXISTS `fl_user_recharge`;

CREATE TABLE `fl_user_recharge` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `money` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '充值金额',
  `pay_time` timestamp NULL DEFAULT NULL COMMENT '充值时间',
  `pay_type` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '充值类型：1微信，2支付宝',
  `pay_money` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '支付金额',
  `trade_no` varchar(50) NOT NULL DEFAULT '' COMMENT '支付流水号',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '充值状态：0未处理，1已完成，2失败',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `recharge_sn` varchar(60) NOT NULL DEFAULT '' COMMENT '支付订单号',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='用户在线充值明细表';

/*Data for the table `fl_user_recharge` */

insert  into `fl_user_recharge`(`id`,`user_id`,`money`,`pay_time`,`pay_type`,`pay_money`,`trade_no`,`status`,`created_at`,`updated_at`,`recharge_sn`) values (1,1,'1.00','2018-03-27 16:58:44',1,'0.00','',0,'2017-11-08 00:41:13','2018-03-27 16:58:44',''),(2,1,'123.00','2018-03-27 16:58:44',1,'0.00','',0,'2017-11-08 01:00:21','2018-03-27 16:58:44',''),(3,1,'123.00','2018-03-27 16:58:44',1,'0.00','',0,'2017-11-08 20:07:25','2018-03-27 16:58:44',''),(4,1,'123.00','2018-03-27 16:58:44',1,'0.00','',0,'2017-11-08 20:08:19','2018-03-27 16:58:44',''),(5,1,'1.00','2018-03-27 16:58:44',1,'0.00','',0,'2017-11-08 20:08:29','2018-03-27 16:58:44',''),(6,1,'2.00','2018-03-27 16:58:44',1,'0.00','',0,'2017-11-08 22:22:23','2018-03-27 16:58:44','');

/*Table structure for table `fl_user_withdraw` */

DROP TABLE IF EXISTS `fl_user_withdraw`;

CREATE TABLE `fl_user_withdraw` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '时间',
  `money` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '金额',
  `name` varchar(30) NOT NULL DEFAULT '' COMMENT '姓名',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0未处理,1处理中,2成功,3取消，4拒绝',
  `note` varchar(250) NOT NULL DEFAULT '' COMMENT '用户备注',
  `re_note` varchar(250) NOT NULL DEFAULT '' COMMENT '回复备注信息',
  `bank_name` varchar(30) NOT NULL DEFAULT '' COMMENT '银行名称',
  `bank_place` varchar(150) NOT NULL DEFAULT '' COMMENT '开户行',
  `account` varchar(30) NOT NULL DEFAULT '' COMMENT '支付宝账号或者银行卡号',
  `method` varchar(20) NOT NULL DEFAULT '' COMMENT '提现方式，weixin，bank，alipay',
  `is_delete` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否删除，1删除',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='提现记录';

/*Data for the table `fl_user_withdraw` */

insert  into `fl_user_withdraw`(`id`,`user_id`,`add_time`,`money`,`name`,`status`,`note`,`re_note`,`bank_name`,`bank_place`,`account`,`method`,`is_delete`) values (2,3,1513082451,'1.00','asda',4,'','','','','1feng.2008','alipay',0),(3,3,1513082615,'100.00','qweqeqw',4,'','','asd','dfs','admin888','alipay',0),(4,3,1,'1.00','asd',2,'','','asfas','asd','asf','alipay',0);

/*Table structure for table `fl_verify_code` */

DROP TABLE IF EXISTS `fl_verify_code`;

CREATE TABLE `fl_verify_code` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(10) NOT NULL DEFAULT '' COMMENT '验证码',
  `type` tinyint(4) unsigned NOT NULL DEFAULT '0' COMMENT '0通用，注册，1:手机绑定业务验证码，2:密码修改业务验证码',
  `mobile` varchar(20) NOT NULL DEFAULT '' COMMENT '手机号',
  `status` tinyint(4) unsigned NOT NULL DEFAULT '0' COMMENT '0:未使用 1:已使用',
  `expired_at` timestamp NULL DEFAULT NULL COMMENT '过期时间',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='验证码记录表';

/*Data for the table `fl_verify_code` */

insert  into `fl_verify_code`(`id`,`code`,`type`,`mobile`,`status`,`expired_at`,`created_at`) values (1,'9669',1,'15280719357',0,'2017-09-08 15:30:15','2017-08-08 15:30:15');

/*Table structure for table `fl_weixin_menu` */

DROP TABLE IF EXISTS `fl_weixin_menu`;

CREATE TABLE `fl_weixin_menu` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '父级菜单id',
  `addtime` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `name` varchar(30) NOT NULL DEFAULT '' COMMENT '菜单标题，不超过16个字节，子菜单不超过60个字节',
  `type` varchar(30) NOT NULL DEFAULT '' COMMENT '菜单的响应动作类型，view表示网页类型，click表示点击，miniprogram表示小程序',
  `key` varchar(60) NOT NULL DEFAULT '' COMMENT '菜单KEY值，用于消息接口推送，不超过128字节，click等点击类型必须',
  `url` varchar(255) NOT NULL DEFAULT '' COMMENT '网页链接，用户点击菜单可打开链接，不超过1024字节。view、miniprogram类型必须，type为miniprogram时，不支持小程序的老版本客户端将打开本url。',
  `media_id` varchar(60) NOT NULL DEFAULT '' COMMENT '调用新增永久素材接口返回的合法media_id，media_id类型和view_limited类型必须',
  `appid` varchar(150) NOT NULL DEFAULT '' COMMENT '小程序的appid（仅认证公众号可配置），miniprogram类型必须',
  `pagepath` varchar(255) NOT NULL DEFAULT '' COMMENT '小程序的页面路径，miniprogram类型必须',
  `litpic` varchar(100) NOT NULL DEFAULT '' COMMENT '封面或缩略图',
  `listorder` int(5) unsigned NOT NULL DEFAULT '50' COMMENT '排序',
  `is_show` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否显示，默认0显示',
  PRIMARY KEY (`id`),
  UNIQUE KEY `IndexNameUnique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='微信菜单表';

/*Data for the table `fl_weixin_menu` */

insert  into `fl_weixin_menu`(`id`,`pid`,`addtime`,`name`,`type`,`key`,`url`,`media_id`,`appid`,`pagepath`,`litpic`,`listorder`,`is_show`) values (1,0,1510371034,'新闻中心','click','V2_GOOD','','','','','',50,0),(2,0,1476063429,'案例中心','click','V1002_GOOD','','','','','',50,0),(3,1,1476063419,'行业新闻','view','','http://www.sina.com','','','','',50,0),(4,1,1476068069,'企业新闻','view','','https://www.baidu.com','','','','',50,0),(5,2,1510295902,'奥术大师','view','qwe','http://www.baidu.com','asdf','dsfhgf','gfhjgf','',50,0);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
