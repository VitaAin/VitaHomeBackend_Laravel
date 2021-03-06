<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::group(['middleware' => 'cors', 'prefix' => 'v1'], function () {
    // Auth
    Route::post('user/register', 'AuthController@register'); // 注册
    Route::get('verify_email', 'AuthController@verifyToken'); // 验证注册码
    Route::post('user/login', 'AuthController@login'); // 登录
    Route::get('user/logout', 'AuthController@logout'); // 登出
    Route::get('github', 'GithubLoginController@github'); // Github账号登录

    // Articles
    Route::resource('articles', 'ArticlesController'); // 文章
    Route::get('hot_articles', 'ArticlesController@hotArticles'); // 热门文章
    Route::get('search', 'ArticlesController@search'); // 搜索文章
    // Categories
    Route::resource('categories', 'CategoriesController');  // 分类
//    Route::get('categories', 'CategoriesController@index');
    // Tags
    Route::resource('tags', 'TagsController'); // 标签
    Route::get('hot_tags', 'TagsController@hotTags'); // 热门标签
    // Likes
    Route::get('articles/{article}/likes', 'ArticlesController@likes'); // 获取文章的所有点赞

    // Comments
    Route::get('articles/{article}/comments', 'CommentsController@index'); // 文章评论
    Route::get('articles/{article}/child_comments', 'CommentsController@childComments'); //获取文章的子评论
    Route::post('comments', 'CommentsController@store'); //增加文章的评论

    // User
    Route::resource('users', 'UserController');
    Route::post('edit_password', 'UserController@editPassword'); // 修改密码
    Route::post('avatar/upload', 'UserController@avatarUpload'); // 上传头像
    Route::post('edit_user_info', 'UserController@editUserInfo'); // 修改个人信息
    Route::get('users/{user}/articles', 'UserController@userArticles'); // 用户发表的文章
    Route::get('users/{user}/replies', 'UserController@userReplies'); // 用户的回复
    Route::get('users/{user}/like_articles', 'UserController@likeArticles'); // 用户的点赞文章
    Route::get('users/{user}/follow_users', 'UserController@followUsers'); // 用户的关注
    Route::get('users/{user}/images', 'UserController@userImages'); // 用户的图片
    Route::post('user_image/upload', 'UserController@userImageUpload'); // 上传用户图片
    Route::post('user_image/add', 'UserController@userImageAdd'); // 添加用户图片到库
    Route::post('user_image/delete', 'UserController@userImageDelete'); // 删除用户图片
    Route::get('article/is_like', 'LikesController@isLike'); // 用户是否点赞了一个话题
    Route::get('article/like', 'LikesController@likeThisArticle'); // 用户点赞一个话题
    Route::get('user/is_follow', 'FollowsController@isFollow'); // 用户是否关注一个用户
    Route::get('user/follow', 'FollowsController@followThisUser'); // 用户关注一个用户

    Route::get('notifications', 'NotificationsController@index'); // 获取用户的所有通知
    Route::get('notice_reply', 'NotificationsController@noticeReply'); // 获取回复通知
    Route::get('notice_follow', 'NotificationsController@noticeFollow'); // 获取关注通知
    Route::get('notice_like', 'NotificationsController@noticeLike'); // 获取点赞通知
    Route::get('notifications/read', 'NotificationsController@read'); // 通知标记为已读

    Route::get('about', 'UserController@about'); // 关于
});

/*
|--------------------------------------------------------------------------
| 后台管理的 API 接口
|--------------------------------------------------------------------------
*/
Route::group([
    'middleware' => 'cors',
    'namespace' => 'Admin',
    'prefix' => 'v1/admin',
], function () {
    Route::post('login', 'AuthController@login'); //后台登录
});

Route::group([
    'middleware' => ['cors', 'jwt.auth', 'check.permission'],
    'namespace' => 'Admin',
    'prefix' => 'v1/admin',
], function () {
    Route::get('menu', 'MenusController@getSidebarTree'); //获取后台左侧菜单
    Route::get('group_permissions', 'PermissionsController@groupPermissions'); //获取权限组
    Route::get('button_permissions', 'PermissionsController@buttonPermissions'); //获取按钮级权限
    Route::resource('roles', 'RolesController');
    Route::resource('users', 'UsersController');
    Route::resource('menus', 'MenusController');
    Route::resource('permissions', 'PermissionsController');
    Route::get('logout', 'LoginController@logout');
});
