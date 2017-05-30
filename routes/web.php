<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//wap路由，要放到最前面，否则解析不到
Route::group(['domain' => env('APP_SUBDOMAIN'), 'namespace' => 'Wap'], function () {
	Route::get('/', 'IndexController@index')->name('wap_home');
	Route::get('/tags', 'IndexController@tags');
	Route::get('/search', 'IndexController@search');
	Route::get('/cat{cat}/id{id}', 'IndexController@detail');                   //详情页
	Route::get('/cat{cat}/{page}', 'IndexController@category');                 //分类页，分页
	Route::get('/cat{cat}', 'IndexController@category');                        //分类页
	Route::get('/tag{tag}/{page}', 'IndexController@tag');                      //标签页，分页
	Route::get('/tag{tag}', 'IndexController@tag');                             //标签页
	Route::get('/page/{id}', 'IndexController@singlepage')->name('wap_singlepage');                                //单页
	Route::get('/aaa', function () {
		dd('wap');
	});
});


//前台路由
Route::group(['namespace' => 'Home'], function () {
	Route::get('/', 'IndexController@index')->name('home');
	Route::get('/page404', 'IndexController@page404')->name('page404');                     //404页面
	Route::get('/tags', 'IndexController@tags')->name('tags');
	Route::get('/search', 'IndexController@search');
	Route::get('/cat{cat}/id{id}', 'IndexController@detail');                   //详情页
	Route::get('/cat{cat}/{page}', 'IndexController@category');                 //分类页，分页
	Route::get('/cat{cat}', 'IndexController@category');                        //分类页
	Route::get('/tag{tag}/{page}', 'IndexController@tag');                      //标签页，分页
	Route::get('/tag{tag}', 'IndexController@tag');                             //标签页
	Route::get('/page/{id}', 'IndexController@page')->name('page');                                //单页
	
	Route::get('/aaa', function () {
		dd('wap');
	});
});


//后台路由
Route::group(['prefix' => 'fladmin', 'namespace' => 'Admin', 'middleware' => ['web']], function () {
	Route::get('/', 'IndexController@index')->name('admin');
	//文章
	Route::get('/article', 'ArticleController@index')->name('admin_article');
	Route::get('/article/add', 'ArticleController@add')->name('admin_article_add');
	Route::post('/article/doadd', 'ArticleController@doadd')->name('admin_article_doadd');
	Route::get('/article/edit', 'ArticleController@edit')->name('admin_article_edit');
	Route::post('/article/doedit', 'ArticleController@doedit')->name('admin_article_doedit');
	Route::get('/article/del', 'ArticleController@del')->name('admin_article_del');
	Route::get('/article/repetarc', 'ArticleController@repetarc')->name('admin_article_repetarc');
	Route::get('/article/recommendarc', 'ArticleController@recommendarc')->name('admin_article_recommendarc');
	Route::get('/article/articleexists', 'ArticleController@articleexists')->name('admin_article_articleexists');
	//栏目
	Route::get('/category', 'CategoryController@index')->name('admin_category');
	Route::get('/category/add', 'CategoryController@add')->name('admin_category_add');
	Route::post('/category/doadd', 'CategoryController@doadd')->name('admin_category_doadd');
	Route::get('/category/edit', 'CategoryController@edit')->name('admin_category_edit');
	Route::post('/category/doedit', 'CategoryController@doedit')->name('admin_category_doedit');
	Route::get('/category/del', 'CategoryController@del')->name('admin_category_del');
	//单页
	Route::get('/page', 'PageController@index')->name('admin_page');
	Route::get('/page/add', 'PageController@add')->name('admin_page_add');
	Route::post('/page/doadd', 'PageController@doadd')->name('admin_page_doadd');
	Route::get('/page/edit', 'PageController@edit')->name('admin_page_edit');
	Route::post('/page/doedit', 'PageController@doedit')->name('admin_page_doedit');
	Route::get('/page/del', 'PageController@del')->name('admin_page_del');
	
	Route::get('/friendlink', 'FriendlinkController@index')->name('admin_friendlink');
	Route::get('/guestbook', 'GuestbookController@index')->name('admin_guestbook');
	Route::get('/keyword', 'KeywordController@index')->name('admin_keyword');
	Route::get('/product', 'ProductController@index')->name('admin_product');
	
	Route::get('/search', 'SearchController@index')->name('admin_search');
	Route::get('/slide', 'SlideController@index')->name('admin_slide');
	Route::get('/tag', 'TagController@index')->name('admin_tag');
	Route::get('/sysconfig', 'SysconfigController@index')->name('admin_sysconfig');
	//后台登录注销
	Route::get('/login', 'LoginController@login')->name('admin_login');
	Route::post('/dologin', 'LoginController@dologin');
	Route::get('/logout', 'LoginController@logout')->name('admin_logout');
	Route::get('/recoverpwd', 'LoginController@recoverpwd')->name('admin_recoverpwd');
	
});

Route::get('/fladmin/jump', 'Admin\IndexController@jump')->name('admin_jump');
//Route::get('/fladmin', 'Admin\IndexController@index')->name('admin');
//Route::get('/fladmin/login', 'Admin\LoginController@login')->name('admin_login');
//Route::post('/fladmin/dologin', 'Admin\LoginController@dologin');
//Route::get('/fladmin/logout', 'Admin\LoginController@logout');


//接口路由
Route::group(['prefix' => 'Api'], function () {
    Route::get('/ccc', function () {
        // 匹配 "/api/users" URL
    });
});


//中间件
Route::group(['middleware' => 'auth'], function () {
    Route::get('/qwe', function () {
        // 使用 Auth 中间件
    });

    Route::get('user/profile', function () {
        // 使用 Auth 中间件
    });
});











//https://github.com/cong5/myPersimmon
//前台
/* Route::group(['namespace' => 'App'], function () {
    Route::get('/', 'HomeController@index')->name('home');
    Route::get('/post/{flag}', 'HomeController@posts')->name('post');
    Route::get('/tags/{flag}', 'HomeController@tags')->name('tags');
    Route::get('/category/{flag}', 'HomeController@category')->name('category');
    Route::get('/feed', 'HomeController@feed');
    Route::get('/sitemap.xml', 'HomeController@siteMap');
    Route::get('/xmlrpc', 'XmlRpcController@errorMessage');
    Route::post('/xmlrpc', 'XmlRpcController@index')->name('xmlrpc');
    Route::get('/friends', 'HomeController@friends')->name('friends');
    Route::resource('/comment', 'CommentController');
    Route::get('/debug', 'HomeController@debug')->name('debug');
});

//后台
Route::group(['prefix' => 'myp', 'namespace' => 'Backend'], function () {
    Route::get('/', 'DashboardController@dashboard')->name('admin');
    Route::post('/auth/check', 'AuthController@check')->name('admin.login_check');
    Route::post('/auth/logout', 'AuthController@logout')->name('admin.logout');
    Route::post('/auth/login', 'AuthController@authenticate')->name('admin.login');
});
Route::group(['prefix' => 'myp', 'middleware' => 'auth', 'namespace' => 'Backend'], function () {
    Route::get('/dashboard/meta', 'DashboardController@meta');
    Route::get('/dashboard/shanbay', 'DashboardController@shanbay');
    Route::resource('/categorys', 'CategorysController');
    Route::resource('/posts', 'PostsController');
    Route::resource('/tags', 'TagsController');
    Route::resource('/links', 'LinksController');
    Route::resource('/options', 'OptionsController');
    Route::resource('/settings', 'SettingsController');
    Route::resource('/navigations', 'NavigationController');
    Route::resource('/uploads', 'FileController');
    Route::resource('/util', 'UtilController');
    Route::resource('/user', 'UserController');
    Route::resource('/comments', 'CommentController');
    Route::resource('/trash', 'TrashController');
}); */







