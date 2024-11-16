<?php
// queryResult.php

// Убедитесь, что подключили к базе данных
$pdo = new PDO("mysql:host=localhost;dbname=uver", "root", "");

// Получаем параметры запроса
$queryType = $_GET['queryType'] ?? '';

if ($queryType == '1') {
    // Запрос по имени мастера
    $firstName = $_GET['firstName'] ?? '';
    $lastName = $_GET['lastName'] ?? '';

    // Запрос к базе данных
    $stmt = $pdo->prepare("
        SELECT p.product_id, p.name, p.material, p.price, p.year_of_creation
        FROM products p
        JOIN jewelers j ON p.jeweler_id = j.jeweler_id
        WHERE j.first_name LIKE :firstName AND j.last_name LIKE :lastName
    ");
    $stmt->execute([':firstName' => "%$firstName%", ':lastName' => "%$lastName%"]);
    $data = $stmt->fetchAll();

    echo "<h1>Результаты запроса: Продукты мастера $firstName $lastName</h1>";

    if (count($data) > 0) {
        foreach ($data as $item) {
            echo "<p><strong>Название продукта:</strong> {$item['name']}</p>";
            echo "<p><strong>Материал:</strong> {$item['material']}</p>";
            echo "<p><strong>Цена:</strong> {$item['price']}</p>";
            echo "<p><strong>Год создания:</strong> {$item['year_of_creation']}</p>";
            echo "<hr>";
        }
    } else {
        echo "<p>Продукты для указанного мастера не найдены.</p>";
    }

    echo '<a href="index.html"><button>Назад</button></a>';
}elseif ($queryType == '2') {
    // Запрос по цене
    $priceLimit = $_GET['priceLimit'] ?? '';

    $stmt = $pdo->prepare("SELECT * FROM products WHERE price <= :priceLimit");
    $stmt->execute([':priceLimit' => $priceLimit]);
    $data = $stmt->fetchAll();

    echo "<h1>Результаты запроса: Поиск по цене</h1>";
    foreach ($data as $item) {
        echo "<p>Название изделия: {$item['name']}</p>";
        echo "<p>Цена: {$item['price']} руб.</p>";
        // Дополнительные данные
    }
    echo '<a href="index.html"><button>Назад</button></a>';
}elseif ($queryType == '3') {
    // Запрос по имени клиента
    $username = $_GET['username'] ?? '';

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username LIKE :username");
    $stmt->execute([':username' => "%$username%"]);
    $data = $stmt->fetchAll();

    echo "<h1>Результаты запроса: Поиск по имени клиента</h1>";
    foreach ($data as $item) {
        echo "<p>Имя клиента: {$item['username']}</p>";
        echo "<p>Email: {$item['email']}</p>";
        // Дополнительные данные
    }
    echo '<a href="index.html"><button>Назад</button></a>';
    
}elseif ($queryType == '4') {
    // Запрос по заказам мастера
    $firstName = $_GET['firstName'] ?? '';
    $lastName = $_GET['lastName'] ?? '';

    // Подготовка запроса для получения всех заказов определенного мастера
    $stmt = $pdo->prepare("
        SELECT o.order_id, o.order_date, o.total_price, p.name AS product_name
        FROM Orders o
        JOIN CartItems ci ON o.order_id = ci.cart_id
        JOIN Products p ON ci.product_id = p.product_id
        JOIN Jewelers j ON p.jeweler_id = j.jeweler_id
        WHERE j.first_name LIKE :firstName AND j.last_name LIKE :lastName
    ");
    $stmt->execute([':firstName' => "%$firstName%", ':lastName' => "%$lastName%"]);
    $data = $stmt->fetchAll();

    // Выводим результаты
    echo "<h1>Результаты запроса: Заказы, выполненные мастером</h1>";
    if (count($data) > 0) {
        foreach ($data as $item) {
            echo "<p>Номер заказа: {$item['order_id']}</p>";
            echo "<p>Дата заказа: {$item['order_date']}</p>";
            echo "<p>Общая стоимость: {$item['total_price']} руб.</p>";
            echo "<p>Название изделия: {$item['product_name']}</p>";
            echo "<hr>";
        }
        echo '<a href="index.html"><button>Назад</button></a>';
    } else {
        echo "<p>Нет заказов для указанного мастера.</p>";
    }
}elseif ($queryType == '5') {
    // Запрос по материалам товаров и количеству заказов
    $stmt = $pdo->prepare("
        SELECT c.name AS category_name, COUNT(ci.cart_id) AS total_orders
            FROM Cart_Items ci
        JOIN Products p ON ci.product_id = p.product_id
        JOIN Category c ON p.category_id = c.id
        JOIN Cart cart ON ci.cart_id = cart.cart_id
        GROUP BY c.name;
    ");
    $stmt->execute();
    $data = $stmt->fetchAll();

    echo "<h1>Результаты запроса: Заказы по материалам</h1>";
    if (count($data) > 0) {
        foreach ($data as $item) {
            echo "<p>Категория: {$item['category_name']}</p>";
            echo "<p>Количество заказов: {$item['total_orders']}</p>";
            echo "<hr>";
        }
        echo '<a href="index.html"><button>Назад</button></a>';
    } else {
        echo "<p>Нет данных по материалам.</p>";
    }
}elseif ($queryType == '6') {
    // Запрос для получения клиентов с суммой заказов больше заданной
    $stmt = $pdo->prepare("
        SELECT c.user_id, u.username, SUM(ci.price * ci.quantity) AS total_spent
        FROM Cart c
        JOIN Cart_Items ci ON c.cart_id = ci.cart_id
        JOIN Users u ON c.user_id = u.user_id
        GROUP BY c.user_id
        HAVING total_spent > :threshold
    ");
    
    // Передаем значение threshold из URL
    $stmt->execute([':threshold' => $_GET['threshold']]);
    $data = $stmt->fetchAll();

    // Выводим результаты
    echo "<h1>Результаты запроса: Клиенты с суммой заказов больше {$_GET['threshold']}</h1>";
    if (count($data) > 0) {
        foreach ($data as $item) {
            echo "<p>Имя клиента: {$item['username']}</p>";
            echo "<p>Общая сумма заказов: {$item['total_spent']} руб.</p>";
            echo "<hr>";
        }
        echo '<a href="index.html"><button>Назад</button></a>';
    } else {
        echo "<p>Нет клиентов с суммой заказов больше {$_GET['threshold']}.</p>";
    }
}elseif($queryType == '7'){
    $year = $_GET['year'] ?? '';  // Заданный год из параметров GET запроса

    // Подключаемся к базе данных
    $pdo = new PDO("mysql:host=localhost;dbname=uver", "root", "");

    // Подготовка запроса
    $stmt = $pdo->prepare("
    SELECT product_id, name, material, price, year_of_creation
    FROM products
    WHERE year_of_creation > :year
    ");

    // Выполнение запроса с параметром года
    $stmt->execute([':year' => $year]);

    // Получаем результаты
    $data = $stmt->fetchAll();

    // Выводим результаты
    echo "<h1>Результаты запроса: Изделия с годом выпуска позже {$year}</h1>";
    if (count($data) > 0) {
    foreach ($data as $item) {
        echo "<p>Название изделия: {$item['name']}</p>";
        echo "<p>Материал: {$item['material']}</p>";
        echo "<p>Цена: {$item['price']} руб.</p>";
        echo "<p>Год выпуска: {$item['year_of_creation']}</p>";
        echo "<hr>";
    }
    echo '<a href="index.html"><button>Назад</button></a>';
    } else {
    echo "<p>Нет изделий с годом выпуска позднее {$year}.</p>";
    }
}elseif ($queryType == '8') {
    $startDate = $_GET['startDate'] ?? null;
    $endDate = $_GET['endDate'] ?? null;

    if ($startDate && $endDate) {
        $stmt = $pdo->prepare("
            SELECT c.cart_id, c.user_id, ci.product_id, c.created_at, ci.quantity, ci.price
            FROM Cart c
            JOIN Cart_Items ci ON c.cart_id = ci.cart_id
            WHERE c.created_at BETWEEN :startDate AND :endDate
        ");
        $stmt->execute([':startDate' => $startDate, ':endDate' => $endDate]);
        $data = $stmt->fetchAll();

        // Вывод результатов
        echo "<h1>Результаты запроса: Корзины с датой создания между {$startDate} и {$endDate}</h1>";
        if (count($data) > 0) {
            foreach ($data as $item) {
                echo "<p>Номер корзины: {$item['cart_id']}</p>";
                echo "<p>Идентификатор клиента: {$item['user_id']}</p>";
                echo "<p>Идентификатор товара: {$item['product_id']}</p>";
                echo "<p>Дата создания: {$item['created_at']}</p>";
                echo "<p>Количество: {$item['quantity']}</p>";
                echo "<p>Цена: {$item['price']} руб.</p>";
                echo "<hr>";
            }
            echo '<a href="index.html"><button>Назад</button></a>';
        } else {
            echo "<p>Нет данных за указанный период.</p>";
        }
    } else {
        echo "<p>Не указаны начальная и конечная даты.</p>";
    }
}elseif ($queryType == '9') {
    // Запрос для получения списка всех изделий, сгруппированных по материалу
    $stmt = $pdo->prepare("SELECT material, COUNT(product_id) AS total_products FROM products GROUP BY material");
    $stmt->execute();
    $data = $stmt->fetchAll();

    // Выводим результаты
    echo "<h1>Результаты запроса: Изделия, сгруппированные по материалу</h1>";
    if (count($data) > 0) {
        foreach ($data as $item) {
            echo "<p>Материал: {$item['material']}</p>";
            echo "<p>Количество изделий: {$item['total_products']}</p>";
            echo "<hr>";
        }
        echo '<a href="index.html"><button>Назад</button></a>';
    } else {
        echo "<p>Нет данных по материалам.</p>";
    }
}elseif ($queryType == '10') {
    // Получаем специализацию из параметра запроса
    $specialization = $_GET['specialization'] ?? '';

    // Подготовка запроса для получения мастеров по специализации
    $stmt = $pdo->prepare("
        SELECT j.jeweler_id, j.first_name, j.last_name, j.specialization
        FROM Jewelers j
        JOIN products p ON j.jeweler_id = p.jeweler_id
        WHERE j.specialization = :specialization
        GROUP BY j.jeweler_id
    ");
    $stmt->execute([':specialization' => $specialization]);
    $data = $stmt->fetchAll();

    // Выводим результаты
    echo "<h1>Результаты запроса: Мастера по специализации '$specialization'</h1>";
    if (count($data) > 0) {
        foreach ($data as $item) {
            echo "<p>Мастер: {$item['first_name']} {$item['last_name']}</p>";
            echo "<p>Специализация: {$item['specialization']}</p>";
            echo "<hr>";
        }
        echo '<a href="index.html"><button>Назад</button></a>';
    } else {
        echo "<p>Нет мастеров с такой специализацией '$specialization'.</p>";
    }
}else {
    echo "<p>Неверный запрос!</p>";
}
?>