<?php

    use API\Request;
    use Models\Product;

    require_once('../helpers.php');

    if (DEBUGLOG) ddlog("звернення до endpoint'а fileupload");
    if ( ! (isAuthorized())) returnJSON(401, false, 'Не авторизований запит. Спробуйте оновити сторінку та/або виконати повторний вхід до системи.');
    
    $request = new Request;
    $productId = (string)$request->requestData["productId"] ?? '';
    if (DEBUGLOG) ddlog("productId: ".$productId);

    $fileName = 'product_cover_id'.$productId.'_'.time().'_'.$_FILES['file']['name'];
    if (DEBUGLOG) ddlog("fileName: ".$fileName);

    $filePath = PATHFORUSERIMAGES.$fileName;
    if (DEBUGLOG) ddlog("filePath (for html insert): ".$filePath);

    $pathForMoveFile = is_dir(PATHFORUSERIMAGES) ? $filePath : '../'.$filePath; // Сумісність з Windows, в якому немає можливості зазначити абсолютні шляхи до каталогів.
    if (DEBUGLOG) ddlog("pathForMoveFile (directory on server for file copy): ".$pathForMoveFile);

    if (move_uploaded_file($_FILES['file']['tmp_name'], $pathForMoveFile)) {
        if (DEBUGLOG) ddlog("Отриманий файл було перенесено до каталога ".PATHFORUSERIMAGES);
        returnJSON(200, true, 'Файл завантажено.', ["filePath" => $filePath, "fileName" => $fileName]);
    } else {
        if (DEBUGLOG) ddlog("Не вийшло перенести файл до каталога ".PATHFORUSERIMAGES);
        returnJSON(500, false, 'Помилка під час завантаження файла.');
    }

?>