<?php

use Models\Category;
use Models\Product;

    require_once('helpers.php');

    function render($error = '', $itemsList = array(), $dictName = '', $className = '', $maxId = 0) {
        if (empty($error)) {
            include('templates/admindict.php');
        } else {
            ddlog($error);
            include('templates/500.php');
        }
        exit();
    }

    if ( ! (isAuthorized())) header("Location: 403.php");

    $productObj = new Product();
    $categoryObj = new Category();
    $tmpArray = $categoryObj->GetAll('name', 'asc');
    $itemsList = array(); $maxId = 0;
    foreach ($tmpArray as $category) {
        $product = $productObj->GetFirstBySingleCondition("categoryid", $category["id"]);
        $category["deletable"] = ($product === false);
        $itemsList[] = $category;
        if ($category["id"] > $maxId) $maxId = $category["id"];
    }

    render('', $itemsList, 'довідник категорій', 'Category', $maxId);

?>