<?php

namespace Botble\Ecommerce\Repositories\Interfaces;

use Botble\Ecommerce\Models\Product;
use Botble\Support\Repositories\Interfaces\RepositoryInterface;

interface ProductInterface extends RepositoryInterface
{
    /**
     * @deprecated
     */
    public function getSearch($query, $paginate = 10);

    public function getRelatedProductAttributes($product);

    public function getProducts(array $params);

    public function getProductsWithCategory(array $params);

    public function getOnSaleProducts(array $params);

    public function getProductVariations($configurableProductId, array $params = []);

    public function getProductsByCollections(array $params);

    public function getProductsByRazenStudio(array $params);

    public function getProductsByRazenTeknologi(array $params);

    public function getProductsByRazenProject(array $params);

    public function getProductsByRazenInstitute(array $params);

    public function getProductsByRazenFarm(array $params);

    public function getProductsByRazenCloth(array $params);

    public function getProductsByKolhype(array $params);

    public function getProductsByMamiClean(array $params);

    public function getProductsByRazenHoliday(array $params);

    public function getProductsByRazenSkin(array $params);

    public function getProductByBrands(array $params);

    public function getProductByTags(array $params);

    public function getProductsByCategories(array $params);

    public function filterProducts(array $filters, array $params = []);

    public function getProductsByIds(array $ids, array $params = []);

    public function getProductsWishlist(int $customerId, array $params = []);

    public function getProductsRecentlyViewed(int $customerId, array $params = []);

    public function saveProductOptions(array $options, Product $product);

    public function productsNeedToReviewByCustomer(int $customerId, int $limit = 12, array $orderIds = []);
}
