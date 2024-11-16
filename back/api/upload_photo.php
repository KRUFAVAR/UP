<?php
// Подключение к базе данных
require 'db.php'; // Подключение к базе данных

// Начало сессии, если необходимо
session_start();

// Предполагается, что данные о пользователе уже загружены в переменную $user

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['photo'])) {
    $file = $_FILES['photo'];
    $target_dir = "uploads2/";
    $target_file = $target_dir . basename($file["name"]);
    $uploadOk = 1;

    // Проверка, является ли файл изображением
    $check = getimagesize($file["tmp_name"]);
    if ($check === false) {
        echo "Файл не является изображением.";
        $uploadOk = 0;
    }

    // Проверка на наличие ошибок
    if ($file["error"] !== UPLOAD_ERR_OK) {
        echo "Ошибка при загрузке файла.";
        $uploadOk = 0;
    }

    // Проверка на размер файла и тип
    if ($uploadOk === 1 && move_uploaded_file($file["tmp_name"], $target_file)) {
        // Обновление информации о пользователе в базе данных
        $user->updatePhoto(basename($file["name"])); // Пример обновления
        echo "Фото успешно загружено.";
    } else {
        echo "Ошибка при загрузке фото.";
    }
}
?>
