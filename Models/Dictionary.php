<?php

namespace Models;

use Exception;
use mysqli;

class Dictionary
{
    protected $tableName;

    protected function connectToDBServer() {
        try {
            return new mysqli(DBHOST, DBUSER, DBPASS, DBNAME, DBPORT);
        } catch (Exception $e) {
            return false;
        }
    }

	public function GetAll()
	{
        // Щоб не ускладнювати логіку, замість помилок тупо 'false'. Інакше треба з цього рівня проводити помилки аж до фронта, це не дуже легко і не дуже потрібно.
        // Хоча тут можна додати логування.
        $mysqli = $this->connectToDBServer();
        if (!$mysqli) return false;
        try {
            $sqlresult = $mysqli->query("SELECT * FROM ".$this->tableName.";");
        } catch (Exception $e) {
            return false;
        }
        $mysqli->close();
        if (!$sqlresult) return false;
        if ($sqlresult->num_rows === 0) return false;
        return ($sqlresult->fetch_all(MYSQLI_ASSOC));
	}
}

?>