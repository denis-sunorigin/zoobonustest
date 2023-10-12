<?php

use Models\Brand;
use Models\Category;
use Models\Product;
use Models\ProductStatus;

    require_once('helpers.php');

    function render($error = '', $product = array(), $paramsString = '', $brandList = array(), $categoryList = array(), $statusList = array()) {
        if (empty($error)) {
            include('templates/adminproduct.php');
        } else {
            ddlog($error);
            include('templates/500.php');
        }
        exit();
    }

    if ( ! (isAuthorized())) header("Location: 403.php");

    $params = parseGetParams();

    $paramsString = paramsToURIString($params);

    $productObj = new Product();
    $product = $productObj->GetById($params["id"]);

    $brandObj = new Brand();
    $tmpBrands = $brandObj->GetAll();
    $brandList = array();
    foreach ($tmpBrands as $brand) {
        $brand["selected"] = empty($product) ? false : ($product["brandid"] == $brand["id"]);
        $brandList[] = $brand;
    }

    $categoryObj = new Category();
    $tmpCategories = $categoryObj->GetAll();
    $categoryList = array();
    foreach ($tmpCategories as $category) {
        $category["selected"] = empty($product) ? false : ($product["categoryid"] == $category["id"]);
        $categoryList[] = $category;
    }

    $statusObj = new ProductStatus();
    $tmpStatuses = $statusObj->GetAll();
    $statusList = array();
    foreach ($tmpStatuses as $status) {
        $status["selected"] = empty($product) ? false : ($product["statusid"] == $status["id"]);
        $statusList[] = $status;
    }

    $error = '';

    render($error, $product, $paramsString, $brandList, $categoryList, $statusList);

?>