<?php
session_start();
session_destroy(); // Завершаем сессию
header('Location: register.php'); // Перенаправляем на страницу регистрации
exit;
?>