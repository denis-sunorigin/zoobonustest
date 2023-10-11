<?php

use Models\Brand;
use Models\Category;
use Models\Product;

    require_once('helpers.php');

    function render($error = '', $product = array(), $relevantProducts = array(), $category = array(), $brand = array(), $paramsString = '') {
        if (empty($error)) {
            include('templates/product.php');
        } else {
            ddlog($error);
            include('templates/500.php');
        }
        exit();
    }

    $params = parseGetParams();
    // За потреби тут можна обробити коректність параметрів і вивести на сторінку текст помилки.

    $paramsString = paramsToURIString($params);

    $productObj = new Product();
    $product = $productObj->GetById($params["id"]);

    $relevantProducts = (empty($params["category"])) ? false : $productObj->GetListBySingleCondition('categoryid', $params["category"]);
    if ($relevantProducts) {
        // Виключає з "рекомендованих товарів" той самий, сторінку якого відкрито. Якесь некрасиве рішення, елегантного не знайшов. array_diff наче підходить.
        $tmpArray = array();
        foreach ($relevantProducts as $relevantProduct) if ($relevantProduct["id"] != $params["id"]) $tmpArray[] = $relevantProduct;
        $relevantProducts = $tmpArray;
    }

    if (filled($params["category"])) {
        $categoryObj = new Category();
        $category = $categoryObj->GetById($params["category"]);
    } else {
        $category = false;
    }

    if ($product && filled($product["brandid"])) {
        $brandObj = new Brand();
        $brand = $brandObj->GetById($product["brandid"]);
    } else {
        $brand = false;
    }

    $error = '';
    //$error = print_r($params, true);

    render($error, $product, $relevantProducts, $category, $brand, $paramsString);

?>