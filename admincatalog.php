<?php

use Models\Category;
use Models\Product;

    require_once('helpers.php');

    function render($error = '', $categoriesList = array(), $productList = array(), $paramsString = '', $sortOptions = array()) {
        if (empty($error)) {
            include('templates/admincatalog.php');
        } else {
            ddlog($error);
            include('templates/500.php');
        }
        exit();
    }

    $page = "admincatalog.php";
    $error = '';
    $params = parseGetParams();
    $paramsString = paramsToURIString($params);
    $paramsButCategory = paramsToURIString($params, false, false, true, true);
    $paramsButSort = paramsToURIString($params, false, true, false, true);

    $categoryObj = new Category();
    $categoriesList = $categoryObj->GetAll();
    $tmpCategories = array();
    $firstCategoryAll = array("id" => "0", "name" => "Всі", "description" => "Показати товари з усіх категорій", "selected" => false, "link" => $page);
    if (empty($params["category"]) || ($params["category"] == "0")) $firstCategoryAll["selected"] = true;
    if (filled($paramsButCategory)) $firstCategoryAll["link"] .= '?'.$paramsButCategory;
    $tmpCategories[] = $firstCategoryAll;
    foreach($categoriesList as $category) {
        $category["selected"] = ($category["id"] == $params["category"]);
        $category["link"] = empty($paramsButCategory) ? $page."?category=".$category["id"] : $page."?category=".$category["id"].'&'.$paramsButCategory;
        if ($category["id"] != 1) {
            $tmpCategories[] = $category;
        } else {
            $lastCategoryOther = $category;
        }
    }
    $tmpCategories[] = $lastCategoryOther;
    $categoriesList = $tmpCategories;

    $sortOptions = array(
        array("name" => "Зростання ціни", "selected" => (($params["sort"] == "price") || empty($params["sort"])), "link" => empty($paramsButSort) ? $page : $page."?".$paramsButSort),
        array("name" => "Зменшення ціни", "selected" => ($params["sort"] == "price_reverse"), "link" => empty($paramsButSort) ? $page."?sort=price_reverse" : $page."?sort=price_reverse&".$paramsButSort),
        array("name" => "Назва", "selected" => ($params["sort"] == "name"), "link" => empty($paramsButSort) ? $page."?sort=name" : $page."?sort=name&".$paramsButSort)
    );
    $orderField = 'price'; $orderDirection = 'asc';
    switch ($params["sort"]) {
        case "price_reverse":
            $orderField = 'price'; $orderDirection = 'desc';
            break;
        case "name":
            $orderField = 'name'; $orderDirection = 'asc';
            break;
    }

    $productObj = new Product();
    if (empty($params["category"])) {
        $productList = $productObj->GetAll($orderField, $orderDirection);
    } else {
        $productList = $productObj->GetListBySingleCondition('categoryid', $params["category"], $orderField, $orderDirection);
    }
    if (filled($params["brand"])) {       
        $tmpProducts = array();
        foreach ($productList as $product) if (in_array($product["brandid"],$params["brand"])) $tmpProducts[] = $product;
        $productList = $tmpProducts;
    }

    render($error, $categoriesList, $productList, $paramsString, $sortOptions);

?>