<?php

use Models\Brand;
use Models\Category;
use Models\Product;

    require_once('helpers.php');

    function render($error = '', $brandList = array(), $categoriesList = array(), $productList = array(), $paramsString = '', $sortOptions = array(), $selectedCategoryName = '', $selectedBrandsName = '') {
        if (empty($error)) {
            include('templates/index.php');
        } else {
            ddlog($error);
            include('templates/500.php');
        }
        exit();
    }

    $error = '';
    $params = parseGetParams();
    $paramsString = paramsToURIString($params);
    $paramsButCategory = paramsToURIString($params, false, false, true, true);
    $paramsButSort = paramsToURIString($params, false, true, false, true);

    $brandObj = new Brand();
    $brandList = $brandObj->GetAll();
    if ($brandList === false) header("Location: dbdiag.php");

    $tmpBrands = array();
    foreach($brandList as $brand) {
        // Розставляємо обрані бренди в масив одразу, щоб не робити це у view. А також підготовлюємо посилання.
        $brand["selected"] = filled($params["brand"]) ? in_array($brand["id"],$params["brand"]) : false;
        // Якщо в параметрах запиту є бренди, то атрибут "обраний" цього конкретно бренду визначається, виходячи з того, чи є він в параметрах. Якщо ж в параметрах не було жодних брендів, то автоматично false
        // Далі навпаки. Якщо саме цей бренд був в параметрах, то посилання, яке прив'язується до кліку по ньому має містити всі інші зазначені бренди, але не цей. А якщо в параметрах брендів не було (або були, але не цей), просто у посилання додається цей бренд
        $paramsCopy = $params;
        if (in_array($brand["id"],$paramsCopy["brand"])) {
            $paramsCopy["brand"] = array_diff($paramsCopy["brand"],array($brand["id"])); // Якщо строка параметрів містить поточний елмент, прибираємо його перед тим як готувати посилання
        } else {
            $paramsCopy["brand"][] = $brand["id"]; // Якщо НЕ містить - додаємо.
        }
        $tmpParamString = paramsToURIString($paramsCopy);
        $brand["link"] = empty($tmpParamString) ? "index.php" : "index.php?".$tmpParamString;
        if ($brand["id"] != 1) $tmpBrands[] = $brand; // Виробник "ХЗ" в фільтр не додаємо
    }
    $brandList = $tmpBrands;
    $selectedBrandsName = '';
    foreach ($brandList as $brand) if ($brand["selected"]) $selectedBrandsName .= '"'.$brand["name"].'", ';
    if ($selectedBrandsName != '') {
        $selectedBrandsName = 'брендів '.substr($selectedBrandsName, 0, -2);
    } else {
        $selectedBrandsName = 'всіх брендів';
    }

    $categoryObj = new Category();
    $categoriesList = $categoryObj->GetAll();
    $tmpCategories = array();
    $firstCategoryAll = array("id" => "0", "name" => "Всі", "description" => "Показати товари з усіх категорій", "selected" => false, "link" => "index.php");
    if (empty($params["category"]) || ($params["category"] == "0")) $firstCategoryAll["selected"] = true;
    if (filled($paramsButCategory)) $firstCategoryAll["link"] .= '?'.$paramsButCategory;
    $tmpCategories[] = $firstCategoryAll;
    foreach($categoriesList as $category) {
        $category["selected"] = ($category["id"] == $params["category"]);
        $category["link"] = empty($paramsButCategory) ? "index.php?category=".$category["id"] : "index.php?category=".$category["id"].'&'.$paramsButCategory;
        if ($category["id"] != 1) {
            $tmpCategories[] = $category;
        } else {
            $lastCategoryOther = $category; // Краще виглядає, коли вона в кінці
        }
    }
    $tmpCategories[] = $lastCategoryOther;
    $categoriesList = $tmpCategories;
    $selectedCategoryName = '';
    foreach ($categoriesList as $category) if ($category["selected"]) $selectedCategoryName = $category["name"];

    $sortOptions = array(
        array("name" => "Зростання ціни", "selected" => (($params["sort"] == "price") || empty($params["sort"])), "link" => empty($paramsButSort) ? "index.php" : "index.php?".$paramsButSort),
        array("name" => "Зменшення ціни", "selected" => ($params["sort"] == "price_reverse"), "link" => empty($paramsButSort) ? "index.php?sort=price_reverse" : "index.php?sort=price_reverse&".$paramsButSort),
        array("name" => "Назва", "selected" => ($params["sort"] == "name"), "link" => empty($paramsButSort) ? "index.php?sort=name" : "index.php?sort=name&".$paramsButSort)
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
        // В реальному робочому використанні так краще не робити. Для великої бази треба зробити окремий метод відбіру товарів з усіма фільтрами одразу. А ще краще в реальних умовах зробити так і інакше, і порівняти швидкість.
        $productList = $tmpProducts;
    }

    //$error = '<pre>'.print_r($categoriesList, true).'</pre>';

    render($error, $brandList, $categoriesList, $productList, $paramsString, $sortOptions, $selectedCategoryName, $selectedBrandsName);

    


?>