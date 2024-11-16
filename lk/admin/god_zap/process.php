<?php
header("Content-Type: application/json");

try {
    $pdo = new PDO("mysql:host=localhost;dbname=uver;charset=utf8mb4", "root", "", [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);

    $queryType = $_POST["queryType"] ?? null;

    switch ($queryType) {
        case "1":
            // Запрос 1: Список всех изделий мастера
            $stmt = $pdo->prepare("
                SELECT * 
                FROM products p
                JOIN Jewelers j ON p.jeweler_id = j.jeweler_id
                WHERE j.first_name = :firstName AND j.last_name = :lastName
            ");
            $stmt->execute([
                'firstName' => $_POST["firstName"],
                'lastName' => $_POST["lastName"]
            ]);
            break;

        case "2":
            // Запрос 2: Изделия дороже заданной суммы
            $stmt = $pdo->prepare("
                SELECT * FROM products WHERE price > :priceLimit
            ");
            $stmt->execute(['priceLimit' => $_POST["priceLimit"]]);
            break;

        case "3":
            // Запрос 3: Список заказов клиента
            $stmt = $pdo->prepare("
                SELECT * 
                FROM orders o
                JOIN clients c ON o.client_id = c.client_id
                WHERE c.first_name = :firstName AND c.last_name = :lastName
            ");
            $stmt->execute([
                'firstName' => $_POST["firstName"],
                'lastName' => $_POST["lastName"]
            ]);
            break;

        case "4":
            // Запрос 4: Список заказов мастера
            $stmt = $pdo->prepare("
                SELECT * 
                FROM orders o
                JOIN products p ON o.product_id = p.product_id
                WHERE p.jeweler_id = :jewelerId
            ");
            $stmt->execute(['jewelerId' => $_POST["jewelerId"]]);
            break;

        case "5":
            // Запрос 5: Сгруппировать заказы по типу изделия
            $stmt = $pdo->prepare("
                SELECT item_type, COUNT(*) AS order_count
                FROM products p
                JOIN orders o ON p.product_id = o.product_id
                GROUP BY item_type
            ");
            $stmt->execute();
            break;

        case "6":
            // Запрос 6: Список клиентов с заказами выше определенной суммы
            $stmt = $pdo->prepare("
                SELECT * 
                FROM clients c
                JOIN orders o ON c.client_id = o.client_id
                GROUP BY c.client_id
                HAVING SUM(o.total_price) > :orderSum
            ");
            $stmt->execute(['orderSum' => $_POST["orderSum"]]);
            break;

        case "7":
            // Запрос 7: Список изделий с годом выпуска после указанного
            $stmt = $pdo->prepare("
                SELECT * 
                FROM products
                WHERE year > :creationYear
            ");
            $stmt->execute(['creationYear' => $_POST["creationYear"]]);
            break;

        case "8":
            // Запрос 8: Заказы в пределах временного интервала
            $stmt = $pdo->prepare("
                SELECT * 
                FROM orders
                WHERE order_date BETWEEN :startDate AND :endDate
            ");
            $stmt->execute([
                'startDate' => $_POST["startDate"],
                'endDate' => $_POST["endDate"]
            ]);
            break;

        case "9":
            // Запрос 9: Изделия, сгруппированные по материалу
            $stmt = $pdo->prepare("
                SELECT material, COUNT(*) AS product_count
                FROM products
                GROUP BY material
            ");
            $stmt->execute();
            break;

        case "10":
            // Запрос 10: Мастера, выполняющие определенные типы изделий
            $stmt = $pdo->prepare("
                SELECT j.first_name, j.last_name
                FROM Jewelers j
                JOIN products p ON j.jeweler_id = p.jeweler_id
                WHERE p.item_type = :itemType
            ");
            $stmt->execute(['itemType' => $_POST["itemType"]]);
            break;

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
