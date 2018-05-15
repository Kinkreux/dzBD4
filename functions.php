<?php
//создаем таблицу
function createTable($dataBase)
{
    if (isset($_GET)) {
        if (array_key_exists('create_table', $_GET)) {

            //дамп создания базы
            try {
                $dataBase->exec(
                    "
                          CREATE TABLE test (
                          id int(11) NOT NULL AUTO_INCREMENT,
                          description text NOT NULL,
                          date_added datetime NOT NULL,
                          PRIMARY KEY(id)
                          ) ENGINE = InnoDB DEFAULT CHARSET = utf8;");
            } catch (PDOException $e) {
                die("Error: " . $e->getMessage());
            }
        }
    }
}

//Добавить задачу в базу
function newTask($description, $dataBase)
{
    $time = new DateTime('now');
    $time = date_format($time, 'Y-m-d H:i:s');
    $dataBase->exec("INSERT INTO tasks(description, date_added) value ('" . $description . "', '" . $time . "')");
}

//Выполнить задачу
function newFieldName($fieldName, $newFieldName, $dataBase)
{
//    $sqlConcat = '\"UPDATE'.$tableName.'SET'.$fieldName.'='.$newFieldName.'";
//    $sql = stripslashes($sqlConcat);
//    $dataBase->exec($sql);
}

//Удалить задачу
function deleteTask($id, $dataBase)
{
    $dataBase->exec("DELETE FROM tasks WHERE id=$id");
}

//выбираем таблицу
function chooseTable()
{
    if (isset($_GET)) {
        if (array_key_exists('table', $_GET)) {
            foreach ($_GET as $get)
                (
                stripcslashes($get)
                );
            $table = $_GET['table'];
            return $table;
        }
    }
}


//получаем поля таблицы
function getFields($table, $dataBase)
{
    if (isset($table)) {
        $sql = 'DESCRIBE ' . $table;
        $tableFields = $dataBase->query($sql);
        $tableFields = $tableFields->fetchAll();
        return $tableFields;
    } else {
        return false;
    }
}

//обработка формы
function updateField()
{
    if (isset($_POST)) {
        if (array_key_exists('new_field_name', $_POST) or array_key_exists('new_field_type', $_POST)) {
            foreach ($_POST as $post)
                (
                stripcslashes($post)
                );
            $updateField = $_POST;
            var_dump($updateField);
            return $updateField;
        }
    }
}

function deleteField($dataBase)
{
    if (isset($_GET)) {
        if (array_key_exists('delete_field', $_GET)) {
            foreach ($_GET as $get)
                (
                stripcslashes($get)
                );
            $sql = 'ALTER TABLE ' . $_GET['table'] . '  DROP COLUMN ' . $_GET['name'];
            $dataBase->exec($sql);
        }
    }
}
//array(1) { ["table"]=> string(4) "test" } array(1) { ["table_users_new_field_name_id"]=> string(10) "sbieg'maew" }