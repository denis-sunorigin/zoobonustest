<?php

use Models\Brand;
use Models\Category;
use Models\Product;

    require_once('helpers.php');

    function render($error = '', $brandList = array(), $categoriesList = array(), $productList = array()) {
        if (empty($error)) {
            include('templates/index.php');
        } else {
            ddlog($error);
            include('templates/500.php');
        }
        exit();
    }


    $brand = new Brand();
    $brandList = $brand->GetAll();
    $category = new Category();
    $categoriesList = $category->GetAll();
    $product = new Product();
    $productList = $product->GetAll();

    $error = '';
    //$error = print_r($productList, true);

    render($error, $brandList, $categoriesList, $productList);

    


?>