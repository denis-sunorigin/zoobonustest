<?php

use Models\Category;

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


    $category = new Category();
    $itemsList = $category->GetAll();

    render('', $itemsList, 'довідник категорій');

?>