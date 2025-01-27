<?php
session_start(); // Стартуем сессию

// Проверяем, авторизован ли пользователь
$isLoggedIn = isset($_SESSION['user']);
$firstName = $isLoggedIn ? $_SESSION['user']['first_name'] : '';
$lastName = $isLoggedIn ? $_SESSION['user']['last_name'] : '';
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Главная</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        .banner {
            background-color: #777;
            padding: 10px 20px;
            color: #fff;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-radius: 8px;
        }
        .logo {
            font-size: 24px;
            font-weight: bold;
        }
        .menu {
            display: flex;
            gap: 20px;
        }
        .menu a {
            color: #fff;
            text-decoration: none;
            font-size: 16px;
        }
        .menu a:hover {
            text-decoration: underline;
        }
        .container {
            margin-top: 20px;
        }
        .row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .block {
            background-color: #ddd;
            padding: 20px;
            flex: 1;
            text-align: center;
            margin: 0 10px;
            border-radius: 8px;
        }
        .block:first-child {
            margin-left: 0;
        }
        .block:last-child {
            margin-right: 0;
        }
        .black-bar {
            background-color: #000;
            color: #fff;
            text-align: center;
            padding: 20px;
            border-radius: 8px;
        }
    </style>
</head>
<body>
    <div class="banner">
        <div class="logo">LOGO</div>
        <div class="menu">
            <a href="index.php">главная</a>
            <a href="contacts.php">контакты</a>
            <a href="about.php">о нас</a>
            <?php if ($isLoggedIn): ?>
                <a href="logout.php">выйти</a>
            <?php else: ?>
                <a href="login.php">войти</a>
            <?php endif; ?>
        </div>
    </div>

    <div class="container">
        <?php if ($isLoggedIn): ?>
            <p>Добро пожаловать, <strong><?= htmlspecialchars($firstName) ?> <?= htmlspecialchars($lastName) ?></strong>!</p>
        <?php endif; ?>

        <div class="row">
            <div class="block">тут будет первый блок</div>
            <div class="block">второй блок</div>
            <div class="block">третий блок</div>
        </div>
        <div class="black-bar">прикол тут будет</div>
    </div>
</body>
</html>