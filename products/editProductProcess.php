<?php

include_once "../includes/db.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    exit();
}

$productId = $_POST["id"];
$title = $_POST["title"];
$price = $_POST["price"];
$description = $_POST["description"];
$category = $_POST["category"];

try {
    if (!$title) {
        throw new Error("Title is required");
    }
    if (!$price) {
        throw new Error("Price is required");
    }
    if (!$category) {
        throw new Error("Category is required");
    }
    if (!$productId) {
        throw new Error("Id is required");
    }

    $dbInstance = DB::getInstance();
    $conn = $dbInstance->getConnection();

    $sql = "UPDATE products
    SET title = ?, description = ?, price = ?, category_id = ?
    WHERE id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssdii", $title, $description, $price, $category, $productId);
    $stmt->execute();
    $stmt->close();
    header("Location: ./");
} catch (Error $e) {

}