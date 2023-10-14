<?php

    use API\Request;

    require_once('../helpers.php');

    if (DEBUGLOG) ddlog("звернення до endpoint'а dictelemdelete");
    if ( ! (isAuthorized())) returnJSON(401, false, 'Не авторизований запит. Спробуйте оновити сторінку та/або виконати повторний вхід до системи.');
    
    $request = new Request;
    $validationResult = $request->Validate("dictElemDelete");
    if ($validationResult["success"]) {
        // Якщо ми опинилися в цьому місці, то це означає, що валідація запиту пройшла вдало, і він 100%-во містить параметри className і dictElemId, і вони не пусті.
        $className = 'Models\\'.$request->requestData["className"];
        $modelObj = new $className;
        if ($modelObj) {
            $deleteResult = $modelObj->DeleteById($request->requestData["dictElemId"]);
            if ($deleteResult) {
                returnJSON(200, true, 'Видалено рядків: '.$deleteResult);
            } else {
                returnJSON(500, false, 'Помилка під час видалення елементу. Можливо, він використовується.');
            }
        } else {
            returnJSON(500, false, 'Не вийшло створити обʼєкт класу '.$className);
            // Можна тут додати перевірку, в якому середовищі виконується додаток. І якщо це production, то детальну інформацію не відображати.
        }
    } else {
        returnJSON(400, false, 'Невірний формат запиту. '.$validationResult["message"]);    
    }

?>