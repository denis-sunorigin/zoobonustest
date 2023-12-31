<?php

use Models\Brand;
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
    $brandObj = new Brand();
    $tmpArray = $brandObj->GetAll('name', 'asc');
    $itemsList = array(); $maxId = 0;
    foreach ($tmpArray as $brand) {
        $product = $productObj->GetFirstBySingleCondition("brandid", $brand["id"]);
        $brand["deletable"] = ($product === false);
        $itemsList[] = $brand;
        if ($brand["id"] > $maxId) $maxId = $brand["id"];
    }

    render('', $itemsList, 'довідник брендів', 'Brand', $maxId);

?>