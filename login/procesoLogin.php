<?php

session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $ip = $_SERVER['REMOTE_ADDR'];
    $captcha = $_POST["g-recaptcha-response"];
    $secretkey = '6LfISmYiAAAAAPrfaOFWo9y7ojESAPMz96-SK4p2';

    $respuesta = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secretkey&response=$captcha&remoteip=$ip");

    $atributo = json_decode($respuesta, TRUE);


    if (!$atributo['success']){
        $_SESSION["loginError"] = "Verify captcha";
        header("Location: ./");
}
    else{
        if ($username !== "fcytuader" && $username !== "programacionavanzada") {
        $_SESSION["loginError"] = "Wrong username or password!";
        header("Location: ./");
    }   else {
        $_SESSION["username"] = $username;
        header("Location: ../");
     }
    }
}