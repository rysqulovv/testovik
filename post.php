<?php
// настройка БД
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'technadom');
 
/* Соединяемся */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
// Проверяем соединение
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>