<?php

use Models\Brand;

    require_once('helpers.php');

    function render($error = '', $brandList = array()) {
        if (empty($error)) {
            include('templates/admindict.php');
        } else {
            ddlog($error);
            include('templates/500.php');
        }
        exit();
    }


    $brand = new Brand();
    $brandList = $brand->GetAll();

    render('', $brandList);

?>