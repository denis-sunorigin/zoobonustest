<?php

namespace Models;

use Exception;
use mysqli;

class Product
{
    protected $tableName = 'products';

    protected function connectToDBServer() {
        try {
            return new mysqli(DBHOST, DBUSER, DBPASS, DBNAME, DBPORT);
        } catch (Exception $e) {
            return false;
        }
    }

	public function GetAll()
	{
        $mysqli = $this->connectToDBServer();
        if (!$mysqli) return false;
        if (DEBUGLOG) ddlog('product get all: підʼєднано до сервера БД');
        try {
            $sqlresult = $mysqli->query("SELECT * FROM ".$this->tableName.";");
        } catch (Exception $e) {
            return false;
        }
        if (DEBUGLOG) ddlog('product get all: sql-запит виконано');
        $mysqli->close();
        if (!$sqlresult) return false;
        if (DEBUGLOG) ddlog('product get all: результат запиту до БД не false');
        if ($sqlresult->num_rows === 0) return false;
        if (DEBUGLOG) ddlog('product get all: результат запиту до БД містить більше ніж 0 строк');
        return ($sqlresult->fetch_all(MYSQLI_ASSOC));
	}
}

?>