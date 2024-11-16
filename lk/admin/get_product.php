<?php
$host = 'localhost';
$db = 'uver';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Ошибка подключения: " . $e->getMessage());
}

$product_id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM products WHERE product_id = :product_id");
$stmt->execute(['product_id' => $product_id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

echo json_encode($product);
?>
