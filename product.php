<?php

use Models\Product;

    require_once('helpers.php');

    function render($error = '', $product = array()) {
        if (empty($error)) {
            include('templates/product.php');
        } else {
            ddlog($error);
            include('templates/500.php');
        }
        exit();
    }

    

    $params = parseGetParams();

    $productObj = new Product();
    $product = $productObj->GetById(2);

    $error = '';
    $error = print_r($params, true);

    render($error, $product);

?>