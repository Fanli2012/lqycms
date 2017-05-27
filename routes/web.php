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
Route::group(['domain' => 'm.lqycms.com', 'namespace' => 'Wap'], function () {
	Route::get('/', 'IndexController@index');
	Route::get('/tags', 'IndexController@tags');
	Route::get('/search', 'IndexController@search');
	Route::get('/cat{cat}/id{id}', 'IndexController@detail');                   //详情页
	Route::get('/cat{cat}/{page}', 'IndexController@category');                 //分类页，分页
	Route::get('/cat{cat}', 'IndexController@category');                        //分类页
	Route::get('/tag{tag}/{page}', 'IndexController@tag');                      //标签页，分页
	Route::get('/tag{tag}', 'IndexController@tag');                             //标签页
	Route::get('/{id}', 'IndexController@page');                                //单页
	Route::get('/aaa', function () {
		dd('wap');
	});
});


//前台路由
Route::group(['namespace' => 'Home'], function () {
	Route::get('/', 'IndexController@index');
	Route::get('/tags', 'IndexController@tags');
	Route::get('/search', 'IndexController@search');
	Route::get('/cat{cat}/id{id}', 'IndexController@detail');                   //详情页
	Route::get('/cat{cat}/{page}', 'IndexController@category');                 //分类页，分页
	Route::get('/cat{cat}', 'IndexController@category');                        //分类页
	Route::get('/tag{tag}/{page}', 'IndexController@tag');                      //标签页，分页
	Route::get('/tag{tag}', 'IndexController@tag');                             //标签页
	Route::get('/{id}', 'IndexController@page');                                //单页
	
	Route::get('/aaa', function () {
		dd('wap');
	});
});


//后台路由
Route::group(['prefix' => 'Admin'], function () {
    Route::get('/bbb', function () {
        // 匹配 "/fladmin/users" URL
    });
});


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







