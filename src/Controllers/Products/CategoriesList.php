<?php

/**
 * @package mvc202401
 * @subpackage Controllers\Products
 */

namespace Controllers\Products;

use Controllers\PrivateController;
use Dao\Productos\Categories as CategoriesDao;
use Views\Renderer;

/**
 * Lista del Patron WW para mostrar las categorias de productos
 */
class CategoriesList extends PrivateController
{
    public function run(): void
    {
        $viewData = [];
        $viewData["categories"] = CategoriesDao::getAllCategories();
        $viewData["categories_new_enabled"] = $this->isFeatureAutorized("categories_new_enabled");
        $viewData["categories_edit_enabled"] = $this->isFeatureAutorized("categories_edit_enabled");
        $viewData["categories_delete_enabled"] = $this->isFeatureAutorized("categories_delete_enabled");
        $viewData["categories_view_enabled"] = $this->isFeatureAutorized("categories_view_enabled");
        Renderer::render("productos/categorieslist", $viewData);
    }
}
