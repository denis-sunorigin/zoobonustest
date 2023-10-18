<?php

    use API\Request;
    use Models\Product;

    require_once('../helpers.php');

    if (DEBUGLOG) ddlog("звернення до endpoint'а productdelete");
    if ( ! (isAuthorized())) returnJSON(401, false, 'Не авторизований запит. Спробуйте оновити сторінку та/або виконати повторний вхід до системи.');
    
    $request = new Request;
    $validationResult = $request->Validate("productDelete");
    if ($validationResult["success"]) {
        $productObj = new Product;
        if ($productObj) {
            $deleteResult = $productObj->DeleteById($request->requestData["productId"]);
            if ($deleteResult) {
                returnJSON(200, true, 'Видалено рядків: '.$deleteResult);
            } else {
                returnJSON(500, false, 'Помилка під час видалення елементу. Дивиться лог для додаткової інформації.');
            }
        } else {
            returnJSON(500, false, 'Не вийшло створити обʼєкт класу Product.');
        }
    } else {
        returnJSON(400, false, 'Невірний формат запиту. '.$validationResult["message"]);    
    }

?>