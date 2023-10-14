<?php

    use API\Request;

    require_once('../helpers.php');

    if (DEBUGLOG) ddlog("звернення до endpoint'а dictelemupdate");
    if ( ! (isAuthorized())) returnJSON(401, false, 'Не авторизований запит. Спробуйте оновити сторінку та/або виконати повторний вхід до системи.');
    
    $request = new Request;
    $validationResult = $request->Validate("dictElemUpdate");
    if ($validationResult["success"]) {
        // Якщо ми опинилися в цьому місці, то це означає, що валідація запиту пройшла вдало, і він 100%-во містить параметри className, dictElemId, nameValue, descriptionValue,
        // і всі обов'язкові параметри (всі крім descriptionValue) - не пусті.
        $className = 'Models\\'.$request->requestData["className"];
        $modelObj = new $className;
        if ($modelObj) {
            $updateNameResult = $modelObj->UpdateProperty('name', $request->requestData["nameValue"], 'id', $request->requestData["dictElemId"]);
            $updateDescriptionResult = $modelObj->UpdateProperty('description', $request->requestData["descriptionValue"], 'id', $request->requestData["dictElemId"]);
            if ($updateNameResult || $updateDescriptionResult) {
                returnJSON(200, true, 'Запис оновлено. ('.$updateNameResult.'+'.$updateDescriptionResult.')');
            } else {
                returnJSON(500, false, 'Помилка під час оновлення елементу.');
            }
        } else {
            returnJSON(500, false, 'Не вийшло створити обʼєкт класу '.$className);
            // Можна тут додати перевірку, в якому середовищі виконується додаток. І якщо це production, то детальну інформацію не відображати.
        }
    } else {
        returnJSON(400, false, 'Невірний формат запиту. '.$validationResult["message"]);    
    }

?>