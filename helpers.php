<?php
    require_once('settings.php');

    function sendToTelega($message) {
        // Відправка в телеграм повідомлень про будь-які форс-мажори чи важливі події
        if (!empty(MAXTELEGAMESSAGELENGTH)) {
            $msglen = strlen($message);
            if ($msglen>MAXTELEGAMESSAGELENGTH) {
                $message = substr($message,0,MAXTELEGAMESSAGELENGTH)."...".PHP_EOL."Показано ".MAXTELEGAMESSAGELENGTH." з ".$msglen." символів тексту помилки, див. лог.";
            }
        }
        $txt = urlencode($message);
        if (strlen($txt)>1800) $txt = substr($txt,0,1800); // Про всяк випадок
        $curl_handle=curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, 'https://api.telegram.org/bot'.TELEGATOKEN.'/sendMessage?chat_id='.TELEGACHATID.'&text='.$txt);
        curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
        $query = curl_exec($curl_handle);
        curl_close($curl_handle);
    }

    function ddlog($message, $isImportantError = false) {
        // Логуваня в файл на сервері
        error_log(date('Y-m-d H:i:s ').$message.PHP_EOL, 3, LOGFILE);
        if ($isImportantError) sendToTelega('На сайті виникла важлива помилка, що потребує уваги. '.PHP_EOL.$message);
    }

    function filled($anyValue): bool {
        // Для швидкої перевірки наявності значення, бо функція isset працює інакше, а !empty погано сприймається, особливо всередині html.
        return empty($anyValue) ? false : !($anyValue === false);
    }

    function parseGetParams() {
        // Приведення потрібних параметрів GET-запиту до коректного формату і відкидання зайвої решти
        $result = array("id" => 0, "category" => 0, "sort" => "", "brand" => array());
        if (isset($_GET) && !empty($_GET)) {
            if (array_key_exists("id", $_GET)) {
                $id = preg_replace('/[^0-9]/', '', $_GET["id"]);
                $result["id"] = (int)($id ?? 0);
            }
            if (array_key_exists("category", $_GET)) {
                $category = preg_replace('/[^0-9]/', '', $_GET["category"]);
                $result["category"] = (int)($category ?? 0);
            }
            if (array_key_exists("sort", $_GET)) {
                $sort = preg_replace('/[^A-Za-z]/', '', $_GET["sort"]);
                // Тут можна додати перевірку строки на наявність у певному наборі можливих варіантів сортування.
                $result["sort"] = $sort;
            }
            if (array_key_exists("brand", $_GET)) {
                $brand = preg_replace('/[^0-9\,]/', '', $_GET["brand"]);
                $result["brand"] = explode(',',$brand);
            }
        }
        return $result;
    }

    function paramsToURIString(array $params, $fullSetWithId = false) {
        // Формування коректного готового рядку параметрів запиту для подальшої підстановки у посилання в шаблоні
        $result = '';
        if (isset($params) && !empty($params)) {
            if ($fullSetWithId) if (filled($params["id"])) $result = "id=".$params["id"];
            if (filled($params["category"])) $result .= empty($result) ? "category=".$params["category"] : "&category=".$params["category"];
            if (filled($params["sort"])) $result .= empty($result) ? "sort=".$params["sort"] : "&sort=".$params["sort"];
            if (filled($params["brand"])) {
                $brands = implode(',', $params["brand"]);
                $result .= '&brand='.$brands;
            }
        }
        return $result;
    }

    spl_autoload_register(function (string $className) {
        // Автоматичне завантаження файлів для відсутніх класів у відповідності до їх простіру імен
        require_once __DIR__.'/'.str_replace('\\', '/', $className).'.php';
    });
?>