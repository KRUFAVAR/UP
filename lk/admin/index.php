<?php
session_start();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Админ-панель</title>
    <style>
        /* Общие стили */
body {
    font-family: 'Arial', sans-serif;
    background-color: #f7f8fa;
    color: #333;
    margin: 0;
    padding: 0;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: flex-start;
    min-height: 100vh;
}

/* Заголовок */
h1 {
    font-size: 2rem;
    color: #444;
    margin: 20px 0;
    text-align: center;
}

/* Навигация */
nav {
    margin-top: 20px;
    width: 100%;
    background-color: #ffffff;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

nav ul {
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 10px 0;
    list-style: none;
    margin: 0;
}

nav ul li {
    margin: 0 15px;
}

nav ul li a {
    text-decoration: none;
    font-size: 1rem;
    color: #007bff;
    padding: 8px 12px;
    transition: background-color 0.3s, color 0.3s;
    border-radius: 4px;
}

nav ul li a:hover {
    background-color: #e6f0ff;
    color: #0056b3;
}

/* Адаптивность */
@media (max-width: 768px) {
    nav ul {
        flex-direction: column;
        align-items: flex-start;
        padding-left: 20px;
    }

    nav ul li {
        margin: 10px 0;
    }
}

    </style>
</head>
<body>
    <h1>Добро пожаловать в админ-панель</h1>
    <nav>
        <ul>
            <li><a href="users.php">Управление пользователями</a></li>
            <li><a href="reviews.php">Управление отзывами</a></li>
            <li><a href="products.php">Управление продуктами</a></li>
            <li><a href="god_zap/index.html">Готовые запросы</a></li>
            <li><a href="logout.php">Выйти</a></li>
        </ul>
    </nav>
</body>
</html>