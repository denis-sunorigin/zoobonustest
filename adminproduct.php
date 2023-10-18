<?php

use Models\Brand;
use Models\Category;
use Models\Product;
use Models\ProductStatus;

    require_once('helpers.php');

    function render($error = '', $product = array(), $paramsString = '', $brandList = array(), $categoryList = array(), $statusList = array(), $selectedBrandId = 0, $selectedCategoryId = 0, $selectedStatusId = 0) {
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
    $product = ($params["id"] > 0) ? $productObj->GetById($params["id"]) : array();

    $brandObj = new Brand();
    $tmpBrands = $brandObj->GetAll();
    $brandList = array();
    $selectedBrandId = 0;
    foreach ($tmpBrands as $brand) {
        $brand["selected"] = empty($product) ? false : ($product["brandid"] == $brand["id"]);
        $brandList[] = $brand;
        if ($brand["selected"]) $selectedBrandId = $brand["id"];
    }

    $categoryObj = new Category();
    $tmpCategories = $categoryObj->GetAll();
    $categoryList = array();
    $selectedCategoryId = 0;
    foreach ($tmpCategories as $category) {
        $category["selected"] = empty($product) ? false : ($product["categoryid"] == $category["id"]);
        $categoryList[] = $category;
        if ($category["selected"]) $selectedCategoryId = $category["id"];
    }

    $statusObj = new ProductStatus();
    $tmpStatuses = $statusObj->GetAll();
    $statusList = array();
    $selectedStatusId = 0;
    foreach ($tmpStatuses as $status) {
        $status["selected"] = empty($product) ? false : ($product["statusid"] == $status["id"]);
        $statusList[] = $status;
        if ($status["selected"]) $selectedStatusId = $status["id"];
    }

    $error = '';

    render($error, $product, $paramsString, $brandList, $categoryList, $statusList, $selectedBrandId, $selectedCategoryId, $selectedStatusId);

?>