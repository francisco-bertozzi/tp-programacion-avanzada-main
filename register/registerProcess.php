<?php 
include_once "../includes/db.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    exit();
}

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$username = $_POST["username"];
$email = $_POST["email"];
$password = $_POST["password"];
$passwordRepeated = $_POST["passwordRepeated"];

// TODO check if username is unique

try {
    if (!$username) {
        throw new Error("Username is required");
    }
    
    $dbInstance = DB::getInstance();
    $conn = $dbInstance->getConnection();

    $userQuery = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $userQuery->bind_param("s", $username);
    $result = $userQuery->execute();
    $resultados = $userQuery->get_result();
    $userQuery->close();
    
    $data = $resultados->fetch_assoc();

    if ($data) {
        throw new Error("Username is already taken");
    }
    
    if (!$email) {
        throw new Error("Email is required");
    }

    if (!$password || !$passwordRepeated) {
        throw new Error("Password is required");
    }

    if ($password !== $passwordRepeated) {
        throw new Error("Password doesnt match");
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
    $query = $conn->prepare("INSERT INTO users (username, password, email) VALUES (?, ?, ?)");
    $query->bind_param("sss", $username, $hashedPassword, $email);
    $query->execute();
    $query->close();

    $_SESSION["registerSuccessful"] = true;
    header("Location: ./");
    exit();
} catch (Error $e) {
    $_SESSION["registerError"] = $e->getMessage();
    header("Location: ./");
    exit(); 
} catch (mysqli_sql_exception $sqlE) {
    echo $sqlE->getMessage();
}