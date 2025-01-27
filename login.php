<?php
session_start();
require_once 'db_connection.php'; // Подключаемся к базе данных

// Проверяем, авторизован ли пользователь
if (isset ($_SESSION['user'])) {
    header("Location: index.php");
    exit;
}

// Проверяем, была ли отправлена форма
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Проверяем, существует ли пользователь
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        // Сохраняем данные пользователя в сессии
        $_SESSION['user'] = [
            'first_name' => $user['first_name'],
            'last_name' => $user['last_name'],
            'email' => $user['email'],
        ];
        header('Location: index.php'); // Перенаправляем на главную страницу
        exit;
    } else {
        $error = "Неверный email или пароль.";
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход</title>
</head>
<body>
    <h1>Вход</h1>

    <?php if (isset($error)): ?>
        <p style="color: red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form action="login.php" method="POST">
        <label>Email: <input type="email" name="email" required></label><br>
        <label>Пароль: <input type="password" name="password" required></label><br>
        <button type="submit">Войти</button>
    </form>

    <p>Нет аккаунта? <a href="register.php">Зарегистрироваться</a></p>
</body>
</html>