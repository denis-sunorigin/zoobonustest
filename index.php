<?php
    use Models\ProductList;

    require_once('settings.php');
    require_once('helpers.php');

    function render($error = '') {
        if (!empty($error)) ddlog($error);
        include('templates/index.php');
        exit();
    }

    render('айайай');

 //   $ProductList = new ProductList();


?>