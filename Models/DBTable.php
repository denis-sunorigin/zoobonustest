<?php

namespace Models;

use Exception;
use mysqli;

class DBTable
{
    protected $tableName;

    protected function connectToDBServer() {
        try {
            return new mysqli(DBHOST, DBUSER, DBPASS, DBNAME, DBPORT);
        } catch (Exception $e) {
            return false;
        }
    }

    protected function clearParamString($value) : string { return preg_replace('/[^A-Za-z0-9\_\-]/', '', $value); } // Набір допустими символів добре б винести в константи/налаштування

    protected function checkRequestParamsIsGood($params = array()) {
        $isAllRight = true;
        foreach ($params as $param) if (empty($this->clearParamString($param))) $isAllRight = false;
        return $isAllRight;
    }

	public function GetAll(string $orderFieldName = '', string $orderDirection = '')
	{
        // Щоб не ускладнювати логіку, замість помилок тупо 'false'. Інакше треба з цього рівня проводити помилки аж до фронта, це не дуже легко і не дуже потрібно.
        if (isset($orderFieldName) && isset($orderDirection) && !empty($orderFieldName) && !empty($orderDirection) && in_array($orderDirection, array('asc', 'ASC', 'desc', 'DESC'))) {
            $orderSuffix = " ORDER BY ".$orderFieldName." ".$orderDirection;
            if (DEBUGLOG) ddlog(__METHOD__.'('.$this->tableName.'): отримано коректні значення сортування, а саме "'.$orderFieldName.'", "'.$orderDirection.'".');
        } else {
            $orderSuffix = "";
            if (DEBUGLOG) ddlog(__METHOD__.'('.$this->tableName.'): значення сортування не отримано (або вони не коректні)');
        }
        $mysqli = $this->connectToDBServer();
        if (!$mysqli) return false;
        if (DEBUGLOG) ddlog(__METHOD__.'('.$this->tableName.'): підʼєднано до сервера БД');
        try {
            $sqlresult = $mysqli->query("SELECT * FROM ".$this->tableName.$orderSuffix.";");
        } catch (Exception $e) {
            return false;
        }
        if (DEBUGLOG) ddlog(__METHOD__.'('.$this->tableName.'): sql-запит виконано без exceptionʼів');
        $mysqli->close();
        if (!$sqlresult) return false;
        if (DEBUGLOG) ddlog(__METHOD__.'('.$this->tableName.'): результат запиту до БД не false');
        if ($sqlresult->num_rows === 0) return false;
        if (DEBUGLOG) ddlog(__METHOD__.'('.$this->tableName.'): результат запиту до БД містить більше ніж 0 строк');
        return ($sqlresult->fetch_all(MYSQLI_ASSOC));
	}

    public function GetListBySingleCondition(string $fieldName, string $value, string $orderFieldName = '', string $orderDirection = '')
	{
        $fieldName = preg_replace('/[^A-Za-z0-9\_]/', '', $fieldName);  // Імпровізований захист від SQL-ін'єкцій
        $value = preg_replace('/[^A-Za-z0-9\_]/', '', $value);
        $orderFieldName = preg_replace('/[^A-Za-z0-9\_]/', '', $orderFieldName);
        if (empty($fieldName) || empty($value)) return false;
        if (DEBUGLOG) ddlog(__METHOD__.'('.$this->tableName.'): під час визова функції запиту з фільтрацією отримано коректні назву і значення поля, а саме "'.$fieldName.'"="'.$value.'".');
        if (isset($orderFieldName) && isset($orderDirection) && !empty($orderFieldName) && !empty($orderDirection) && in_array($orderDirection, array('asc', 'ASC', 'desc', 'DESC'))) {
            $orderSuffix = " ORDER BY ".$orderFieldName." ".$orderDirection;
            if (DEBUGLOG) ddlog(__METHOD__.'('.$this->tableName.'): отримано коректні значення сортування, а саме "'.$orderFieldName.'", "'.$orderDirection.'".');
        } else {
            $orderSuffix = "";
            if (DEBUGLOG) ddlog(__METHOD__.'('.$this->tableName.'): значення сортування не отримано (або вони не коректні)');
        }
        $mysqli = $this->connectToDBServer();
        if (!$mysqli) return false;
        if (DEBUGLOG) ddlog(__METHOD__.'('.$this->tableName.'): підʼєднано до сервера БД');
        try {
            $sqlresult = $mysqli->query("SELECT * FROM ".$this->tableName." WHERE ".$fieldName."='".$value."'".$orderSuffix.";");
        } catch (Exception $e) {
            return false;
        }
        if (DEBUGLOG) ddlog(__METHOD__.'('.$this->tableName.'): sql-запит виконано без exceptionʼів');
        $mysqli->close();
        if (!$sqlresult) return false;
        if (DEBUGLOG) ddlog(__METHOD__.'('.$this->tableName.'): результат запиту до БД не false');
        if ($sqlresult->num_rows === 0) return false;
        if (DEBUGLOG) ddlog(__METHOD__.'('.$this->tableName.'): результат запиту до БД містить більше ніж 0 строк');
        return ($sqlresult->fetch_all(MYSQLI_ASSOC));
	}

    public function GetFirstBySingleCondition(string $fieldName, string $value)
	{
        $fieldName = preg_replace('/[^A-Za-z0-9\_]/', '', $fieldName);
        $value = preg_replace('/[^A-Za-z0-9\_]/', '', $value);
        if (empty($fieldName) || empty($value)) return false;
        if (DEBUGLOG) ddlog(__METHOD__.'('.$this->tableName.'): під час визова функції запиту з фільтрацією отримано коректні назву і значення поля, а саме "'.$fieldName.'"="'.$value.'".');
        $mysqli = $this->connectToDBServer();
        if (!$mysqli) return false;
        if (DEBUGLOG) ddlog(__METHOD__.'('.$this->tableName.'): підʼєднано до сервера БД');
        try {
            $sqlresult = $mysqli->query("SELECT * FROM ".$this->tableName." WHERE ".$fieldName."='".$value."' LIMIT 1;");
        } catch (Exception $e) {
            return false;
        }
        if (DEBUGLOG) ddlog(__METHOD__.'('.$this->tableName.'): sql-запит виконано без exceptionʼів');
        $mysqli->close();
        if (!$sqlresult) return false;
        if (DEBUGLOG) ddlog(__METHOD__.'('.$this->tableName.'): результат запиту до БД не false');
        if ($sqlresult->num_rows === 0) return false;
        if (DEBUGLOG) ddlog(__METHOD__.'('.$this->tableName.'): результат запиту до БД містить більше ніж 0 строк');
        return ($sqlresult->fetch_all(MYSQLI_ASSOC));
	}

    public function GetById(int $id = 0)
	{
        $id = preg_replace('/[^0-9]/', '', $id);
        if ($id < 1) return false;
        if (DEBUGLOG) ddlog(__METHOD__.'('.$this->tableName.'): під час виклику функції отримано коректний id="'.$id.'"');
        $mysqli = $this->connectToDBServer();
        if (!$mysqli) return false;
        if (DEBUGLOG) ddlog(__METHOD__.'('.$this->tableName.'): підʼєднано до сервера БД');
        try {
            $sqlresult = $mysqli->query("SELECT * FROM ".$this->tableName." WHERE id='".$id."';");
        } catch (Exception $e) {
            return false;
        }
        if (DEBUGLOG) ddlog(__METHOD__.'('.$this->tableName.'): sql-запит виконано без exceptionʼів');
        $mysqli->close();
        if (!$sqlresult) return false;
        if (DEBUGLOG) ddlog(__METHOD__.'('.$this->tableName.'): результат запиту до БД не false');
        if ($sqlresult->num_rows === 0) return false;
        if (DEBUGLOG) ddlog(__METHOD__.'('.$this->tableName.'): результат запиту до БД містить більше ніж 0 строк');
        return ($sqlresult->fetch_assoc());
	}

    public function UpdateProperty(string $updateFieldName, string $updateValue, string $whereFieldName = '', string $whereValue = '')
	{
        if ( ! ($this->checkRequestParamsIsGood([$updateFieldName, $updateValue, $whereFieldName, $whereValue]))) return false;
        $mysqli = $this->connectToDBServer();
        if (!$mysqli) return false;
        if (DEBUGLOG) ddlog(__METHOD__.'('.$this->tableName.'): підʼєднано до сервера БД');
        $sql =  "UPDATE ".$this->tableName." SET ".$this->clearParamString($updateFieldName)."='".$this->clearParamString($updateValue)."' ";
        $sql .= "WHERE ".$this->clearParamString($whereFieldName)."='".$this->clearParamString($whereValue)."';";
        if (DEBUGLOG) ddlog(__METHOD__.'('.$this->tableName.'):'.PHP_EOL.'SQL:'.PHP_EOL.$sql.PHP_EOL);
        try {
            $sqlresult = $mysqli->query($sql);
            if (DEBUGLOG) ddlog(__METHOD__.'('.$this->tableName.'): sql-запит виконано без exceptionʼів');
        } catch (Exception $e) {
            if (DEBUGLOG) ddlog(__METHOD__.'('.$this->tableName.'): sql-запит НЕ виконано, exception під час виконання');
            return false;
        }
        $ar = $mysqli->affected_rows;
        $mysqli->close();
        if (DEBUGLOG) ddlog(__METHOD__.'('.$this->tableName.'): запит торкнувся '.$ar.' рядків');
        if (!$sqlresult) return false;
        if (DEBUGLOG) ddlog(__METHOD__.'('.$this->tableName.'): результат запиту до БД не false');
        return $ar;
	}

    public function DeleteById(int $id = 0)
	{
        $id = preg_replace('/[^0-9]/', '', $id);
        if ($id < 1) return false;
        if (DEBUGLOG) ddlog(__METHOD__.'('.$this->tableName.'): під час виклику функції отримано коректний id="'.$id.'"');
        $mysqli = $this->connectToDBServer();
        if (!$mysqli) return false;
        if (DEBUGLOG) ddlog(__METHOD__.'('.$this->tableName.'): підʼєднано до сервера БД');
        try {
            $sqlresult = $mysqli->query("DELETE FROM ".$this->tableName." WHERE id='".$id."';");
        } catch (Exception $e) {
            return false;
        }
        if (DEBUGLOG) ddlog(__METHOD__.'('.$this->tableName.'): sql-запит виконано без exceptionʼів');
        $ar = $mysqli->affected_rows;
        if ($mysqli->error) if (DEBUGLOG) ddlog($mysqli->error);
        $mysqli->close();
        if (DEBUGLOG) ddlog(__METHOD__.'('.$this->tableName.'): запит торкнувся '.$ar.' рядків');
        if (!$sqlresult || ($ar == -1)) {
            if (DEBUGLOG) ddlog(__METHOD__.'('.$this->tableName.'): запит до БД виконано невдало, ОТРИМАНО НЕКОРЕКТНУ ВІДПОВІДЬ');
            return false;
        }
        if (DEBUGLOG) ddlog(__METHOD__.'('.$this->tableName.'): результат запиту до БД не false');
        return $ar;
	}
}

?>