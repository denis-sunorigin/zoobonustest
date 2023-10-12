<?php

namespace Models;

use Exception;

class User extends DBTable
{
    protected $tableName = 'users';

    public function VerifyLoginPassword(string $login = '', string $hash = '')
	{
        $result = ["success" => false, "message" => ''];
        $login = preg_replace('/[^A-Za-z0-9\_\-\@.]/', '', $login);
        $hash = preg_replace('/[^A-Za-z0-9]/', '', $hash);
        if (empty($login) || empty($hash)) { $result["message"] = 'Отримано пустий логін та/або пароль'; return $result; };
        if (DEBUGLOG) ddlog(__METHOD__.'('.$this->tableName.'): під час верифікації логіна і пароля (хеша) користувача, отримано коректні дані, а саме: "'.$login.'", "'.$hash.'".');
        $mysqli = $this->connectToDBServer();
        if (!$mysqli) { $result["message"] = 'Не вийшло підʼєднатись до сервера БД'; return $result; };
        if (DEBUGLOG) ddlog(__METHOD__.'('.$this->tableName.'): підʼєднано до сервера БД');
        try {
            $sqlresult = $mysqli->query("SELECT * FROM ".$this->tableName." WHERE name='".$login."' AND hash='".$hash."';");
        } catch (Exception $e) {
            $result["message"] = 'Виникла помилка під час запиту до БД';
            return $result;
        }
        if (DEBUGLOG) ddlog(__METHOD__.'('.$this->tableName.'): sql-запит виконано');
        $mysqli->close();
        if (!$sqlresult) { $result["message"] = 'Немає відповіді від сервера під час запиту до БД'; return $result; };
        if (DEBUGLOG) ddlog(__METHOD__.'('.$this->tableName.'): результат запиту до БД не false');
        if ($sqlresult->num_rows === 0) { $result["message"] = 'Користувача з зазначеними обліковими даними не знайдено'; return $result; };
        if (DEBUGLOG) ddlog(__METHOD__.'('.$this->tableName.'): результат запиту до БД містить більше ніж 0 строк');
        $result["success"] = true;
        return $result;
    }
}

?>