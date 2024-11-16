<?php
header("Content-Type: application/json");

try {
    // Получение данных из запроса
    $data = json_decode(file_get_contents("php://input"), true);

    // Проверка корректности данных JSON
    if ($data === null) {
        throw new Exception("Некорректные данные JSON.");
    }

    // Подключение к базе данных
    $pdo = new PDO("mysql:host=localhost;dbname=uver;charset=utf8mb4", "root", "", [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);

    // Тип запроса из данных
    $queryType = $data["queryType"] ?? null;

    switch ($queryType) {
        case "1":
            // Запрос 1: Получить список всех изделий мастера
            if (empty($data["firstName"]) || empty($data["lastName"])) {
                throw new Exception("Не указаны имя и фамилия мастера.");
            }
            $stmt = $pdo->prepare("SELECT * FROM products p JOIN Jewelers j ON p.jeweler_id = j.jeweler_id WHERE j.first_name = :firstName AND j.last_name = :lastName");
            $stmt->execute(["firstName" => $data["firstName"], "lastName" => $data["lastName"]]);
            break;

        case "2":
            // Запрос 2: Получить список всех изделий дороже заданной суммы
            if (empty($data["priceLimit"])) {
                throw new Exception("Не указана сумма.");
            }
            $stmt = $pdo->prepare("SELECT * FROM products WHERE price > :priceLimit");
            $stmt->execute(["priceLimit" => $data["priceLimit"]]);
            break;

        // Дополнительно можно добавить запросы для других операций, например:
        // case "3":
        // case "4":
        // case "5":
        // и т.д.

        default:
            throw new Exception("Неизвестный тип запроса.");
    }

    // Получение и вывод результатов
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($results);

} catch (Exception $e) {
    // Обработка ошибок и возврат в JSON-формате
    echo json_encode(["error" => "Ошибка: " . $e->getMessage()]);
}
?>
