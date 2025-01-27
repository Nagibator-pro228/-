<?php
$host = 'localhost'; // Хост базы данных
$dbname = 'user_database'; // Название базы данных
$user = 'root'; // Имя пользователя базы данных
$password = ''; // Пароль базы данных

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Ошибка подключения к базе данных: " . $e->getMessage());
}
?>