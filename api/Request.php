<?php
    namespace api;

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
                default:
                    $result["message"] = 'Невідомий тип запиту, що підлягає валідації';
            }
            return $result;
        }
    }
?>