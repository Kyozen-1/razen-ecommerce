<?php

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Ecommerce\Repositories\Interfaces\FlashSaleInterface;
use Botble\Ecommerce\Repositories\Interfaces\ProductCategoryInterface;
use Botble\Faq\Repositories\Interfaces\FaqCategoryInterface;
use Botble\Theme\Supports\ThemeSupport;
use Theme\Farmart\Http\Resources\ProductCategoryResource;
use Theme\Farmart\Http\Resources\ProductCollectionResource;
use Theme\Farmart\Http\Resources\ProductRazenStudioResource;
use Theme\Farmart\Http\Resources\ProductRazenTeknologiResource;
use Theme\Farmart\Http\Resources\ProductRazenProjectResource;
use Theme\Farmart\Http\Resources\ProductRazenInstituteResource;
use Theme\Farmart\Http\Resources\ProductRazenFarmResource;
use Theme\Farmart\Http\Resources\ProductRazenClothResource;
use Theme\Farmart\Http\Resources\ProductKolhypeResource;
use Theme\Farmart\Http\Resources\ProductMamiCleanResource;
use Theme\Farmart\Http\Resources\ProductRazenHolidayResource;
use Theme\Farmart\Http\Resources\ProductRazenSkinResource;

app()->booted(function () {
    ThemeSupport::registerGoogleMapsShortcode();
    ThemeSupport::registerYoutubeShortcode();

    /**
     * @param string|null $default
     * @param string|null $size
     * @return string
     */
    function image_placeholder(?string $default = null, ?string $size = null): string
    {
        if (theme_option('lazy_load_image_enabled', 'yes') != 'yes' && $default) {
            return RvMedia::getImageUrl($default, $size);
        }

        if (! theme_option('image-placeholder')) {
            return Theme::asset()->url('images/placeholder.png');
        }

        return RvMedia::getImageUrl(theme_option('image-placeholder'));
    }

    if (is_plugin_active('simple-slider')) {
        add_filter(SIMPLE_SLIDER_VIEW_TEMPLATE, function () {
            return Theme::getThemeNamespace() . '::partials.shortcodes.sliders';
        }, 120);

        add_filter(SHORTCODE_REGISTER_CONTENT_IN_ADMIN, function ($data, $key, $attributes) {
            if ($key == 'simple-slider' && is_plugin_active('ads')) {
                $ads = AdsManager::getData(true, true);

                $defaultAutoplay = 'yes';

                return $data . Theme::partial('shortcodes.includes.autoplay-settings', compact('attributes', 'defaultAutoplay')) . Theme::partial('shortcodes.select-ads-admin-config', compact('ads', 'attributes'));
            }

            return $data;
        }, 50, 3);
    }

    if (is_plugin_active('ads')) {
        /**
         * @param string|null $key
         * @return mixed|null
         */
        function get_ads_from_key(?string $key)
        {
            if (! $key) {
                return null;
            }

            $ads = AdsManager::getData(true)->firstWhere('key', $key);

            if (! $ads || ! $ads->image) {
                return null;
            }

            return $ads;
        }

        /**
         * @param string|null $key
         * @param array $attributes
         * @return string|null
         */
        function display_ads_advanced(?string $key, array $attributes = []): ?string
        {
            $ads = get_ads_from_key($key);

            if (! $ads) {
                return null;
            }

            $image = Html::image(image_placeholder($ads->image), $ads->name, ['class' => 'lazyload', 'data-src' => RvMedia::getImageUrl($ads->image)])->toHtml();

            if ($ads->url) {
                $image = Html::link(route('public.ads-click', $ads->key), $image, array_merge($attributes, ['target' => '_blank']), null, false)
                    ->toHtml();
            } elseif ($attributes) {
                $image = Html::tag('div', $image, $attributes)->toHtml();
            }

            return $image;
        }

        add_shortcode('theme-ads', __('Theme ads'), __('Theme ads'), function ($shortcode) {
            $ads = [];
            $attributes = $shortcode->toArray();

            for ($i = 1; $i < 5; $i++) {
                if (isset($attributes['key_' . $i]) && ! empty($attributes['key_' . $i])) {
                    $ad = display_ads_advanced((string)$attributes['key_' . $i]);
                    if ($ad) {
                        $ads[] = $ad;
                    }
                }
            }

            $ads = array_filter($ads);

            return Theme::partial('shortcodes.ads.theme-ads', compact('ads'));
        });

        shortcode()->setAdminConfig('theme-ads', function ($attributes) {
            $ads = AdsManager::getData(true, true);

            return Theme::partial('shortcodes.ads.theme-ads-admin-config', compact('ads', 'attributes'));
        });
    }

    if (is_plugin_active('ecommerce')) {
        add_shortcode(
            'featured-product-categories',
            __('Featured Product Categories'),
            __('Featured Product Categories'),
            function ($shortcode) {
                return Theme::partial('shortcodes.ecommerce.featured-product-categories', compact('shortcode'));
            }
        );

        shortcode()->setAdminConfig('featured-product-categories', function ($attributes) {
            return Theme::partial('shortcodes.ecommerce.featured-product-categories-admin-config', compact('attributes'));
        });

        add_shortcode('featured-brands', __('Featured Brands'), __('Featured Brands'), function ($shortcode) {
            return Theme::partial('shortcodes.ecommerce.featured-brands', compact('shortcode'));
        });

        shortcode()->setAdminConfig('featured-brands', function ($attributes) {
            return Theme::partial('shortcodes.ecommerce.featured-brands-admin-config', compact('attributes'));
        });

        add_shortcode('flash-sale', __('Flash sale'), __('Flash sale'), function ($shortcode) {
            $flashSale = app(FlashSaleInterface::class)->getModel()
                ->where('id', $shortcode->flash_sale_id)
                ->notExpired()
                ->first();

            if (! $flashSale || ! $flashSale->products()->count()) {
                return null;
            }

            return Theme::partial('shortcodes.ecommerce.flash-sale', [
                'shortcode' => $shortcode,
                'flashSale' => $flashSale,
            ]);
        });

        shortcode()->setAdminConfig('flash-sale', function ($attributes) {
            $flashSales = app(FlashSaleInterface::class)
                ->getModel()
                ->where('status', BaseStatusEnum::PUBLISHED)
                ->notExpired()
                ->get();

            return Theme::partial('shortcodes.ecommerce.flash-sale-admin-config', compact('flashSales', 'attributes'));
        });

        // Product Collection Start
        add_shortcode(
            'product-collections',
            __('Product Collections'),
            __('Product Collections'),
            function ($shortcode) {
                $condition = [
                    'status' => BaseStatusEnum::PUBLISHED,
                ];

                if ((int)$shortcode->collection_id) {
                    $condition['id'] = (int)$shortcode->collection_id;
                }

                $productCollections = get_product_collections(
                    $condition,
                    [],
                    ['id', 'name', 'slug']
                );

                return Theme::partial('shortcodes.ecommerce.product-collections', [
                    'shortcode' => $shortcode,
                    'productCollections' => ProductCollectionResource::collection($productCollections),
                ]);
            }
        );

        shortcode()->setAdminConfig('product-collections', function ($attributes) {
            $collections = get_product_collections(
                ['status' => BaseStatusEnum::PUBLISHED],
                [],
                ['id', 'name', 'slug']
            );

            return Theme::partial('shortcodes.ecommerce.product-collections-admin-config', compact('attributes', 'collections'));
        });
        // Product Collection End

        // Product Razen Studio Start

        add_shortcode(
            'product-razen-studio',
            __('Produk Razen Studio'),
            __('Produk Razen Studio'),
            function ($shortcode) {
                $condition = [
                    'status' => BaseStatusEnum::PUBLISHED,
                ];

                if ((int)$shortcode->collection_id) {
                    $condition['id'] = (int)$shortcode->collection_id;
                }

                $productRazenStudio = get_product_razen_studio(
                    $condition,
                    [],
                    ['id', 'name', 'slug']
                );

                return Theme::partial('shortcodes.ecommerce.product-razen-studio', [
                    'shortcode' => $shortcode,
                    'productRazenStudio' => ProductRazenStudioResource::collection($productRazenStudio),
                ]);
            }
        );

        shortcode()->setAdminConfig('product-razen-studio', function ($attributes) {
            $collections = get_product_razen_studio(
                ['status' => BaseStatusEnum::PUBLISHED],
                [],
                ['id', 'name', 'slug']
            );

            return Theme::partial('shortcodes.ecommerce.product-razen-studio-admin-config', compact('attributes', 'collections'));
        });

        // Product Razen Studio End

        // Product Razen Teknologi Start

        add_shortcode(
            'product-razen-teknologi',
            __('Produk Razen Teknologi'),
            __('Produk Razen Teknologi'),
            function ($shortcode) {
                $condition = [
                    'status' => BaseStatusEnum::PUBLISHED,
                ];

                if ((int)$shortcode->collection_id) {
                    $condition['id'] = (int)$shortcode->collection_id;
                }

                $productRazenTeknologi = get_product_razen_teknologi(
                    $condition,
                    [],
                    ['id', 'name', 'slug']
                );

                return Theme::partial('shortcodes.ecommerce.product-razen-teknologi', [
                    'shortcode' => $shortcode,
                    'productRazenTeknologi' => ProductRazenTeknologiResource::collection($productRazenTeknologi),
                ]);
            }
        );

        shortcode()->setAdminConfig('product-razen-teknologi', function ($attributes) {
            $collections = get_product_razen_teknologi(
                ['status' => BaseStatusEnum::PUBLISHED],
                [],
                ['id', 'name', 'slug']
            );

            return Theme::partial('shortcodes.ecommerce.product-razen-teknologi-admin-config', compact('attributes', 'collections'));
        });

        // Product Razen Teknologi End

        // Product Razen Project Start

        add_shortcode(
            'product-razen-project',
            __('Produk Razen Project'),
            __('Produk Razen Project'),
            function ($shortcode) {
                $condition = [
                    'status' => BaseStatusEnum::PUBLISHED,
                ];

                if ((int)$shortcode->collection_id) {
                    $condition['id'] = (int)$shortcode->collection_id;
                }

                $productRazenProject = get_product_razen_project(
                    $condition,
                    [],
                    ['id', 'name', 'slug']
                );

                return Theme::partial('shortcodes.ecommerce.product-razen-project', [
                    'shortcode' => $shortcode,
                    'productRazenProject' => ProductRazenProjectResource::collection($productRazenProject),
                ]);
            }
        );

        shortcode()->setAdminConfig('product-razen-project', function ($attributes) {
            $collections = get_product_razen_project(
                ['status' => BaseStatusEnum::PUBLISHED],
                [],
                ['id', 'name', 'slug']
            );

            return Theme::partial('shortcodes.ecommerce.product-razen-project-admin-config', compact('attributes', 'collections'));
        });

        // Product Razen Project End

        // Product Razen Institute Start

        add_shortcode(
            'product-razen-institute',
            __('Produk Razen Institute'),
            __('Produk Razen Institute'),
            function ($shortcode) {
                $condition = [
                    'status' => BaseStatusEnum::PUBLISHED,
                ];

                if ((int)$shortcode->collection_id) {
                    $condition['id'] = (int)$shortcode->collection_id;
                }

                $productRazenInstitute = get_product_razen_institute(
                    $condition,
                    [],
                    ['id', 'name', 'slug']
                );

                return Theme::partial('shortcodes.ecommerce.product-razen-institute', [
                    'shortcode' => $shortcode,
                    'productRazenInstitute' => ProductRazenInstituteResource::collection($productRazenInstitute),
                ]);
            }
        );

        shortcode()->setAdminConfig('product-razen-institute', function ($attributes) {
            $collections = get_product_razen_institute(
                ['status' => BaseStatusEnum::PUBLISHED],
                [],
                ['id', 'name', 'slug']
            );

            return Theme::partial('shortcodes.ecommerce.product-razen-institute-admin-config', compact('attributes', 'collections'));
        });

        // Product Razen Institute End

        // Product Razen Farm Start

        add_shortcode(
            'product-razen-farm',
            __('Produk Razen Farm'),
            __('Produk Razen Farm'),
            function ($shortcode) {
                $condition = [
                    'status' => BaseStatusEnum::PUBLISHED,
                ];

                if ((int)$shortcode->collection_id) {
                    $condition['id'] = (int)$shortcode->collection_id;
                }

                $productRazenFarm = get_product_razen_farm(
                    $condition,
                    [],
                    ['id', 'name', 'slug']
                );

                return Theme::partial('shortcodes.ecommerce.product-razen-farm', [
                    'shortcode' => $shortcode,
                    'productRazenFarm' => ProductRazenFarmResource::collection($productRazenFarm),
                ]);
            }
        );

        shortcode()->setAdminConfig('product-razen-farm', function ($attributes) {
            $collections = get_product_razen_farm(
                ['status' => BaseStatusEnum::PUBLISHED],
                [],
                ['id', 'name', 'slug']
            );

            return Theme::partial('shortcodes.ecommerce.product-razen-farm-admin-config', compact('attributes', 'collections'));
        });

        // Product Razen Farm End

        // Product Razen Cloth Start

        add_shortcode(
            'product-razen-cloth',
            __('Produk Razen Cloth'),
            __('Produk Razen Cloth'),
            function ($shortcode) {
                $condition = [
                    'status' => BaseStatusEnum::PUBLISHED,
                ];

                if ((int)$shortcode->collection_id) {
                    $condition['id'] = (int)$shortcode->collection_id;
                }

                $productRazenCloth = get_product_razen_cloth(
                    $condition,
                    [],
                    ['id', 'name', 'slug']
                );

                return Theme::partial('shortcodes.ecommerce.product-razen-cloth', [
                    'shortcode' => $shortcode,
                    'productRazenCloth' => ProductRazenClothResource::collection($productRazenCloth),
                ]);
            }
        );

        shortcode()->setAdminConfig('product-razen-cloth', function ($attributes) {
            $collections = get_product_razen_cloth(
                ['status' => BaseStatusEnum::PUBLISHED],
                [],
                ['id', 'name', 'slug']
            );

            return Theme::partial('shortcodes.ecommerce.product-razen-cloth-admin-config', compact('attributes', 'collections'));
        });

        // Product Razen Cloth End

        // Product Kolhype Start

        add_shortcode(
            'product-kolhype',
            __('Produk Kolhype'),
            __('Produk Kolhype'),
            function ($shortcode) {
                $condition = [
                    'status' => BaseStatusEnum::PUBLISHED,
                ];

                if ((int)$shortcode->collection_id) {
                    $condition['id'] = (int)$shortcode->collection_id;
                }

                $productKolhype = get_product_kolhype(
                    $condition,
                    [],
                    ['id', 'name', 'slug']
                );

                return Theme::partial('shortcodes.ecommerce.product-kolhype', [
                    'shortcode' => $shortcode,
                    'productKolhype' => ProductKolhypeResource::collection($productKolhype),
                ]);
            }
        );

        shortcode()->setAdminConfig('product-kolhype', function ($attributes) {
            $collections = get_product_kolhype(
                ['status' => BaseStatusEnum::PUBLISHED],
                [],
                ['id', 'name', 'slug']
            );

            return Theme::partial('shortcodes.ecommerce.product-kolhype-admin-config', compact('attributes', 'collections'));
        });

        // Product Kolhype End

        // Product Mami Clean Start

        add_shortcode(
            'product-mami-clean',
            __('Produk Mami Clean'),
            __('Produk Mami Clean'),
            function ($shortcode) {
                $condition = [
                    'status' => BaseStatusEnum::PUBLISHED,
                ];

                if ((int)$shortcode->collection_id) {
                    $condition['id'] = (int)$shortcode->collection_id;
                }

                $productMamiClean = get_product_mami_clean(
                    $condition,
                    [],
                    ['id', 'name', 'slug']
                );

                return Theme::partial('shortcodes.ecommerce.product-mami-clean', [
                    'shortcode' => $shortcode,
                    'productMamiClean' => ProductMamiCleanResource::collection($productMamiClean),
                ]);
            }
        );

        shortcode()->setAdminConfig('product-mami-clean', function ($attributes) {
            $collections = get_product_mami_clean(
                ['status' => BaseStatusEnum::PUBLISHED],
                [],
                ['id', 'name', 'slug']
            );

            return Theme::partial('shortcodes.ecommerce.product-mami-clean-admin-config', compact('attributes', 'collections'));
        });

        // Product Mami Clean

        // Product Razen Holiday Start

        add_shortcode(
            'product-razen-holiday',
            __('Produk Razen Holiday'),
            __('Produk Razen Holiday'),
            function ($shortcode) {
                $condition = [
                    'status' => BaseStatusEnum::PUBLISHED,
                ];

                if ((int)$shortcode->collection_id) {
                    $condition['id'] = (int)$shortcode->collection_id;
                }

                $productRazenHoliday = get_product_razen_holiday(
                    $condition,
                    [],
                    ['id', 'name', 'slug']
                );

                return Theme::partial('shortcodes.ecommerce.product-razen-holiday', [
                    'shortcode' => $shortcode,
                    'productRazenHoliday' => ProductRazenHolidayResource::collection($productRazenHoliday),
                ]);
            }
        );

        shortcode()->setAdminConfig('product-razen-holiday', function ($attributes) {
            $collections = get_product_razen_holiday(
                ['status' => BaseStatusEnum::PUBLISHED],
                [],
                ['id', 'name', 'slug']
            );

            return Theme::partial('shortcodes.ecommerce.product-razen-holiday-admin-config', compact('attributes', 'collections'));
        });

        // Product Razen Holiday End

        // Product Razen Skin Start

        add_shortcode(
            'product-razen-skin',
            __('Produk Razen Skin'),
            __('Produk Razen Skin'),
            function ($shortcode) {
                $condition = [
                    'status' => BaseStatusEnum::PUBLISHED,
                ];

                if ((int)$shortcode->collection_id) {
                    $condition['id'] = (int)$shortcode->collection_id;
                }

                $productRazenSkin = get_product_razen_skin(
                    $condition,
                    [],
                    ['id', 'name', 'slug']
                );

                return Theme::partial('shortcodes.ecommerce.product-razen-skin', [
                    'shortcode' => $shortcode,
                    'productRazenSkin' => ProductRazenSkinResource::collection($productRazenSkin),
                ]);
            }
        );

        shortcode()->setAdminConfig('product-razen-skin', function ($attributes) {
            $collections = get_product_razen_skin(
                ['status' => BaseStatusEnum::PUBLISHED],
                [],
                ['id', 'name', 'slug']
            );

            return Theme::partial('shortcodes.ecommerce.product-razen-skin-admin-config', compact('attributes', 'collections'));
        });

        // Product Razen Skin End

        add_shortcode(
            'product-category-products',
            __('Product category products'),
            __('Product category products'),
            function ($shortcode) {
                $category = app(ProductCategoryInterface::class)->getFirstBy([
                    'status' => BaseStatusEnum::PUBLISHED,
                    'id' => $shortcode->category_id,
                ], ['*'], [
                    'activeChildren' => function ($query) use ($shortcode) {
                        $query->limit($shortcode->number_of_categories ? (int)$shortcode->number_of_categories : 3);
                    },
                    'activeChildren.slugable',
                ]);

                if (! $category) {
                    return null;
                }

                $category = new ProductCategoryResource($category);
                $category->activeChildren = ProductCategoryResource::collection($category->activeChildren);

                return Theme::partial('shortcodes.ecommerce.product-category-products', compact('category', 'shortcode'));
            }
        );

        shortcode()->setAdminConfig('product-category-products', function ($attributes) {
            $categories = ProductCategoryHelper::getProductCategoriesWithIndent();

            return Theme::partial('shortcodes.ecommerce.product-category-products-admin-config', compact('attributes', 'categories'));
        });

        add_shortcode('featured-products', __('Featured products'), __('Featured products'), function ($shortcode) {
            return Theme::partial('shortcodes.ecommerce.featured-products', [
                'shortcode' => $shortcode,
            ]);
        });

        shortcode()->setAdminConfig('featured-products', function ($attributes) {
            return Theme::partial('shortcodes.ecommerce.featured-products-admin-config', compact('attributes'));
        });
    }

    if (is_plugin_active('blog')) {
        add_shortcode('featured-posts', __('Featured Blog Posts'), __('Featured Blog Posts'), function ($shortcode) {
            return Theme::partial('shortcodes.featured-posts', compact('shortcode'));
        });

        shortcode()->setAdminConfig('featured-posts', function ($attributes) {
            return Theme::partial('shortcodes.featured-posts-admin-config', compact('attributes'));
        });
    }

    if (is_plugin_active('contact')) {
        add_filter(CONTACT_FORM_TEMPLATE_VIEW, function () {
            return Theme::getThemeNamespace() . '::partials.shortcodes.contact-form';
        }, 120);
    }

    add_shortcode('contact-info-boxes', __('Contact info boxes'), __('Contact info boxes'), function ($shortcode) {
        return Theme::partial('shortcodes.contact-info-boxes', compact('shortcode'));
    });

    shortcode()->setAdminConfig('contact-info-boxes', function ($attributes) {
        return Theme::partial('shortcodes.contact-info-boxes-admin-config', compact('attributes'));
    });

    if (is_plugin_active('faq')) {
        add_shortcode('faq', __('FAQs'), __('FAQs'), function ($shortcode) {
            $categories = app(FaqCategoryInterface::class)
                ->advancedGet([
                    'condition' => [
                        'status' => BaseStatusEnum::PUBLISHED,
                    ],
                    'with' => [
                        'faqs' => function ($query) {
                            $query->where('status', BaseStatusEnum::PUBLISHED);
                        },
                    ],
                    'order_by' => [
                        'faq_categories.order' => 'ASC',
                        'faq_categories.created_at' => 'DESC',
                    ],
                ]);

            return Theme::partial('shortcodes.faq', [
                'title' => $shortcode->title,
                'categories' => $categories,
            ]);
        });

        shortcode()->setAdminConfig('faq', function ($attributes) {
            return Theme::partial('shortcodes.faq-admin-config', compact('attributes'));
        });
    }

    add_shortcode('coming-soon', __('Coming Soon'), __('Coming Soon'), function ($shortcode) {
        return Theme::partial('shortcodes.coming-soon', compact('shortcode'));
    });

    shortcode()->setAdminConfig('coming-soon', function ($attributes) {
        return Theme::partial('shortcodes.coming-soon-admin-config', compact('attributes'));
    });
});
