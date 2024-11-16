<?php
include '../includes/db.php';

session_start();
$user_id = $_SESSION['user_id'];
$review_id = $_GET['id'];

$stmt = $pdo->prepare("DELETE FROM review WHERE id = ? AND user_id = ?");
$stmt->execute([$review_id, $user_id]);

header("Location: reviews.php");
exit;
?>
