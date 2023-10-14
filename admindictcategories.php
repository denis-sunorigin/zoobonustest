<?php

use Models\Category;
use Models\Product;

    require_once('helpers.php');

    function render($error = '', $itemsList = array(), $dictName = '', $className = '') {
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
    $tmpArray = $categoryObj->GetAll();
    $itemsList = array();
    foreach ($tmpArray as $category) {
        $product = $productObj->GetFirstBySingleCondition("categoryid", $category["id"]);
        $category["deletable"] = ($product === false);
        $itemsList[] = $category;
    }

    render('', $itemsList, 'довідник категорій', 'Category');

?>