<?php

use Models\Brand;
use Models\Category;

    require_once('helpers.php');

    function render($error = '', $brandList = array(), $categoriesList = array()) {
        if (empty($error)) {
            include('templates/index.php');
        } else {
            ddlog($error);
            include('templates/500.php');
        }
        exit();
    }


    $brand = new Brand();
    $brandList = $brand->GetAll();
    $category = new Category();
    $categoriesList = $category->GetAll();

    render('', $brandList, $categoriesList);

    


?>