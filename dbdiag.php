<?php
    require_once('settings.php');
    require_once('helpers.php');

    // Діагностика з'єднання з БД.
    // За замовченням при GET-запиті намагається з'єднатись з сервером БД, знайти потрібну базу, перевірити наявність таблиць, та даних в таблицях.
    // Виводить інформацію про поточний стан БД, або про поточну помилку.
    // Також за POST-запитом виконує створення бази даних, таблиць, та їх наповнення. Бажана дія передається як POST-параметр 'dbaction' разом з паролем адміністратора.

    function normalexit($error = '') {
        if (!empty($error)) ddlog($error);
        include('templates/dbdiag.php');
        exit();
    }

    function connectToDBServer(): mysqli {
        try {
            return new mysqli(DBHOST, DBUSER, DBPASS, null, DBPORT);
        } catch (Exception $e) {
            normalexit('Помилка під час зʼєднання з БД. '.$e->getCode().': '.$e->getMessage());
        }
    }

    function changeDB(mysqli $mysqli) {
        $sqlresult = $mysqli->query("USE ".DBNAME.";");
        if (!$sqlresult) normalexit("Не вдалось виконати запит зміни поточної БД. ".$mysqli->errno.': '.$mysqli->error);
    }           

    function checkDBStatus() {
        $mysqli = connectToDBServer();
        $sqlresult = $mysqli->query("SHOW DATABASES LIKE '".DBNAME."';");
        if (!$sqlresult) {
            normalexit("Не вдалось виконати запит про наявні БД. ".$mysqli->errno.': '.$mysqli->error);
        } else {
            if ($sqlresult->num_rows === 0) {
                normalexit('Базу даних з імʼям "'.DBNAME.'" не виявлено. Рекомендується виконати її створення.');
            } else {
                changeDB($mysqli);
                $sqlresult = $mysqli->query("SHOW TABLES;");
                if (!$sqlresult) {
                    normalexit("Не вдалось виконати запит про наявні в БД таблиці. ".$mysqli->errno.': '.$mysqli->error);
                } else {
                    if ($sqlresult->num_rows < 5) {
                        normalexit('База "'.DBNAME.'" існує, але таблиці не виявлено, або виявлено не всі. Знайдено '.$sqlresult->num_rows.' з 5 необхідних таблиць. Рекомендується виконати (повторне) створення таблиць.');
                    } else {
                        $totalcount = 0; $message = ''; $tables = array('users', 'brands', 'categories', 'product_statuses', 'products');
                        foreach ($tables as $tableName) {
                            $sqlresult = $mysqli->query("SELECT COUNT(*) FROM ".$tableName.";");
                            $count = $sqlresult->fetch_assoc()['COUNT(*)'];
                            $totalcount += $count;
                            $message .= 'Таблиця '.$tableName.' містить '.$count.' рядків.<br>'.PHP_EOL;
                        }
                        if ($totalcount < 10) {
                            normalexit($message.'Рекомендується виконати первинне наповнення таблиць.');
                        } else {
                            normalexit();
                        }       
                    }
                }
            }
        }
        $mysqli->close();
        exit(); // Це якась непередбачувана ситуація.
    }

    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        checkDBStatus();
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $REQUEST_DATA = $_POST;
        $dbaction = htmlspecialchars($REQUEST_DATA["dbaction"]);
        if (empty($dbaction) || !in_array($dbaction, ['createdb','createtables','filltables'])) {
            normalexit('Отримано POST-запит з некоректними параметрами');
        } else {
            $password = htmlspecialchars($REQUEST_DATA["password"]);
            if (empty($password)) {
                normalexit("Отримано POST-запит з пустим паролем. Для виконання службових дій з БД необхідно зазначити пароль.");
            } else {
                $hash = hash('sha256', $password);
                if ($hash != DEFAULTADMINPASSWORD) {
                    normalexit('Пароль, отриманий в параметрах POST-запиту не коректний.');
                } else {
                    if ($dbaction == 'createdb') {
                        $mysqli = connectToDBServer();
                        $sqlresult = $mysqli->query("CREATE DATABASE ".DBNAME.";");
                        if (!$sqlresult) normalexit("Не вдалось виконати запит створення БД. ".$mysqli->errno.': '.$mysqli->error);
                        $mysqli->close();
                        checkDBStatus();
                    }
                    if ($dbaction == 'createtables') {
                        $mysqli = connectToDBServer();
                        changeDB($mysqli);
                        $sqlresult = $mysqli->query('CREATE TABLE IF NOT EXISTS categories (id int NOT NULL AUTO_INCREMENT, name varchar(255) NOT NULL UNIQUE, description varchar(255), PRIMARY KEY(id));');
                        if (!$sqlresult) normalexit("Не вдалось виконати запит створення таблиці categories. ".$mysqli->errno.': '.$mysqli->error);
                        $sqlresult = $mysqli->query('INSERT INTO categories (id, name, description) values (1, "Інше", "Дефолтна категорія для товарів, які не відносяться до жодної категорії");');
                        if (!$sqlresult) ddlog("Не вдалось виконати запит створення дефолтного запису в таблиці categories. ".$mysqli->errno.': '.$mysqli->error);

                        $sqlresult = $mysqli->query('CREATE TABLE IF NOT EXISTS brands (id int NOT NULL AUTO_INCREMENT, name varchar(255) NOT NULL UNIQUE, description varchar(255), PRIMARY KEY(id));');
                        if (!$sqlresult) normalexit("Не вдалось виконати запит створення таблиці brands. ".$mysqli->errno.': '.$mysqli->error);
                        $sqlresult = $mysqli->query('INSERT INTO brands (id, name, description) values (1, "Торгову марку не визначено", "Дефолтна пуста торгова марка для товарів, які її не мають, або їх виробляє Харьківський Завод (ХЗ).");');
                        if (!$sqlresult) ddlog("Не вдалось виконати запит створення дефолтного запису в таблиці brands. ".$mysqli->errno.': '.$mysqli->error);

                        $sqlresult = $mysqli->query('CREATE TABLE IF NOT EXISTS product_statuses (id int NOT NULL AUTO_INCREMENT, name varchar(255) NOT NULL UNIQUE, description varchar(255), PRIMARY KEY(id));');
                        if (!$sqlresult) normalexit("Не вдалось виконати запит створення таблиці product_statuses. ".$mysqli->errno.': '.$mysqli->error);
                        $sqlresult = $mysqli->query('INSERT INTO product_statuses (id, name, description) values (1, "Звичайний", "Дефолтний статус товару");');
                        if (!$sqlresult) ddlog("Не вдалось виконати запит створення дефолтного запису в таблиці product_statuses. ".$mysqli->errno.': '.$mysqli->error);

                        $sqlresult = $mysqli->query('CREATE TABLE IF NOT EXISTS users (id int NOT NULL AUTO_INCREMENT, name varchar(255) NOT NULL UNIQUE, hash varchar(255), PRIMARY KEY(id));');
                        if (!$sqlresult) normalexit("Не вдалось виконати запит створення таблиці users. ".$mysqli->errno.': '.$mysqli->error);
                        $sqlresult = $mysqli->query('INSERT INTO users (name, hash) values ("admin", "8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918");');
                        if (!$sqlresult) ddlog("Не вдалось виконати запит створення юзера 'admin' в таблиці users. ".$mysqli->errno.': '.$mysqli->error);

                        $sql  = 'CREATE TABLE IF NOT EXISTS products (id int NOT NULL AUTO_INCREMENT, name varchar(255) NOT NULL, description varchar(3000), '.
                                'value int DEFAULT 0, price DECIMAL(12,2) default 0, code1c varchar(50), image varchar(500) default "pic0.png", brandid int NOT NULL DEFAULT 1, '.
                                'categoryid int NOT NULL DEFAULT 1, statusid int NOT NULL DEFAULT 1, PRIMARY KEY (id), FOREIGN KEY (brandid) REFERENCES brands(id), '.
                                'FOREIGN KEY (categoryid) REFERENCES categories(id), FOREIGN KEY (statusid) REFERENCES product_statuses(id));';
                        $sqlresult = $mysqli->query($sql);
                        if (!$sqlresult) normalexit("Не вдалось виконати запит створення таблиці products. ".$mysqli->errno.': '.$mysqli->error);
                        $mysqli->close();
                        checkDBStatus();
                    }
                    if ($dbaction == 'filltables') {
                        $mysqli = connectToDBServer();
                        changeDB($mysqli);
                        $tables = array('brands', 'categories', 'product_statuses', 'products');
                        include('dataseed.php');
                        $message = '';
                        foreach ($tables as $tableName) {
                            $dataForTable = $fake_data[$tableName];
                            foreach ($dataForTable as $singleRecordForTable) {
                                $keys = array_keys($singleRecordForTable);
                                $values = array_values($singleRecordForTable);
                                $keysStringForSQL = implode(', ',$keys);
                                $valuesStringForSQL = str_replace("'NULL'", 'NULL', "'".implode("', '",$values)."'");
                                $sql = "INSERT INTO ".$tableName." (".$keysStringForSQL.") VALUES (".$valuesStringForSQL.");";
                                $sqlresult = $mysqli->query($sql);
                                if (!$sqlresult) ddlog("Не вдалось виконати запит додавання запису в таблицю ".$tableName.". ".$mysqli->errno.': '.$mysqli->error);
                            }
                        }
                        $mysqli->close();
                        checkDBStatus();
                    }
                }
            }
        }
    }
?>