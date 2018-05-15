<?php

//Добавить задачу в базу
function newTask($description, $dataBase)
{
    $time = new DateTime('now');
    $time = date_format($time, 'Y-m-d H:i:s');
    $dataBase->exec("INSERT INTO tasks(description, date_added) value ('".$description."', '".$time."')");
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

//получаем поля таблицы
function getFields($dataBase)
{
    if (isset($_GET)) {
        if (array_key_exists('table', $_GET)) {
            foreach ($_GET as $get)
                (
                htmlspecialchars($get)
                );
            $table = $_GET['table'];
            $sql = 'DESCRIBE ' . $table;
            $tableFields = $dataBase->query($sql);
            $tableFields = $tableFields->fetchAll();
            return $tableFields;
        } else {
            return false;
        }
    }
}

//обработка формы
function updateField()
{
    if (isset($_POST)) {
        if (array_key_exists('new_field_name', $_POST) or array_key_exists('new_field_type', $_POST)) {
            foreach ($_POST as $post)
                (
                htmlspecialchars($post)
                );
            $updateField = $_POST;
            var_dump($updateField);
            return $updateField;
        }
    }
}

function deleteField()
{
    if (isset($_GET)) {
        if (array_key_exists('delete_field', $_GET)) {
            foreach ($_GET as $get)
                (
                htmlspecialchars($get)
                );
            $deleteFieldName = $_GET['name'];


        }
    }
}