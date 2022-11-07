<?php

include_once "../includes/db.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    exit();
}

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

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

    $dbInstance = DB::getInstance();
    $conn = $dbInstance->getConnection();

    $stmt = $conn->prepare("INSERT INTO products(title, description, price, published_by, category_id) VALUES(?,?,?,?,?)");
    $stmt->bind_param("ssdii", $title, $description, $price, $_SESSION["user"]["id"], $category);
    $stmt->execute();
    $stmt->close();
    header("Location: ./");
} catch (Error $e) {

}