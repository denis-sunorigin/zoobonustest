<?php
    require_once('settings.php');

    function sendToTelega($message) {
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
        error_log(date('Y-m-d H:i:s ').$message.PHP_EOL, 3, LOGFILE);
        if ($isImportantError) sendToTelega('На сайті виникла важлива помилка, що потребує уваги. '.PHP_EOL.$message);
    }

    function filled($anyValue): bool {
        // Для швидкої перевірки наявності значень всередині html, бо функція isset працює інакше, а !empty погано сприймається.
        return empty($anyValue) ? false : !($anyValue === false);
    }

    function zbAutoLoader(string $className) {
        require_once __DIR__.'/'.str_replace('\\', '/', $className).'.php';
    }

    spl_autoload_register('zbAutoLoader');
?>