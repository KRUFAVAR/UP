<?php
session_start();

// Удаление всех данных сессии
$_SESSION = array();

// Если требуется удалить сессионный куки
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Уничтожение сессии
session_destroy();

// Перенаправление на страницу авторизации
header("Location: ../baza/index.html");
exit();
?>
