<?php

use App\Http\Controllers\Admin\Cupone\CuponeController;
use App\Http\Controllers\Admin\Discount\DiscountController;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route; //
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\Product\BrandController;
use App\Http\Controllers\Admin\Product\ProductController;
use App\Http\Controllers\Admin\Product\CategorieController;
use App\Http\Controllers\Admin\Product\AttributeProductController;
use App\Http\Controllers\Admin\Product\ProductVariationsController;
use App\Http\Controllers\Admin\Product\ProductSpecificationsController;
use App\Http\Controllers\Admin\Product\ProductVariationsAnidadoController;
use App\Http\Controllers\Ecommerce\CartController;
use App\Http\Controllers\Ecommerce\HomeController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
|
*/

/* Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
 */

Route::group([
 
   // 'middleware' => 'auth:api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login_ecommerce', [AuthController::class, 'login_ecommerce'])->name('login_ecommerce');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('/refresh', [AuthController::class, 'refresh'])->name('refresh');
    Route::post('/me', [AuthController::class, 'me'])->name('me');
    Route::post('/verified_auth', [AuthController::class, 'verified_auth'])->name('verified_auth');

    //
    Route::post('/verified_email', [AuthController::class, 'verified_email'])->name('verified_email');
    Route::post('/verified_code', [AuthController::class, 'verified_code'])->name('verified_code');
    Route::post('/new_password', [AuthController::class, 'new_password'])->name('new_password');

});
//modelo categoria
Route:: group([
    "middleware" => "auth:api",
    "prefix" =>"admin",
], function($router){

    Route::get("categories/config",[CategorieController::class,"config"]);
    Route::resource("categories",CategorieController::class);
    Route::post("categories/{id}",[CategorieController::class,"update"]);

    Route::post("properties",[AttributeProductController::class,"store_propertie"]);
    Route::delete("properties/{id}",[AttributeProductController::class,"destroy_propertie"]);
    Route::resource("attributes",AttributeProductController::class);

    Route::resource("sliders",SliderController::class);
    Route::post("sliders/{id}",[SliderController::class,"update"]);

    Route::get("products/config",[ProductController::class,"config"]);
    Route::post("products/imagens",[ProductController::class,"imagens"]);
    Route::delete("products/imagens/{id}",[ProductController::class,"delete_imagen"]);
    Route::post("products/index",[ProductController::class,"index"]);
    Route::resource("products",ProductController::class);
    Route::post("products/{id}",[ProductController::class,"update"]);

    Route::resource("brands",BrandController::class);

    Route::get("variations/config",[ProductVariationsController::class,"config"]);

    Route::resource("variations",ProductVariationsController::class);
    Route::resource("anidado_variations",ProductVariationsAnidadoController::class);

    Route::resource("specifications",ProductSpecificationsController::class);
    Route::get("cupones/config",[CuponeController::class,"config"]);
    Route::resource("cupones",CuponeController::class);
    Route::resource("discounts",DiscountController::class);




});

Route::group([
    "prefix" => "ecommerce",
],function ($router) {
    Route::get("home",[HomeController::class,"home"]);
    Route::get("menus",[HomeController::class,"menus"]);

    Route::get("product/{slug}",[HomeController::class,"show_product"]);
    
    Route::group([
        "middleware" => 'auth:api',
    ],function($router){
        Route::resource('carts',CartController::class);
    });

});