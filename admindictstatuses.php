<?php

use Models\ProductStatus;

    require_once('helpers.php');

    function render($error = '', $itemsList = array(), $dictName = '') {
        if (empty($error)) {
            include('templates/admindict.php');
        } else {
            ddlog($error);
            include('templates/500.php');
        }
        exit();
    }


    $productStatus = new ProductStatus();
    $itemsList = $productStatus->GetAll();

    render('', $itemsList, 'довідник статусів');

?>