<?php

use Models\Category;
use Models\Product;

    require_once('helpers.php');

    function render($error = '', $categoriesList = array(), $productList = array(), $paramsString = '', $sorts = array()) {
        if (empty($error)) {
            include('templates/admincatalog.php');
        } else {
            ddlog($error);
            include('templates/500.php');
        }
        exit();
    }

    if ( ! (isAuthorized())) header("Location: 403.php");

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
    
    // Добре було б зробити якийсь об'єкт page або request (чи навіть обидва), і в ньому розміщувати подібні константи. А також методи на кшталт "parseGetParams".
    $sortVariants = array(
        ["order" => "id", "direction" => "asc", "reverse" => "desc"], ["order" => "name", "direction" => "asc", "reverse" => "desc"],
        ["order" => "value", "direction" => "asc", "reverse" => "desc"], ["order" => "price", "direction" => "asc", "reverse" => "desc"],
        ["order" => "statusname", "direction" => "asc", "reverse" => "desc"], ["order" => "statusid", "direction" => "asc", "reverse" => "desc"],
        ["order" => "categoryname", "direction" => "asc", "reverse" => "desc"], ["order" => "categoryid", "direction" => "asc", "reverse" => "desc"],
        ["order" => "brandname", "direction" => "asc", "reverse" => "desc"], ["order" => "brandid", "direction" => "asc", "reverse" => "desc"],
        ["order" => "code1c", "direction" => "asc", "reverse" => "desc"]
    );
    $sorts = array(); $orderField = 'id'; $orderDirection = 'asc';
    foreach($sortVariants as $sVariant) {
        $tmpItem = ["link" => $page."?sort=".$sVariant["order"], "active_forward" => false, "active_backward" => false];
        if ($sVariant["order"] == $params["sort"]) {
            $tmpItem["active_forward"] = true;
            $tmpItem["link"] = $page."?sort=".$sVariant["order"]."_reverse";
            $orderField = $sVariant["order"]; $orderDirection = $sVariant["direction"];
        } elseif (($sVariant["order"]."_reverse") == $params["sort"]) {
            $tmpItem["active_backward"] = true;
            $orderField = $sVariant["order"]; $orderDirection = $sVariant["reverse"];
        }
        if (filled($paramsButSort)) $tmpItem["link"] .= "&".$paramsButSort;
        $sorts[] = $tmpItem;
    }
        
    $productObj = new Product();
    $productList = $productObj->GetWithJoinNamesFromDict('categoryid', $params["category"], $orderField, $orderDirection);

    render($error, $categoriesList, $productList, $paramsString, $sorts);

?>