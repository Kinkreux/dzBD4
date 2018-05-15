<?php
require_once __DIR__ . '/functions.php';

//создаем подключение к базе данных
$dataBase = new PDO('mysql:dbname=mpustovit;host=localhost;charset=UTF8', 'mpustovit', 'neto1714');

createTable($dataBase);

var_dump($_GET);

var_dump($_POST);

//var_dump($tableFields);

////удаляем поле
//if (array_key_exists('action', $_GET) or array_key_exists('id', $_GET)) {
//    $actionArray = newTaskAction();
//    $id = $actionArray['id'];
//    $action = $actionArray['action'];
//    if ($action = 'doTask') {
//        doTask($id, $dataBase);
////        header('Location: index.php');
//    } elseif ($action = 'deleteTask') {
//        deleteTask($id, $dataBase);
////        header('Location: index.php');
//    } else echo 'Действие не определено.';
//}

//обновляем тип или название поля
if (array_key_exists('delete_field', $_GET)) {
    deleteField($dataBase);
}

//читаем список таблиц
$tableList = $dataBase->query("SHOW TABLES");
$tableList = $tableList->fetchAll();
$tableList = array_column($tableList, 'Tables_in_mpustovit');

echo '<pre>';
print_r($tableList);
echo '</pre>';

//выбираем таблицу
if (isset($_GET)) {
    if (array_key_exists('table', $_GET)) {
        $table = chooseTable();
        $tableFields = getFields($table, $dataBase);
//        $tableFields = array_merge($tableFields;);
    }
}
?>

<html>
<header>
    <title>Управление таблицами и базами данных</title>
    <style>
        h1, h2 {
            font-size: 18px;
        }

        body {
            max-width: 850px;
            margin-left: 15%;
        }

        td {
            padding: 10px;
        }


        .warning {
            color: darkred;
        }

        .inline-block {
            display: inline-block;
        }
    </style>
</header>
<body>
<h1>Управление таблицами и базами данных</h1>
<h2>База данных mpustovit</h2>
<ul>
    <?php
    //читаем и выводим задачи построчно
    foreach ($tableList as $table) : ?>
        <li><?php //список таблиц
            echo '<a href="?table=' . $table . '">' . $table . '</a>' ?></li>
    <?php endforeach; ?>
</ul>
<a href="?create_table">Создать таблицу</a>
<p class="warning">ПОЖАЛУЙСТА, ДЛЯ ОБЕСПЕЧЕНИЯ ПРОВЕРКИ ПРЕДЫДУЩИХ ДОМАШНИХ ЗАДАНИЙ НЕ ТРОГАЙТЕ ПОЛЯ ТАБЛИЦ <code>tasks</code> И <code>users</code>. СПАСИБО!</p>
<p class="warning">Для проверки этого дз есть таблица <b><code>test</code></b>.</p>
<?php
if (isset($tableFields)) { ?>
<p>Таблицы</p>
<table>
    <thead>
    <th>Название поля</th>
    <th>Тип поля</th>
    <th>Действия:</th>
    </thead>
    <tbody>
    <?php

    //читаем и выводим задачи построчно
    foreach ($tableFields as $field) : ?>
        <tr>
<!--            --><?php ////название
//            $table = $field['table'];
//            echo $name ?>
            <td><?php //название
                $name = $field['Field'];
                echo $name ?>
            </td>
            <td><?php //тип поля
                echo $field['Type'] ?></td>
            <td>
                <form method="post" name="">
                    <p class="inline-block">Редактировать название</p>
                    <input type="text" name="table_<?php echo $table ?>_new_field_name_<?php echo $name ?>">
                    <p class="inline-block">Редактировать тип</p>
                    <select class="inline-block">
                           <option value="table_<?php echo $table ?>_new_field_type_name_<?php echo $name ?>&new_field_type_varchar&new_field_type_varchar">varchar(255)</option>
                            <option value="table_<?php echo $table ?>_new_field_type_name_<?php echo $name ?>&new_field_type_varchar&new_field_type_int">int</option>
                    </select>
                    <input type="submit" value="Сохранить">
                </form>
            <td><?php //удалить поле
                echo '<a href="?table='.$table.'&name=' . $name . '&action=delete_field">' . 'Удалить</a>'; var_dump($table); ?></td>
        </tr>
    <?php endforeach; } ?>
    </tbody>
</table>
<h2>Код приложения</h2>
<a href="https://github.com/Kinkreux/dzBD4" target="_blank">Открыть в новом окне репозиторий на Github</a>
</body>
</html>