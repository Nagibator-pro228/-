<?php
session_start();
require_once 'db_connection.php'; // Подключаемся к базе данных

// Проверяем, авторизован ли пользователь
if (isset($_SESSION['user'])) {
    header("Location: index.php");
    exit;
}

// Проверяем, была ли отправлена форма
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = trim($_POST['first_name']);
    $lastName = trim($_POST['last_name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirmPassword = trim($_POST['confirm_password']);

    // Проверяем, заполнены ли все поля
    if (empty($firstName) || empty($lastName) || empty($email) || empty($password) || empty($confirmPassword)) {
        die("Пожалуйста, заполните все поля.");
    }

    // Проверяем, совпадают ли пароли
    if ($password !== $confirmPassword) {
        die("Пароли не совпадают.");
    }

    // Хэшируем пароль для безопасности
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Проверяем, есть ли пользователь с таким же email
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    if ($stmt->rowCount() > 0) {
        die("Пользователь с таким email уже существует.");
    }

    // Сохраняем пользователя в базе данных
    $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, email, password) VALUES (:first_name, :last_name, :email, :password)");
    $stmt->execute([
        'first_name' => $firstName,
        'last_name' => $lastName,
        'email' => $email,
        'password' => $hashedPassword
    ]);

    // Записываем данные в сессию
    $_SESSION['user'] = [
        'first_name' => $firstName,
        'last_name' => $lastName,
        'email' => $email
    ];

    // Перенаправляем на главную страницу
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            padding: 20px;
        }
        .form-container {
            width: 300px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .form-container h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        .form-container input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .form-container button {
            width: 100%;
            padding: 10px;
            background-color: #666;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .form-container button:hover {
            background-color: #555;
        }
        .form-container a {
            display: block;
            text-align: center;
            margin-top: 10px;
            color: #666;
            text-decoration: none;
        }
        .form-container a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h1>Регистрация</h1>
        <form method="POST">
            <input type="text" name="first_name" placeholder="Имя" required>
            <input type="text" name="last_name" placeholder="Фамилия" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Пароль" required>
            <input type="password" name="confirm_password" placeholder="Повторите пароль" required>
            <button type="submit">Зарегистрироваться</button>
        </form>
        <a href="login.php">Уже есть аккаунт? Войти</a>
    </div>
</body>
</html>