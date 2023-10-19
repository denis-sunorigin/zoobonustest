<?php

    use API\Request;
    use Models\Product;

    require_once('../helpers.php');

    if (DEBUGLOG) ddlog("звернення до endpoint'а productupdate");
    if ( ! (isAuthorized())) returnJSON(401, false, 'Не авторизований запит. Спробуйте оновити сторінку та/або виконати повторний вхід до системи.');
    
    $request = new Request;
    $validationResult = $request->Validate("productUpdate");
    if ($validationResult["success"]) {
        $productObj = new Product;
        if ($productObj) {
            if ($request->requestData["id"] > 0) {
                // Якщо id більше 0, то це оновлення (товар вже існує)
                // Треба написати новий метод в DBTables для оновлення одразу декількох полів. Але вже не бачу сенсу в цьому, лінь.
                // id, name, description, imagePath, brandId, categoryId, statusId, value, price, code1C
                $updateResult = (string)$productObj->UpdateProperty("name", $request->requestData["name"], "id", $request->requestData["id"]);
                $updateResult .= $productObj->UpdateProperty("description", $request->requestData["description"], "id", $request->requestData["id"]);
                $updateResult .= $productObj->UpdateProperty("image", $request->requestData["imagePath"], "id", $request->requestData["id"]);
                $updateResult .= $productObj->UpdateProperty("brandid", $request->requestData["brandId"], "id", $request->requestData["id"]);
                $updateResult .= $productObj->UpdateProperty("categoryid", $request->requestData["categoryId"], "id", $request->requestData["id"]);
                $updateResult .= $productObj->UpdateProperty("statusid", $request->requestData["statusId"], "id", $request->requestData["id"]);
                $updateResult .= $productObj->UpdateProperty("value", $request->requestData["value"], "id", $request->requestData["id"]);
                $updateResult .= $productObj->UpdateProperty("price", $request->requestData["price"], "id", $request->requestData["id"]);
                $updateResult .= $productObj->UpdateProperty("code1c", $request->requestData["code1C"], "id", $request->requestData["id"]);
                if ($updateResult) {
                    returnJSON(200, true, 'Оновлені поля: '.$updateResult, ["id" => $request->requestData["id"]]);
                } else {
                    returnJSON(500, false, 'Помилка під час оновлення картки товару. Дивиться лог для додаткової інформації.');
                }
            } else {
                // Якщо id дорівнює 0, то це створення нового товару
                $insertResult = $productObj->InsertElement("name, description, image, brandid, categoryid, statusid, value, price, code1c", "'".$request->requestData["name"]."', '".$request->requestData["description"]."', '".$request->requestData["imagePath"]."', '".$request->requestData["brandId"]."', '".$request->requestData["categoryId"]."', '".$request->requestData["statusId"]."', '".$request->requestData["value"]."', '".$request->requestData["price"]."', '".$request->requestData["code1C"]."'");
                if ($insertResult) {
                    returnJSON(200, true, 'Запис створено.', ["id" => $insertResult]);
                } else {
                    returnJSON(500, false, 'Помилка під час створення елементу.');
                }
            }
        } else {
            returnJSON(500, false, 'Не вийшло створити обʼєкт класу Product.');
        }
    } else {
        returnJSON(400, false, 'Невірний формат запиту. '.$validationResult["message"]);    
    }

?>