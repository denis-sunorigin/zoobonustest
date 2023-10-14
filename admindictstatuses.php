<?php

use Models\Product;
use Models\ProductStatus;

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
    $productStatusObj = new ProductStatus();
    $tmpArray = $productStatusObj->GetAll();
    $itemsList = array();
    foreach ($tmpArray as $productStatus) {
        $product = $productObj->GetFirstBySingleCondition("statusid", $productStatus["id"]);
        $productStatus["deletable"] = ($product === false);
        $itemsList[] = $productStatus;
    }

    render('', $itemsList, 'довідник статусів', 'ProductStatus');

?>