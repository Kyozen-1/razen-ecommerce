<?php

// Custom routes
Route::group(['namespace' => 'Theme\Farmart\Http\Controllers', 'middleware' => ['web', 'core']], function () {
    Route::group(apply_filters(BASE_FILTER_GROUP_PUBLIC_ROUTE, []), function () {
        Route::group([
            'prefix' => 'ajax',
            'as' => 'public.ajax.',
        ], function () {
            Route::controller('FarmartController')->group(function () {
                Route::get('search-products', [
                    'uses' => 'ajaxSearchProducts',
                    'as' => 'search-products',
                ]);

                Route::get('products', [
                    'uses' => 'ajaxGetProducts',
                    'as' => 'products',
                ]);

                Route::get('products-razen-studio', [
                    'uses' => 'ajaxGetProductRazenStudio',
                    'as' => 'products-razen-studio',
                ]);

                Route::get('products-razen-teknologi', [
                    'uses' => 'ajaxGetProductRazenTeknologi',
                    'as' => 'products-razen-teknologi',
                ]);

                Route::get('products-razen-project', [
                    'uses' => 'ajaxGetProductRazenProject',
                    'as' => 'products-razen-project',
                ]);
                Route::get('products-razen-institute', [
                    'uses' => 'ajaxGetProductRazenInstitute',
                    'as' => 'products-razen-institute',
                ]);
                Route::get('products-razen-farm', [
                    'uses' => 'ajaxGetProductRazenFarm',
                    'as' => 'products-razen-farm',
                ]);
                Route::get('products-razen-cloth', [
                    'uses' => 'ajaxGetProductRazenCloth',
                    'as' => 'products-razen-cloth',
                ]);
                Route::get('products-kolhype', [
                    'uses' => 'ajaxGetProductKolhype',
                    'as' => 'products-kolhype',
                ]);
                Route::get('products-mami-clean', [
                    'uses' => 'ajaxGetProductMamiClean',
                    'as' => 'products-mami-clean',
                ]);
                Route::get('products-razen-holiday', [
                    'uses' => 'ajaxGetProductRazenHoliday',
                    'as' => 'products-razen-holiday',
                ]);
                Route::get('products-razen-skin', [
                    'uses' => 'ajaxGetProductRazenSkin',
                    'as' => 'products-razen-skin',
                ]);

                Route::get('featured-product-categories', [
                    'uses' => 'ajaxGetFeaturedProductCategories',
                    'as' => 'featured-product-categories',
                ]);

                Route::get('featured-brands', [
                    'uses' => 'ajaxGetFeaturedBrands',
                    'as' => 'featured-brands',
                ]);

                Route::get('get-flash-sale/{id}', [
                    'uses' => 'ajaxGetFlashSale',
                    'as' => 'get-flash-sale',
                ]);

                Route::get('product-categories/products', [
                    'uses' => 'ajaxGetProductsByCategoryId',
                    'as' => 'product-category-products',
                ]);

                Route::get('featured-products', [
                    'uses' => 'ajaxGetFeaturedProducts',
                    'as' => 'featured-products',
                ]);

                Route::get('cart', [
                    'uses' => 'ajaxCart',
                    'as' => 'cart',
                ]);

                Route::get('quick-view/{id?}', [
                    'uses' => 'ajaxGetQuickView',
                    'as' => 'quick-view',
                ]);

                Route::post('add-to-wishlist/{id?}', [
                    'uses' => 'ajaxAddProductToWishlist',
                    'as' => 'add-to-wishlist',
                ]);

                Route::get('related-products/{id}', [
                    'uses' => 'ajaxGetRelatedProducts',
                    'as' => 'related-products',
                ]);

                Route::get('product-reviews/{id}', [
                    'uses' => 'ajaxGetProductReviews',
                    'as' => 'product-reviews',
                ]);

                Route::get('get-product-categories', [
                    'uses' => 'ajaxGetProductCategories',
                    'as' => 'get-product-categories',
                ]);

                Route::get('recently-viewed-products', [
                    'uses' => 'ajaxGetRecentlyViewedProducts',
                    'as' => 'recently-viewed-products',
                ]);

                Route::post('ajax/contact-seller', 'ajaxContactSeller')
                    ->name('contact-seller');
            });
        });
    });
});

Theme::routes();

Route::group(['namespace' => 'Theme\Farmart\Http\Controllers', 'middleware' => ['web', 'core']], function () {
    Route::group(apply_filters(BASE_FILTER_GROUP_PUBLIC_ROUTE, []), function () {
        Route::get('/', 'FarmartController@getIndex')
            ->name('public.index');

        Route::get('sitemap.xml', 'FarmartController@getSiteMap')
            ->name('public.sitemap');

        Route::get('{slug?}' . config('core.base.general.public_single_ending_url'), 'FarmartController@getView')
            ->name('public.single');
    });
});
