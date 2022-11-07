<?php
include_once "../includes/db.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$productId = $_GET["id"];
$userId = $_SESSION["user"]["id"];

try {
    
    if (!$productId) {
        throw new Error("Id is required");
    }
    if (!$userId) {
        throw new Error("Must be logged in");
    }

    $dbInstance = DB::getInstance();
    $conn = $dbInstance->getConnection();

    $stmt = $conn->prepare("SELECT id FROM products WHERE published_by = ? AND id = ?");
    $stmt->bind_param("ii", $userId, $productId);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    
    $data = $result->fetch_assoc();
    if (!$data) {
        throw new Error("Permission denied");
    }

    $stmtDelete = $conn->prepare("DELETE FROM products WHERE id = ?");
    $stmtDelete->bind_param("i", $productId);
    $stmtDelete->execute();
    $stmtDelete->close();

    header("Location: ./");
} catch (Error $e) {
    echo $e->getMessage();
}