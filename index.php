<?php
require_once __DIR__ . '/functions.php';

//создаем подключение к базе данных
$dataBase = new PDO('mysql:dbname=mpustovit;host=localhost;charset=UTF8', 'mpustovit', 'neto1714');

//дамп создания базы; она уже 1 раз создана, так что закомментирована
/*try {
    $test = $dataBaseTasks->exec(
        "DROP TABLE IF EXISTS `tasks`;
                          CREATE TABLE `tasks` (
                          `id` int(11) NOT NULL AUTO_INCREMENT,
                          `description` text NOT NULL,
                          `is_done` tinyint(4) NOT NULL DEFAULT '0',
                          `date_added` datetime NOT NULL,
                          PRIMARY KEY(`id`)
                          ) ENGINE = InnoDB DEFAULT CHARSET = utf8;");
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}*/

//выбираем таблицу
if (isset($_GET)) {
    if (array_key_exists('table', $_GET)) {
        $tableFields = getFields($dataBase);
    }
}

var_dump($tableFields);

//удаляем поле
if (array_key_exists('action', $_GET) or array_key_exists('id', $_GET)) {
    $actionArray = newTaskAction();
    $id = $actionArray['id'];
    $action = $actionArray['action'];
    if ($action = 'doTask') {
        doTask($id, $dataBase);
//        header('Location: index.php');
    } elseif ($action = 'deleteTask') {
        deleteTask($id, $dataBase);
//        header('Location: index.php');
    } else echo 'Действие не определено.';
}

//обновляем тип или название поля
if (array_key_exists('delete_field', $_GET)) {

}

//читаем список таблиц
$tableList = $dataBase->query("SHOW TABLES");
$tableList = $tableList->fetchAll();
$tableList = array_column($tableList, 'Tables_in_mpustovit');
?>

<html>
<header>
    <title>Управление таблицами и базами данных</title>
    <style>
        h1, h2 {
            font-size: 18px;
        }

        body {
            max-width: 700px;
            margin-left: 15%;
        }

        td {
            padding: 10px;
        }
    </style>
</header>
<body>
<h1>Управление таблицами и базами данных</h1>
<h2>База данных mpustovit</h2>
<p>Таблицы</p>
<ul>
    <?php
    //читаем и выводим задачи построчно
    foreach ($tableList as $table) : ?>
        <li><?php //список таблиц
            echo '<a href="?table=' . $table . '">' . $table . '</a>' ?></li>
    <?php endforeach; ?>
</ul>
<?php
if (isset($tableFields)) { ?>
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
            <td><?php //название
                $name = $field['Field'];
                echo $name ?>
            </td>
            <td><?php //тип поля
                echo $field['Type'] ?></td>
            <td>
                <form method="post" name="new_field_name<?php echo $name ?>">
                    <input type="text" name="new_field_name_text">
                    <input type="submit" value="Редактировать название">
                </form>
            </td>
            <td>
                <form method="post" name="">
                    <input type="text" name="new_field_name_text">
                    <select>
                        <option value="new_field_type</option>
                        <?php foreach($userList as $userTask) {
                            echo '<option value="new_field_type'.$name.'">'.$name.'</option>';
                        } ?>
                    </select>
                    <input type="submit" value="Редактировать тип">
                </form>
            <td><?php //удалить поле
                echo '<a href="?name=' . $name . '&action=delete_field">' . 'Удалить</a>' ?></td>
        </tr>
    <?php endforeach; } ?>
    </tbody>
</table>
<h2>Код приложения</h2>
<a href="https://github.com/Kinkreux/dzBD4" target="_blank">Открыть в новом окне репозиторий на Github</a>
</body>
</html>