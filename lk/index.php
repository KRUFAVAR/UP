<?php
session_start();
require_once 'config/db.php';

if (isset($_SESSION['user_id'])) {
    header("Location: views/profile.php");
    exit;
}

$errors = [];

// Обработка формы авторизации
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT id, password FROM Users WHERE email = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        header("Location: views/profile.php");
        exit;
    } else {
        $errors[] = "Неверный email или пароль.";
    }
}

// Обработка формы регистрации
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $passwordConfirm = $_POST['password_confirm'];

    if ($password !== $passwordConfirm) {
        $errors[] = "Пароли не совпадают.";
    } else {
        $sql = "SELECT id FROM Users WHERE email = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$email]);

        if ($stmt->fetch()) {
            $errors[] = "Пользователь с таким email уже зарегистрирован.";
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO Users (username, email, password, registration_date) VALUES (?, ?, ?, NOW())";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$username, $email, $hashedPassword]);
            $_SESSION['user_id'] = $pdo->lastInsertId();
            header("Location: views/profile.php");
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/styles.css">
    <title>Авторизация и Регистрация</title>
    <style>
        /* Добавьте стили для переключения форм */
        .form-container {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            width: 300px;
            margin: 0 auto;
        }
        .form-toggle {
            cursor: pointer;
            color: blue;
            text-decoration: underline;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <h1>Добро пожаловать!</h1>
    <div class="form-container">
        <!-- Вывод ошибок -->
        <?php if ($errors): ?>
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?php echo htmlspecialchars($error); ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <!-- Переключатель форм -->
        <div id="formToggle" class="form-toggle" onclick="toggleForms()">Переключить на регистрацию</div>

        <!-- Форма авторизации -->
        <form id="loginForm" action="index.php" method="POST">
            <h2>Авторизация</h2>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Пароль" required>
            <button type="submit" name="login">Войти</button>
        </form>

        <!-- Форма регистрации -->
        <form id="registerForm" action="index.php" method="POST" style="display: none;">
            <h2>Регистрация</h2>
            <input type="text" name="username" placeholder="Имя" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Пароль" required>
            <input type="password" name="password_confirm" placeholder="Подтвердите пароль" required>
            <button type="submit" name="register">Зарегистрироваться</button>
        </form>
    </div>

    <script>
        // Функция для переключения между формами
        function toggleForms() {
            const loginForm = document.getElementById('loginForm');
            const registerForm = document.getElementById('registerForm');
            const formToggle = document.getElementById('formToggle');

            if (loginForm.style.display === 'none') {
                loginForm.style.display = 'block';
                registerForm.style.display = 'none';
                formToggle.textContent = 'Переключить на регистрацию';
            } else {
                loginForm.style.display = 'none';
                registerForm.style.display = 'block';
                formToggle.textContent = 'Переключить на авторизацию';
            }
        }
    </script>
</body>
</html>
