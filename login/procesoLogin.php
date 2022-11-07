<?php

include_once "../includes/db.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $token = $_POST["token"];

    $ip = $_SERVER['REMOTE_ADDR'];
    $captcha = $_POST["g-recaptcha-response"];
    $secretkey = '6LfISmYiAAAAAPrfaOFWo9y7ojESAPMz96-SK4p2';

    $respuesta = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secretkey&response=$captcha&remoteip=$ip");

    $atributo = json_decode($respuesta, TRUE);

    if (!$atributo['success']) {
        $_SESSION["loginError"] = "Verify captcha";
        header("Location: ./");
        exit();
    }
    
    if ($token !== $_SESSION["token"]) {
        $_SESSION["loginError"] = "Invalid token";
        header("Location: ./");
        exit();
    }

    // if ($username !== "fcytuader" && $username !== "programacionavanzada") {
    //     $_SESSION["loginError"] = "Wrong username or password!";
    //     header("Location: ./");
    //     exit();
    // }

    if (!$username || !$password) {
        $_SESSION["loginError"] = "Username and password must be provided";
        header("Location: ./");
        exit();
    }

    $dbInstance = DB::getInstance();
    $conn = $dbInstance->getConnection();
    $loginStatement = $conn->prepare("SELECT id, password, email FROM users WHERE username = ?");
    $loginStatement->bind_param("s", $username);
    $loginStatement->execute();
    $result = $loginStatement->get_result();
    $loginStatement->close();
    $data = $result->fetch_assoc();
    
    if (!$data) {
        $_SESSION["loginError"] = "Wrong username or password";
        header("Location: ./");
        exit();
    }

    $passwordHash = $data["password"];
    $id = $data["id"];
    $email = $data["email"];

    if(!password_verify($password, $data["password"])) {
        $_SESSION["loginError"] = "Wrong username or password";
        header("Location: ./");
        exit();
    }
    
    $_SESSION["user"] = [
        "username" => $username,
        "id" => $id,
        "email" => $email
    ];
    header("Location: ../home");
}