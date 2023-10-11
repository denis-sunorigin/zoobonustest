<?php

namespace Models;

use Exception;

class Product extends DBTable
{
    protected $tableName = 'products';
    protected $fields = ["id", "image", "name", "description", "value", "price", "code1c", "brandid", "statusid", "categoryid"];
    protected $foreigns =  [["table" => "brands", "selfColumn" => "brandid", "columnNameAs" => "brandname"],
                            ["table" => "product_statuses", "selfColumn" => "statusid", "columnNameAs" => "statusname"],
                            ["table" => "categories", "selfColumn" => "categoryid", "columnNameAs" => "categoryname"]];
                            // Laravel в цьому випадку використовує погодження, згідно яких є дефолтні залежності імен таблиці, поля, ключа. При використанні погоджень, такий масив стає не потрібним.

    public function GetWithJoinNamesFromDict(string $whereField = '', string $whereValue = '', string $orderFieldName = '', string $orderDirection = '')
	{
        $orderFieldName = preg_replace('/[^A-Za-z0-9\_]/', '', $orderFieldName); // Імпровізований захист від SQL-ін'єкцій
        $whereField = preg_replace('/[^A-Za-z0-9\_]/', '', $whereField);
        $whereValue = preg_replace('/[^A-Za-z0-9\_]/', '', $whereValue);

        // Підготовка рядка сортування
        if (isset($orderFieldName) && isset($orderDirection) && !empty($orderFieldName) && !empty($orderDirection) && in_array($orderDirection, array('asc', 'ASC', 'desc', 'DESC'))) {
            $orderSuffix = " ORDER BY ".$orderFieldName." ".$orderDirection;
            if (DEBUGLOG) ddlog(__METHOD__.'('.$this->tableName.'): отримано коректні значення сортування, а саме "'.$orderFieldName.'", "'.$orderDirection.'".');
        } else {
            $orderSuffix = "";
            if (DEBUGLOG) ddlog(__METHOD__.'('.$this->tableName.'): значення сортування не отримано (або вони не коректні)');
        }

        // Підготовка рядка фільтру
        if (isset($whereField) && isset($whereValue) && !empty($whereField) && !empty($whereValue) && in_array($whereField, $this->fields)) {
            $whereSuffix = " WHERE ".$whereField." = '".$whereValue."'";
            if (DEBUGLOG) ddlog(__METHOD__.'('.$this->tableName.'): отримано коректні значення фільтру, а саме "'.$whereField.'"="'.$whereValue.'".');
        } else {
            $whereSuffix = "";
            if (DEBUGLOG) ddlog(__METHOD__.'('.$this->tableName.'): значення фільтру не отримано (або вони не коректні)');
        }

        // Підготовка повного SQL-запиту
        $sql = 'SELECT ';
        foreach ($this->fields as $field) $sql .= "t1.".$field." as ".$field.", ";
        $ch = 1;
        foreach ($this->foreigns as $foreign) { $ch++; $sql .= "t".$ch.".name as ".$foreign["columnNameAs"].", "; }
        $sql = substr($sql,0,-2)." FROM ".$this->tableName." as t1 ";
        $ch = 1;
        foreach ($this->foreigns as $foreign) { $ch++; $sql .= " LEFT JOIN ".$foreign["table"]." as t".$ch." ON t1.".$foreign["selfColumn"]." = t".$ch.".id "; }
        $sql .= $whereSuffix." ".$orderSuffix.";";
        if (DEBUGLOG) ddlog(__METHOD__.'('.$this->tableName.'): текст SQL-запиту, який наразі буде виконано:'.PHP_EOL.$sql.PHP_EOL);

        // Підключення до SQL-сервера
        $mysqli = $this->connectToDBServer();
        if (!$mysqli) return false;
        if (DEBUGLOG) ddlog(__METHOD__.'('.$this->tableName.'): підʼєднано до сервера БД');

        // Виконання запиту
        try {
            $sqlresult = $mysqli->query($sql);
        } catch (Exception $e) {
            return false;
        }
        if (DEBUGLOG) ddlog(__METHOD__.'('.$this->tableName.'): sql-запит виконано');
        $mysqli->close();
        if (!$sqlresult) return false;
        if (DEBUGLOG) ddlog(__METHOD__.'('.$this->tableName.'): результат запиту до БД не false');
        if ($sqlresult->num_rows === 0) return false;
        if (DEBUGLOG) ddlog(__METHOD__.'('.$this->tableName.'): результат запиту до БД містить більше ніж 0 строк');
        return ($sqlresult->fetch_all(MYSQLI_ASSOC));
	}

}

?>