<?php

/*
|--------------------------------------------------------------------------
| Backend
|--------------------------------------------------------------------------
*/

Route::group([
    'namespace' => 'Backend',
    'prefix' => 'admin',
    'middleware' => ['auth']
], function(){
    //Dashboard
    Route::get('/', 'DashboardController@index')->name('backend.dashboard');

    //User
    Route::resource('/users', 'UserController');
    Route::post('/users/edit-profile/{id}', 'UserController@editProfile')->name('users.editProfile');
    Route::post('/users/change-password/{id}', 'UserController@changePassword')->name('users.changePassword');
    Route::post('/users/change-status/{id}', 'UserController@changeStatus')->name('users.changeStatus');
    Route::post('/users/restore/{id}', 'UserController@restore')->name('users.restore');
    Route::delete('/users/force-delete/{id}', 'UserController@forceDestroy')->name('users.forceDestroy');
    Route::post('/users/delete-image/{id}', 'UserController@destroyImage')->name('users.destroyImage');

    //Role
    Route::resource('roles', 'RoleController');

    //Menu
    Route::resource('menus', 'MenuController');
    Route::post('/menus/change-status/{id}', 'MenuController@changeStatus')->name('menus.changeStatus');
    Route::post('/menus/restore/{id}', 'MenuController@restore')->name('menus.restore');
    Route::delete('/menus/force-delete/{id}', 'MenuController@forceDestroy')->name('menus.forceDestroy');

    //Slider
    Route::resource('/sliders', 'SliderController');
    Route::post('/sliders/change-status/{id}', 'SliderController@changeStatus')->name('sliders.changeStatus');
    Route::post('/sliders/restore/{id}', 'SliderController@restore')->name('sliders.restore');
    Route::delete('/sliders/force-delete/{id}', 'SliderController@forceDestroy')->name('sliders.forceDestroy');
    Route::post('/sliders/delete-image/{id}', 'SliderController@destroyImage')->name('sliders.destroyImage');

    //Gallery
    Route::resource('/galleries', 'GalleryController');
    Route::post('/galleries/change-status/{id}', 'GalleryController@changeStatus')->name('galleries.changeStatus');
    Route::post('/galleries/restore/{id}', 'GalleryController@restore')->name('galleries.restore');
    Route::delete('/galleries/force-delete/{id}', 'GalleryController@forceDestroy')->name('galleries.forceDestroy');
    
    //Gallery Images
    Route::get('/galleries/{gallerySlug}/images', 'GalleryController@addImages')->name('galleries.addImages');
    Route::post('/galleries/{galleryId}/images/add', 'GalleryController@saveImages')->name('galleries.saveImages');
    Route::post('/galleries/{galleryId}/images/destory/{imageId}', 'GalleryController@destoryImages')->name('galleries.destroyImages');

    //Single Page
    Route::resource('/single-page', 'SinglePageController');
    Route::post('/single-page/change-status/{id}', 'SinglePageController@changeStatus')->name('single-page.changeStatus');
    Route::post('/single-page/restore/{id}', 'SinglePageController@restore')->name('single-page.restore');
    Route::delete('/single-page/force-delete/{id}', 'SinglePageController@forceDestroy')->name('single-page.forceDestroy');
    Route::post('/single-page/delete-file/{id}', 'SinglePageController@destroyFile')->name('single-page.destroyFile');

    //Page Type
    //List Page
    Route::resource('/page-types', 'PageTypeController');
    Route::post('/page-types/change-status/{id}', 'PageTypeController@changeStatus')->name('page-types.changeStatus');
    Route::post('/page-types/restore/{id}', 'PageTypeController@restore')->name('page-types.restore');
    Route::delete('/page-types/force-delete/{id}', 'PageTypeController@forceDestroy')->name('page-types.forceDestroy');
    //List Page
    Route::group([
        'prefix' => '{page_type}/'
    ], function(){
        Route::resource('list-page', 'ListPageController');
        Route::post('/list-page/change-status/{id}', 'ListPageController@changeStatus')->name('list-page.changeStatus');
        Route::post('/list-page/restore/{id}', 'ListPageController@restore')->name('list-page.restore');
        Route::delete('/list-page/force-delete/{id}', 'ListPageController@forceDestroy')->name('list-page.forceDestroy');
    });
    Route::post('/list-page/delete-file/{id}', 'ListPageController@destroyFile')->name('list-page.destroyFile');

    //Category
    Route::resource('/categories', 'CategoryController');
    Route::post('/categories/change-status/{id}', 'CategoryController@changeStatus')->name('categories.changeStatus');
    Route::post('/categories/restore/{id}', 'CategoryController@restore')->name('categories.restore');
    Route::delete('/categories/force-delete/{id}', 'CategoryController@forceDestroy')->name('categories.forceDestroy');

    //Tag
    Route::resource('/tags', 'TagController');
    Route::post('/tags/change-status/{id}', 'TagController@changeStatus')->name('tags.changeStatus');
    Route::post('/tags/restore/{id}', 'TagController@restore')->name('tags.restore');
    Route::delete('/tags/force-delete/{id}', 'TagController@forceDestroy')->name('tags.forceDestroy');

    //Important Link
    Route::resource('/important-links', 'ImportantLinkController');
    Route::post('/important-links/change-status/{id}', 'ImportantLinkController@changeStatus')->name('important-links.changeStatus');
    Route::post('/important-links/restore/{id}', 'ImportantLinkController@restore')->name('important-links.restore');
    Route::delete('/important-links/force-delete/{id}', 'ImportantLinkController@forceDestroy')->name('important-links.forceDestroy');

     //Social Media
    Route::resource('/social-medias', 'SocialMediaController');
    Route::post('/social-medias/change-status/{id}', 'SocialMediaController@changeStatus')->name('social-medias.changeStatus');
    Route::post('/social-medias/restore/{id}', 'SocialMediaController@restore')->name('social-medias.restore');
    Route::delete('/social-medias/force-delete/{id}', 'SocialMediaController@forceDestroy')->name('social-medias.forceDestroy');
    Route::post('/social-medias/delete-image/{id}', 'SocialMediaController@destroyImage')->name('social-medias.destroyImage');

    Route::get('mark-as-read', 'DashboardController@markAsRead')->name('viewer-messages.markAsRead');
});

Route::group([
    'namespace' => 'Auth',
], function(){
    Route::get('/login', 'LoginController@showLoginForm')->name('login');
    Route::post('/login', 'LoginController@login');
    Route::post('/logout', 'LoginController@logout')->name('logout');
    Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::get('password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::post('password/reset', 'ResetPasswordController@reset');
    Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset');
});

/*
|--------------------------------------------------------------------------
| Frontend
|--------------------------------------------------------------------------
*/

Route::group(['namespace' => 'Frontend'], function () {
    //Home Page
    Route::get('/', 'HomeController@index')->name('frontend.home');

    //List Page
    Route::group([
        'prefix' => '{slug}/'
    ], function(){
        Route::get('/single-page', 'PageController@singlePage')->name('frontend.singlePage');
        Route::get('/list-page', 'PageController@listPage')->name('frontend.listPage');
        Route::get('/page', 'PageController@page')->name('frontend.page');
    });
    Route::get('list-page-desc/{listPageSlug}', 'PageController@listPageDesc')->name('frontend.listPageDesc');
    Route::get('category/{categorySlug}', 'PageController@categoryListPage')->name('frontend.categoryListPage');
    Route::get('tag/{tagSlug}', 'PageController@tagListPage')->name('frontend.tagListPage');

    //Gallery
    Route::get('gallery', 'GalleryController@index')->name('gallery.index');
    Route::get('gallery/{slug}', 'GalleryController@show')->name('gallery.show');

    //Contact Us
    Route::get('contact-us', 'ContactUsController@index')->name('contact-us.index');
    Route::post('/contact-us/send', 'ContactUsController@send')->name('contact-us.send');

    Route::get('search', 'HomeController@search')->name('frontend.search');
});