<?php

namespace Botble\Ecommerce\Repositories\Interfaces;

use Botble\Support\Repositories\Interfaces\RepositoryInterface;

interface ProductRazenStudioInterface extends RepositoryInterface
{
    /**
     * @param string $name
     * @param int $id
     * @return mixed
     */
    public function createSlug($name, $id);
}
