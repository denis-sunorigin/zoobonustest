<?php
    namespace API;

    class Request {
        public $requestData;
        public function __construct()
        {
            if (isset($_SERVER)) {
                if (DEBUGLOG) ddlog(__METHOD__.': $_SERVER is set');
                if (array_key_exists("CONTENT_TYPE", $_SERVER)) {
                    if (DEBUGLOG) ddlog(__METHOD__.': CONTENT_TYPE key exists');
                    if (filled($_SERVER['CONTENT_TYPE'])) {
                        if (DEBUGLOG) ddlog(__METHOD__.': CONTENT_TYPE is filled');
                        if ($_SERVER['CONTENT_TYPE'] == 'application/json') {
                            if (DEBUGLOG) ddlog(__METHOD__.': CONTENT_TYPE is "application/json"');
                            $requestData = json_decode(file_get_contents('php://input'), true);
                            if (!$requestData) ddlog("Вхідні дані запиту не вдалося розпарсити як JSON, хоча тип контента зазначено саме такий.");
                        } else {
                            if (DEBUGLOG) ddlog(__METHOD__.': CONTENT_TYPE is "'.$_SERVER['CONTENT_TYPE'].'"');
                            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                                if (DEBUGLOG) ddlog(__METHOD__.': REQUEST_METHOD is POST');
                                $requestData = $_POST;
                            } elseif ($_SERVER['REQUEST_METHOD'] == 'GET') {
                                if (DEBUGLOG) ddlog(__METHOD__.': REQUEST_METHOD is GET');
                                $requestData = $_GET;
                            } else {
                                if (DEBUGLOG) ddlog(__METHOD__.': REQUEST_METHOD is "'.$_SERVER['REQUEST_METHOD'].'"');
                            }
                        }
                    }
                }
            }
            if (empty($requestData)) {
                if (DEBUGLOG) ddlog(__METHOD__.': дані запиту пусті.');
            } else {
                if (DEBUGLOG) ddlog(__METHOD__.':'.PHP_EOL.'Дані запиту:'.PHP_EOL.print_r($requestData,true));
            }
            $this->requestData = $requestData ?? array();
        }

        public function Validate(string $typeOfRequest) {
            $result = ["success" => false, "message" => ""];
            $rd = $this->requestData;
            switch ($typeOfRequest) {
                case "dictElemDelete":
                    $dictElemId = (array_key_exists("dictElemId", $rd)) ? (int)$rd["dictElemId"] : -1;
                    $className = (array_key_exists("className", $rd)) ? (string)$rd["className"] : '';
                    if ($dictElemId < 0) { $result["message"] = 'Не зазначено обовʼязковий параметр dictElemId'; return $result; }
                    if ($className == '') { $result["message"] = 'Не зазначено обовʼязковий параметр className'; return $result; }
                    if ( ! (in_array($className, ['Brand', 'Category', 'ProductStatus'])) ) {
                        $result["message"] = "Параметр className має неприпустиме значення";
                    } else {
                        $result["success"] = true;
                    }
                    break;
                case "dictElemUpdate":
                    $dictElemId = (array_key_exists("dictElemId", $rd)) ? (int)$rd["dictElemId"] : -1;
                    $className = (array_key_exists("className", $rd)) ? (string)$rd["className"] : '';
                    $nameValue = (array_key_exists("nameValue", $rd)) ? htmlspecialchars($rd["nameValue"]) : '';
                    $rd["nameValue"] = $nameValue;
                    $descriptionValue = (array_key_exists("descriptionValue", $rd)) ? htmlspecialchars($rd["descriptionValue"]) : '';
                    $rd["descriptionValue"] = $descriptionValue;
                    if ($dictElemId < 0) { $result["message"] = 'Не зазначено обовʼязковий параметр dictElemId'; return $result; }
                    if ($className == '') { $result["message"] = 'Не зазначено обовʼязковий параметр className'; return $result; }
                    if ($nameValue == '') { $result["message"] = 'Не зазначено обовʼязковий параметр nameValue'; return $result; }
                    $result["success"] = true;
                    break;
                case "productDelete":
                    $productId = (array_key_exists("productId", $rd)) ? (int)$rd["productId"] : -1;
                    if ($productId < 0) { $result["message"] = 'Не зазначено обовʼязковий параметр productId'; return $result; }
                    $result["success"] = true;
                    break;
                case "productUpdate":
                    // id, name, description, imagePath, brandId, categoryId, statusId, value, price, code1C
                    // Звісно, краще зробити універсальний валідатор для масштабованої системи. Особисто я б в моделі зазначив тип полів, а також які саме з них обов'язкові (NOT NULL).
                    // Потім бажано зробити окремий метод валідації, який візьме цей перелік з моделі і зіставить з отриманими параметрами.
                    // Тоді цю поточну спагетті-функцію можна вилучити, і зробити валідацію в контролері одним рядком. Буде навіть зручніше, ніж в Laravel.
                    // На кшталт, $product = new Product(); $request = new Request(); if ($product->isValidForWrite($request->params)) ...
                    // Але не зараз :)
                    $id = (array_key_exists("id", $rd)) ? (int)$rd["id"] : -1;
                    $name = (array_key_exists("name", $rd)) ? htmlspecialchars($rd["name"]) : '';
                    $rd["name"] = $name;
                    $description = (array_key_exists("description", $rd)) ? htmlspecialchars($rd["description"]) : '';
                    $rd["description"] = $description;
                    $imagePath = (array_key_exists("imagePath", $rd)) ? htmlspecialchars($rd["imagePath"]) : '';
                    $rd["imagePath"] = $imagePath;
                    $brandId = (array_key_exists("brandId", $rd)) ? (int)$rd["brandId"] : -1;
                    $categoryId = (array_key_exists("categoryId", $rd)) ? (int)$rd["categoryId"] : -1;
                    $statusId = (array_key_exists("statusId", $rd)) ? (int)$rd["statusId"] : -1;
                    $value = (array_key_exists("value", $rd)) ? (int)$rd["value"] : 0;
                    $price = (array_key_exists("price", $rd)) ? (int)$rd["price"] : 0;
                    $code1C = (array_key_exists("code1C", $rd)) ? htmlspecialchars($rd["code1C"]) : '';
                    $rd["code1C"] = $code1C;
                    if ($id < 0) { $result["message"] = 'Не зазначено обовʼязковий параметр id продукта'; return $result; }
                    if ($brandId < 0) { $result["message"] = 'Не зазначено обовʼязковий параметр id торгової марки'; return $result; }
                    if ($categoryId < 0) { $result["message"] = 'Не зазначено обовʼязковий параметр id категорії продукта'; return $result; }
                    if ($statusId < 0) { $result["message"] = 'Не зазначено обовʼязковий параметр id статуса товара'; return $result; }
                    if ($name == '') { $result["message"] = 'Не зазначено обовʼязковий параметр name'; return $result; }
                    $result["success"] = true;
                    break;
                default:
                    $result["message"] = 'Невідомий тип запиту, що підлягає валідації';
            }
            return $result;
        }
    }
?>