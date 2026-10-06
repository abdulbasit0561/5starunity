<?php
use Illuminate\Foundation\Auth\AuthenticatesUsers;
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

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', 'HomeController@index');
Route::get('news', 'BlogController@index')->name('news');
Route::get('cat-news/{cat_id}', 'BlogController@cat_blogs')->name('cat-news');
Auth::routes();

Route::get('pay.php', function () {
    return view('pay');
});

    // Password Reset Routes...
    Route::get('password-reset', 'Auth\RegisterController@passwordReset');
    
    Route::get('subscription/rerun', 'Auth\RegisterController@rerunSubscription')->name('subscription.rerun');

    Route::post('change/password', 'Auth\RegisterController@changePassword')->name('change.password');
    Route::get('update/password/{token}', 'Auth\RegisterController@updatePassword')->name('update.password');
    Route::post('edit/password', 'Auth\RegisterController@editPassword')->name('edit.password');
    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::get('mail/send', 'MailController@send');
    Auth::routes(['verify' => true]);
    Route::get('article/{slug}', 'BlogController@blogDetail');
    Route::get('home1', 'HomeController@index')->name('home1');
    Route::get('ceo', 'HomeController@ceo')->name('ceo');
    Route::get('partner', 'HomeController@partner')->name('partner');
    Route::get('howitworks', 'HomeController@howitworks')->name('howitworks');
    Route::get('inventro/acadmy', 'HomeController@inventroAcadmy')->name('inventro.acadmy');
    Route::get('about-us', 'HomeController@aboutUs')->name('about-us');
    Route::get('media-info', 'HomeController@MediaInfo')->name('media-info');
    Route::get('contact-us', 'HomeController@contactUs')->name('contact-us');
    Route::post('send-query', 'HomeController@save_contact_us')->name('send-query');
    Route::get('subscribe/{verification}', 'Auth\RegisterController@subscribe')->name('subscribe');

    Route::get('lotteries', 'LotteryController@index');
    Route::get('lottery/detail/{id}', 'LotteryController@detail');

    Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
    Route::post('login', 'Auth\LoginController@login');
    Route::get('logout', 'Auth\LoginController@logout');
    Route::get('register', 'Auth\RegisterController@index')->name('register');
    Route::get('template', 'Auth\RegisterController@email_template')->name('template');
    Route::post('register/save', 'Auth\RegisterController@create')->name('register.save');
    Route::get('email/verification/{token}', 'Auth\RegisterController@verify_email');
    Route::post('ajax/states', 'Auth\RegisterController@ajaxStates');
    Route::get('lotter-of-things', 'HomeController@lotteryThings');
    Route::get('impresum', 'HomeController@impresum');
    Route::get('page/{page}', 'HomeController@pages');
    Route::post('check_email', 'Auth\RegisterController@check_email');
    Route::post('check_email', 'Auth\RegisterController@check_email')->name('check_email');
    Route::post('lottery/search', 'LotteryController@search')->name('search');

    Route::get('unsbscribe', 'HomeController@unsubscribe')->name('unsbscribe');
    Route::post('subscriptions', 'Auth\RegisterController@subscribeConfirmation')->name('subscriptions');
    
    //client side routing for logged in user
    Route::group(['middleware' => ['auth:client']], function () {
        Route::get('profile', 'UserController@profile')->name('profile')->middleware('verified');
        Route::post('change-email', 'UserController@change_mail')->name('change-email');
        

        Route::get('account-settings', 'UserController@profileUpdate')->name('account-settings');
        Route::get('profile-image', 'UserController@immage_upload')->name('profile-image');
        Route::match(['get', 'post'], 'ajax-image-upload', 'Auth\RegisterController@ajaxImage');
        Route::post('profile-update', 'UserController@update')->name('profile-update');
        Route::get('dashboard', 'UserController@index')->name('dashboard');
        Route::get('user/refer/{filters}', 'UserController@refer')->name('user.refer');
        Route::get('promotions', 'UserController@promotions')->name('promotions');
        
        Route::get('partners', 'UserController@partners')->name('partners');
        Route::get('partner/redirect/{id}', 'UserController@redirectToUrl')->name('partner.redirect');
        Route::get('recomendations', 'UserController@recomendations')->name('recomendations');
        Route::post('recomendations/save', 'UserController@savecomadation')->name('recomendations.save');
        Route::post('post-comment', 'BlogController@post_comment')->name('post-comment');
        Route::post('lottery/purchase', 'LotteryController@purchaseLottery')->name('lottery.purchase');
        Route::get('lottery/user/purchased', 'LotteryController@userPurchasedLotteries')->name('lottery.user.purchased');

        Route::get('documents', 'UserController@documentArea')->name('documents');
        Route::get('course', 'UserController@course')->name('course');
        Route::get('contacts', 'UserController@contacts')->name('contacts');
        Route::get('security', 'UserController@security')->name('security');

        Route::get('promotions', 'CompanyController@index')->name('promotions');
        Route::post('promotions/filter', 'CompanyController@search')->name('promotions.filter');
        Route::get('partner/detail/{id}', 'CompanyController@detail')->name('partner.detail');
        Route::get('partner/bonus/{id}', 'CompanyController@bonusTalerAdd')->name('partner.bonus');
        
        Route::get('wallet', 'WalletController@index')->name('wallet');
        Route::get('wallet/filter/{type}', 'WalletController@index')->name('wallets.filter');
        Route::get('lots/numbers/{id}', 'WalletController@detail')->name('lots.numbers');

        Route::post('send_inivte', 'UserController@sendInivte')->name('send_inivte');

        Route::get('kalarna', 'WalletController@kalarna')->name('kalarna');
        Route::get('paypal', 'WalletController@paypal')->name('paypal');
        Route::post('credit_card', 'WalletController@credit_card')->name('credit_card');
        
        Route::post('balance/purchase', 'WalletController@donated')->name('balance.purchase');
        Route::get('response', 'WalletController@response')->name('response');

        Route::get('profile/picture/remove', 'UserController@removePicture')->name('profile.picture.remove');
        Route::get('profile/delete', 'UserController@deleteAccount')->name('profile.delete');

    });
    Route::get('balance/capturePayment', 'WalletController@capturePayment')->name('balance.capturePayment');
    Route::get('redirectBack', 'WalletController@redirectBack')->name('redirectBack');

    //===============================================================
        ////////////////////////////////////////////////////////////
        /////////////////// Admin Routes///////////////////////////
        ///////////////////////////////////////////////////////////
    //===============================================================

    Route::group(['prefix' =>'admin','namespace'=>'Admin','as' => 'admin.','middleware' => ['admin']], function () {
        // Route::group(['prefix' =>'admin','namespace'=>'Admin','as' => 'admin.','middleware' => ['admin']], function () {
        // Route::group(['prefix' =>'admin','namespace'=>'Admin','as' => 'admin.'], function () {
            // Route::group(['prefix'=>'admin',  'middleware' => 'admin'], function(){
        //site settings
        // Auth routes are defined explicitly below with the Admin\Auth controllers;
        // laravel/ui's Route::auth() composes a doubled namespace inside this group.
        Route::get('settings', 'AdminController@index')->name('settings');
        Route::post('settings/save', 'AdminController@saveSettings')->name('settings.save');
        // Authentication Routes...
        Route::get('/', function () {
            return redirect(route("admin.login"));
        })->name('home');
        //pages routes
        Route::get('/pages', 'PageController@index')->name('pages');
        Route::get('/page/create', 'PageController@create')->name('page.create');
        Route::post('page/save', 'PageController@save')->name('page.save');
        Route::get('page/edit/{id}', 'PageController@edit')->name('page.edit');
        Route::post('page/update', 'PageController@update')->name('page.update');
        Route::get('page/delete/{id}', 'PageController@delete')->name('page.delete');

        Route::get('login', 'Auth\AdminLoginController@showLoginForm')->name('login');
        Route::post('login', 'Auth\AdminLoginController@login')->name('login.post');
        // Password Reset Routes...
        Route::get('password/reset', 'Auth\AdminForgotPasswordController@showLinkRequestForm')->name('password.request');
        Route::post('password/email', 'Auth\AdminForgotPasswordController@sendResetLinkEmail')->name('password.email');
        Route::get('dashboard', 'DashboardController@index')->name('dashboard');
        Route::get('recomandations', 'UserController@recomandations')->name('recomandations');
        
        //companies script 
        Route::get('company/create', 'CompaniesController@create')->name('company.create');
        Route::get('company', 'CompaniesController@index')->name('company');
        Route::get('company/edit/{id}', 'CompaniesController@edit')->name('company.edit');
        Route::post('company/video_thumbnail', 'CompaniesController@getYouTubeVideoId')->name('company.video_thumbnail');
        Route::post('company/save', 'CompaniesController@save')->name('company.save');
        Route::post('company/edit/save', 'CompaniesController@saveEdits')->name('company.edit.save');
        Route::get('company/delete/{id}', 'CompaniesController@delete')->name('company.delete');
        
        
        Route::get('users', 'UserController@index')->name('users');
        Route::get('user/edit', 'UserController@index')->name('user.edit');
        Route::get('users/records', 'UserController@ajaxRecords')->name('users.records');
        Route::get('user/create', 'UserController@create')->name('user.create');
        Route::get('user/documents/{id}', 'UserController@userDocuments')->name('user.documents');
        Route::get('user/documents/approve/{id}', 'UserController@approve')->name('user.documents.approve');
        Route::post('user/documents/cancel/{id}', 'UserController@cancel')->name('user.documents.cancel');
        Route::get('user/documents/download/{id}/{type}', 'UserController@download')->name('user.documents.download');
        Route::get('user/status/{id}/{status}', 'UserController@update_status')->name('user.status');
        Route::get('user/credit/history/{id}', 'UserController@creditHistory')->name('user.credit.history');
        Route::get('user/credit/filter/history/{id}/{type}', 'UserController@creditHistory')->name('user.credit.filter.history');
        Route::post('user/trans/log/{id}/', 'UserController@transLog')->name('user.trans.log');
        Route::get('user/trans/history/{id}/', 'UserController@transactionHistory')->name('user.trans.history');
        Route::get('user/account/delete', 'UserController@deleteRquest')->name('user.account.delete');
        Route::get('user/account/deleted', 'UserController@deletedAccounts')->name('user.account.deleted');

        Route::get('logout', 'Auth\AdminLoginController@logout')->name('logout');

        Route::get('category/create/{type}', 'CategoryController@addCategory')->name('category.create');
        Route::get('category/edit/category/{id}', 'CategoryController@editCategory')->name('category.edit');
        Route::get('categories/{type}', 'CategoryController@index')->name('categories');
        Route::post('category/save', 'CategoryController@saveCategory')->name('category.save');
        Route::get('category/delete/{id}/{type}', 'CategoryController@delete')->name('category.delete');
        Route::post('category/update/{id}', 'CategoryController@updateCategory')->name('category.update');

        //products routes
        Route::get('products', 'ProductController@index')->name('products');
        Route::post('ajax/check_class', 'ProductController@check_class')->name('ajax.check_class');
        Route::get('product/create', 'ProductController@create')->name('product.create');
        Route::get('product/edit/{id}', 'ProductController@edit')->name('product.edit');
        Route::post('product/save', 'ProductController@saveProduct')->name('product.save');
        Route::post('product/delete_photo', 'ProductController@deletePhoto')->name('product.delete_photo');
        Route::post('product/update/{id}', 'ProductController@update')->name('product.update');
        Route::get('product/delete/{id}', 'ProductController@delete')->name('product.delete');
        Route::get('product/category', 'ProductController@category')->name('product.category');
        Route::get('product/add/category', 'ProductController@addCategory')->name('product.add.category');
        Route::post('product/category/save', 'ProductController@saveCategory')->name('product.category.save');
        //Lottries routes
        Route::get('lotteries', 'LottryController@index')->name('lotteries');
        Route::get('lottery/create', 'LottryController@create')->name('lottery.create');
        Route::post('lottery/save', 'LottryController@save')->name('lottery.save');
        Route::get('lottery/edit/{id}', 'LottryController@edit')->name('lottery.edit');
        Route::post('lottery/update/{id}', 'LottryController@update')->name('lottery.update');
        Route::get('lottery/delete/{id}', 'LottryController@delete')->name('lottery.delete');
        Route::get('lottery/detail/{id}', 'LottryController@detail')->name('lottery.detail');

        //Blog categories routes
        Route::get('blog', 'BlogController@index')->name('blog');
        Route::get('blog/create', 'BlogController@create')->name('blog.create');
        Route::post('blog/save', 'BlogController@saveBlog')->name('blog.save');
        Route::get('blog/delete/{id}', 'BlogController@delete')->name('blog.delete');
        Route::get('blog/edit/{id}', 'BlogController@edit')->name('blog.edit');
        Route::post('blog/delete_photo', 'BlogController@deletePhoto')->name('blog.delete_photo');
        Route::post('blog/update/{id}', 'BlogController@updateBlog')->name('blog.update');
        Route::post('blog/update/image', 'BlogController@upload_editor_image')->name('blog.update.image');
        //Blog categories routes

        //Testimonial routes
        Route::get('testimonials', 'TestimonialController@index')->name('testimonials');
        Route::get('testimonials/create', 'TestimonialController@create')->name('testimonials.create');
        Route::post('testimonials/save', 'TestimonialController@save')->name('testimonials.save');
        Route::get('testimonials/edit/{id}', 'TestimonialController@edit')->name('testimonial.edit');
        Route::post('testimonials/update/{id}', 'TestimonialController@update')->name('testimonials.update');
        Route::get('testimonials/delete/{id}', 'TestimonialController@delete')->name('testimonials.delete');
        //Slider routes
        Route::get('sliders', 'SliderController@index')->name('sliders');
        Route::get('slider/create', 'SliderController@create')->name('slider.create');
        Route::post('slider/save', 'SliderController@saveSlider')->name('slider.save');
        Route::get('slider/delete/{id}', 'SliderController@deleteSlider')->name('slider.delete');
        //Contact us queries
        Route::get('contact-us', 'AdminController@contact_us')->name('contact-us');
        //Contact us queries
        Route::get('subscriptions', 'AdminController@subscriber')->name('subscriptions');
        //discount cuppons
        Route::get('cuppons', 'CupponController@index')->name('cuppons');
        Route::get('cuppons/delete/{id}', 'CupponController@delete')->name('cuppons.delete');
        Route::get('cuppon/create', 'CupponController@create')->name('cuppon.create');
        Route::post('cuppon/save', 'CupponController@save')->name('cuppon.save');
        Route::get('cuppon/edit/{id}', 'CupponController@edit')->name('cuppon.edit');
        Route::post('cuppon/update', 'CupponController@update')->name('cuppon.update');
        
        ///admin permissions system
        Route::get('new-admin', 'AdminController@create')->name('new-admin');
        Route::post('save-admin', 'AdminController@saveAdmin')->name('save-admin');
        Route::get('delete-admin/{id}', 'AdminController@delete')->name('delete-admin');
        Route::get('listing', 'AdminController@adminListing')->name('listing');
        Route::get('admin-edit/{id}', 'AdminController@edit')->name('admin-edit');
        Route::post('update-admin/{id}', 'AdminController@update')->name('update-admin');
        Route::get('roles', 'PermissionController@roles')->name('roles');
        Route::get('role/create', 'PermissionController@createRole')->name('role.create');
        Route::post('role/save', 'PermissionController@saveRole')->name('role.save');
        Route::get('role/edit/{id}', 'PermissionController@editRole')->name('role.edit');
        Route::post('role/update', 'PermissionController@updateRole')->name('role.update');
        Route::get('role/delete/{id}', 'PermissionController@deleteRole')->name('role.delete');
        Route::get('permissions/{role_id}', 'PermissionController@permissions')->name('permissions');
        Route::post('role/permissions/save', 'PermissionController@saveRolePermission')->name('role.permissions.save');

        // Routes for promotions partners
        Route::get('promotions', 'PromotionsPartnerController@index')->name('promotions');
        Route::get('promotions/create', 'PromotionsPartnerController@create')->name('promotions.create');
        Route::post('promotions/save', 'PromotionsPartnerController@save')->name('promotions.save');
        Route::get('promotions/edit/{id}', 'PromotionsPartnerController@edit')->name('promotions.edit');
        Route::get('promotions/delete/{id}', 'PromotionsPartnerController@delete')->name('promotions.delete');
        Route::post('promotions/update/{id}', 'PromotionsPartnerController@update')->name('promotions.update');
        Route::post('promotions/photo/delete', 'PromotionsPartnerController@deletePhoto')->name('promotions.photo.delete');

        //Routes for badges
        Route::get('badges', 'BadgeController@index')->name('badges');
        Route::get('badge/create', 'BadgeController@create')->name('coopration.create');
        Route::post('badge/save', 'BadgeController@save')->name('coopration.save');
        Route::post('badge/update/{id}', 'BadgeController@update')->name('coopration.update');
        Route::get('badge/edit/{id}', 'BadgeController@edit')->name('badge.edit');
        

});
